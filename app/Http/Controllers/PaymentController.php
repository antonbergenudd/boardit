<?php

namespace boardit\Http\Controllers;

use boardit\DiscountCode;
use boardit\ProductOrder;
use boardit\Http\Requests\PaymentSubmitRequest;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Carbon\Carbon;

use boardit\Product;
use boardit\User;

use boardit\Order;

use Stripe\Stripe;

use Twilio\Rest\Client;
use Gloudemans\Shoppingcart\Facades\Cart;

// https://github.com/Crinsane/LaravelShoppingcart#usage
// https://github.com/stripe/stripe-php
class PaymentController extends BaseController
{
    function index() {
        $cart = Cart::content();
        $cartTotal = Cart::subtotal();

        if(env('KLARNA_TEST')) {
            $merchantId = env('KLARNA_TEST_USERNAME');
            $sharedSecret = env('KLARNA_TEST_PASSWORD');
            $apiEndpoint = \Klarna\Rest\Transport\ConnectorInterface::EU_TEST_BASE_URL;
        } else {
            $merchantId = env('KLARNA_USERNAME');
            $sharedSecret = env('KLARNA_PASSWORD');
            $apiEndpoint = \Klarna\Rest\Transport\ConnectorInterface::EU_BASE_URL;
        }

        /*
        EU_BASE_URL = 'https://api.klarna.com'
        EU_TEST_BASE_URL = 'https://api.playground.klarna.com'
        NA_BASE_URL = 'https://api-na.klarna.com'
        NA_TEST_BASE_URL = 'https://api-na.playground.klarna.com'
        */

        $connector = \Klarna\Rest\Transport\GuzzleConnector::create(
            $merchantId,
            $sharedSecret,
            $apiEndpoint
        );

        // Add product - order relation
        $order_lines = [];
        foreach(Cart::content() as $row) {
            $product = $row->model;

            $price = str_replace('.', '', $product->price) . '00';
            $price_tax = $price * 0.25 . '';

            $order_lines[] = [
                "type" => "physical",
                "reference" => "123050",
                "name" => $product->name,
                "quantity" => 1,
                "quantity_unit" => "st",
                "unit_price" => $price,
                "tax_rate" => 0,
                "total_amount" => $price,
                "total_tax_amount" => 0,
            ];
        }

        // dd(str_replace('.', '', $cartTotal) + str_replace('.', '', $cartTotal) * 0.25 . '');
        $order = [
            "purchase_country" => "se",
            "purchase_currency" => "sek",
            "locale" => "sv-SE",
            "order_amount" => str_replace('.', '', $cartTotal),
            "order_tax_amount" => 0,
            "order_lines" => $order_lines,
            "options" => [
                "require_validate_callback_success" => true,
            ],
            "merchant_urls" => [
                "terms" => "https://www.example.com/terms.html",
                "cancellation_terms" => "https://www.example.com/terms/cancellation.html",
                "checkout" => "https://www.example.com/checkout.html",
                "confirmation" => route('payment.feedback') . "?sid={checkout.order.id}", // När order är bekräftad
                // Callbacks
                "push" => "https://boarditgames.se/api/order/push?sid={checkout.order.id}",
                "validation" => "https://boarditgames.se/api/order/validate?sid={checkout.order.id}", // Bekräftar order först
                // "shipping_option_update" => "https://www.example.com/api/shipment",
                // "address_update" => "https://www.example.com/api/address",
                // "notification" => "https://www.example.com/api/pending",
                // "country_change" => "https://www.example.com/api/country"
            ]
        ];

        try {
            $checkout = new \Klarna\Rest\Checkout\Order($connector);
            $checkout->create($order);

            // Store checkout order id
            $orderId = $checkout->getId();

            $html_snippet = $checkout['html_snippet'];

            return view('payment.index', compact('cart', 'cartTotal', 'html_snippet'));

        } catch (Exception $e) {
            return redirect()->route('payment.index')->withErrors([
                'Någonting gick fel i betalningen'
            ]);
        }
    }

    function feedback(Request $request) {
        if(env('KLARNA_TEST')) {
            $merchantId = env('KLARNA_TEST_USERNAME');
            $sharedSecret = env('KLARNA_TEST_PASSWORD');
            $apiEndpoint = \Klarna\Rest\Transport\ConnectorInterface::EU_TEST_BASE_URL;
        } else {
            $merchantId = env('KLARNA_USERNAME');
            $sharedSecret = env('KLARNA_PASSWORD');
            $apiEndpoint = \Klarna\Rest\Transport\ConnectorInterface::EU_BASE_URL;
        }

        /*
        EU_BASE_URL = 'https://api.klarna.com'
        EU_TEST_BASE_URL = 'https://api.playground.klarna.com'
        NA_BASE_URL = 'https://api-na.klarna.com'
        NA_TEST_BASE_URL = 'https://api-na.playground.klarna.com'
        */

        $connector = \Klarna\Rest\Transport\GuzzleConnector::create(
            $merchantId,
            $sharedSecret,
            $apiEndpoint
        );

        try {
            $checkout = new \Klarna\Rest\Checkout\Order($connector, $request->sid);
            $checkout->fetch();

            $html_snippet = $checkout['html_snippet'];

            // Get some data if needed
            return view('payment.feedback', compact('html_snippet'));
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    function checkDiscount($discount_code, $total) {
        if($discount_code) {
            $code = DiscountCode::where('code', $discount_code)->first();

            if(isset($code)) {
                $total = $total * ($code->amount / 100);
            }
        }

        return $total;
    }

    function controlDiscount(Request $request) {
        $code = $request->code;

        if($code) {
            $code = DiscountCode::where('code', $code)->first();

            if(isset($code)) {
                return $code->amount;
            }
        }

        return null;
    }

    function removeDiscountCode($discount_code) {
        $code = DiscountCode::where('code', $discount_code)->first();
        $code->delete();
    }

    private function checkProductStock() {
        $stock_ok = true;

        // Add product - order relation
        foreach(Cart::content() as $row) {
            $product = $row->model;
            if($product->quantity == 0) {
                $stock_ok = false;
            }
        }

        return $stock_ok;
    }

    function submitKlarna() {
        if(strtolower($request->city) == 'lund') {
            if(! $this->checkProductStock()) {
                Cart::destroy();

                return redirect()->route('payment.feedback')->withErrors([
                    'Tyvärr så hann någon beställa samma produkt som dig innan din beställning gick igenom.'
                ]);
            }

            $deliverance_date = Carbon::parse("{$request->date} {$request->date_hour}:{$request->date_minute}:00");
            $code = str_random(12);

            // Save for delayed purchase
            $customer = \Stripe\Customer::create([
                'source' => $request->stripeToken,
                'email' => $request->email,
            ]);

            $order = new Order;
            $order->payment_token = $customer->id;
            $order->code = $code;
            $order->address = $request->street.', '.$request->postcode.', '.$request->city;
            $order->email = isset($request->email) ? $request->email : NULL;
            $order->phone = isset($request->tel) ? $request->tel : NULL;
            $order->payment = $this->checkDiscount($request->discount_code, str_replace(".00", "", Cart::subTotal() + 30)); // Addon för utkörning
            $order->payment_type = Order::PAYMENT_CARD;
            $order->deliverance_date = $deliverance_date;
            $order->note = $request->note;
            $order->status = Order::PROCESSING;
            $order->save();

            // Add product - order relation
            foreach(Cart::content() as $row) {
                $product = $row->model;
                $orderToProduct = new ProductOrder;

                // Random product
                if($product->id == 14) {
                    $items = Product::where('quantity', '>=', 0)->get();
                    do {
                        $item_id = array_rand($items->toArray());
                    } while($item_id == 14);
                    $product = $items[$item_id];
                }

                // Remove item from stock
                if($product->quantity) {
                    $product->quantity--;
                }

                $orderToProduct->product_id = $product->id;
                $orderToProduct->order_id = $order->id;

                $orderToProduct->save();
                $product->save();
            }

            // add 4 hours to bypass UTC time
            if(Carbon::now('Europe/Stockholm')->addHours('2')->gt($deliverance_date)) {
                $this->notifyThroughSms($order, 1);
            } else {
                $this->notifyThroughSms($order, 2);
            }

            Cart::destroy();

            return redirect()->route('payment.feedback')->with(['code' => $code, 'order_id' => $order->id]);
        } else {
            return redirect()->route('payment.feedback')->withErrors([
                'Tyvärr kör vi inte ut till ditt område.'
            ]);
        }
    }

    function submit(PaymentSubmitRequest $request) {
        if(env('STRIPE_TEST_MODE')) {
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_PROD_KEY'));
        }

        if(strtolower($request->city) == 'lund') {
            if(isset($request->payment_by_swish)) {
                //
            } else if(isset($request->payment_by_card)) {

                if(! $this->checkProductStock()) {
                    Cart::destroy();

                    return redirect()->route('payment.feedback')->withErrors([
                        'Tyvärr så hann någon beställa samma produkt som dig innan din beställning gick igenom.'
                    ]);
                }

                $deliverance_date = Carbon::parse("{$request->date} {$request->date_hour}:{$request->date_minute}:00");
                $code = str_random(12);

                // Save for delayed purchase
                $customer = \Stripe\Customer::create([
                    'source' => $request->stripeToken,
                    'email' => $request->email,
                ]);

                $order = new Order;
                $order->payment_token = $customer->id;
                $order->code = $code;
                $order->address = $request->street.', '.$request->postcode.', '.$request->city;
                $order->email = isset($request->email) ? $request->email : NULL;
                $order->phone = isset($request->tel) ? $request->tel : NULL;
                $order->payment = $this->checkDiscount($request->discount_code, str_replace(".00", "", Cart::subTotal() + 30)); // Addon för utkörning
                $order->payment_type = Order::PAYMENT_CARD;
                $order->deliverance_date = $deliverance_date;
                $order->note = $request->note;
                $order->status = Order::PROCESSING;
                $order->save();

                // Add product - order relation
                foreach(Cart::content() as $row) {
                    $product = $row->model;
                    $orderToProduct = new ProductOrder;

                    // Random product
                    if($product->id == 14) {
                        $items = Product::where('quantity', '>=', 0)->get();
                        do {
                            $item_id = array_rand($items->toArray());
                        } while($item_id == 14);
                        $product = $items[$item_id];
                    }

                    // Remove item from stock
                    if($product->quantity) {
                        $product->quantity--;
                    }

                    $orderToProduct->product_id = $product->id;
                    $orderToProduct->order_id = $order->id;

                    $orderToProduct->save();
                    $product->save();
                }

                // add 4 hours to bypass UTC time
                if(Carbon::now('Europe/Stockholm')->addHours('2')->gt($deliverance_date)) {
                    $this->notifyThroughSms($order, 1);
                } else {
                    $this->notifyThroughSms($order, 2);
                }

                Cart::destroy();

                return redirect()->route('payment.feedback')->with(['code' => $code, 'order_id' => $order->id]);
            }
        } else {
            return redirect()->route('payment.feedback')->withErrors([
                'Tyvärr kör vi inte ut till ditt område.'
            ]);
        }
    }

    private function notifyThroughSms($order, $errand)
    {
        if(env('SEND_SMS')) {
            $productsString = '';
            foreach($order->getProducts as $product) {
                $productsString .= "\r\n{$product->name}";
            }

            if($errand == 1) {
                $this->sendSms(
                    "En order har skapats!" .
                    "\r\nSnabbt ärende." .
                    "\r\nLevereras inom 2 timmar från svar." .
                    "\r\nReferenskod: " . $order->code .
                    "\r\nProdukter: " .$productsString .
                    "\r\nAdress: " . $order->address .
                    "\r\nSvara JA för att bekräfta order."
                );
            } else if($errand == 2) {
                $this->sendSms(
                    "En order har skapats!" .
                    "\r\nFramtida ärende." .
                    "\r\nReferenskod: " . $order->code .
                    "\r\nDatum: " . $order->deliverance_date .
                    "\r\nHar du möjlighet att leverera beställningen vid detta datum?" .
                    "\r\nSvara JA för att bekräfta beställning."
                );
            }
        }
    }

    protected function sendSms($message)
    {
        if(env('TWILIO_TEST')) {
            $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
            $authToken = env('TWILIO_AUTH_TOKEN_TEST');
        } else {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
        }

        $client = new Client($accountSid, $authToken);

        // Send out to all delivering employees
        foreach(User::where('delivering', 1)->where('phone', '!=', 0)->get() as $employee) {
            $phone = $employee->phone;

            if(substr($phone, 0, 1) == '0') {
                $phone = substr_replace($phone, '+46', 0, 1);
            }

            try {
                $message = $client->messages->create(
                    $phone,
                    [
                        "body" => $message,
                        "from" => env('TWILIO_TEST') ? env('TWILIO_NUMBER_TEST') : env('TWILIO_NUMBER')
                    ]
                );
            } catch (TwilioException $e) {
                echo  $e;
            }
        }
    }
}
