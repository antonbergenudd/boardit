<?php

namespace boardit\Http\Controllers;

use boardit\DiscountCode;
use boardit\ProductOrder;

use boardit\Http\Requests\PaymentSubmitRequest;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Carbon\Carbon;

use boardit\Product;
use boardit\User;

use boardit\Order;

use Stripe\Stripe;

use Twilio\Rest\Client;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Handles logic around payments.
 *
 * @see https://github.com/Crinsane/LaravelShoppingcart#usage The shopping cart
 * @see https://github.com/stripe/stripe-php Stripe payment
 */
class PaymentController extends BaseController
{
    /**
     * View payment index page.
     *
     * @return void
     */
    function index() {
        $cart = Cart::content();
        $cartTotal = Cart::subtotal();

        return view('payment.index', compact('cart', 'cartTotal'));
    }

    /**
     * View feedback page.
     *
     * @return void
     */
    function feedback() {
        return view('payment.feedback');
    }

    /**
     * Control discount code. Return new total
     * @param string|null $discount_code
     * @param int $total
     *
     * @return int|null
     */
    function checkDiscount(?string $discount_code,int $total) : ?int {
        if($discount_code) {
            $code = DiscountCode::where('code', $discount_code)->first();

            if(isset($code)) {
                $total = $total * ($code->amount / 100);
            }
        }

        return $total;
    }

    /**
     * Control discount code. Return value of discount code
     * @param Request $request
     *
     * @return int|null
     */
    function controlDiscount(Request $request) : ?int {
        $code = $request->code;

        if($code) {
            $code = DiscountCode::where('code', $code)->first();

            if(isset($code)) {
                return $code->amount;
            }
        }

        return null;
    }

    /**
     * Removes discount code.
     * @param string $discount_code
     *
     * @return void
     */
    function removeDiscountCode(string $discount_code) : void {
        $code = DiscountCode::where('code', $discount_code)->first();
        $code->delete();
    }

    /**
     * Controls cart product's in stock.
     *
     * @return bool
     */
    private function checkCartProductStock() : bool {
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

    /**
     * Construct a payment request.
     * @param PaymentSubmitRequest $request
     *
     * @return RedirectResponse
     */
    function submit(PaymentSubmitRequest $request) : RedirectResponse {
        if(env('STRIPE_TEST_MODE')) {
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_PROD_KEY'));
        }

        if(strtolower($request->city) == 'lund') {
            if(isset($request->payment_by_swish)) {
                //
            } else if(isset($request->payment_by_card)) {
                if(! $this->checkCartProductStock()) {
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

    /**
     * Notify employee through sms.
     * @param Order $order
     * @param int $errand Type of sms to send
     *
     * @return void
     */
    private function notifyThroughSms(Order $order, int $errand) : void
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

    /**
     * Perform an sms.
     * @param string $message
     *
     * @return void
     */
    protected function sendSms(string $message) : void
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
