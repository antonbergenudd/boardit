<?php

namespace boardit\Http\Controllers;

use boardit\ProductOrder;
use boardit\Http\Requests\PaymentSubmitRequest;

use Illuminate\Routing\Controller as BaseController;

use boardit\Product;

use Illuminate\Http\Request;

use \Cart;
use boardit\Order;

use Stripe\Charge;
use Stripe\Stripe;

// https://github.com/Crinsane/LaravelShoppingcart#usage
// https://github.com/stripe/stripe-php
class PaymentController extends BaseController
{
    function index() {
        $cart = Cart::content();
        $cartTotal = Cart::subtotal();

        return view('payment.index', compact('cart', 'cartTotal'));
    }

    function submit(PaymentSubmitRequest $request) {

        if(env('STRIPE_TEST_MODE')) {
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_PROD_KEY'));
        }

        // Generate code and save payment to database
        $code = str_random(12);
        $order = new Order;

        $payment_ok = 0;
        if(strtolower($request->city) == 'karlstad') {

            foreach(Cart::content() as $product) {
                if($product->id == 15) {
                    $order->collect = 1;
                }

                if($product->id == 16) {
                    $order->deliver = 1;
                }
            }

            if(isset($request->payment_by_swish)) {
                $order->code = $code;
                $order->address = $request->street.', '.$request->postcode.', '.$request->city;
                $order->email = isset($request->email) ? $request->email : NULL;
                $order->phone = isset($request->tel) ? $request->tel : NULL;
                $order->payment = $total;
                $order->payment_type = 'swish';
                $order->note = $request->note;
                $order->save();

                $payment_ok = 1;
            } else if(isset($request->payment_by_card)) {
                $total = str_replace(".00", "", Cart::subTotal());
                $charge = Charge::create([
                    'amount' => $total * 100,
                    'currency' => 'sek',
                    'description' => 'Beställning av spel',
                    'source' => $request->stripeToken,
                    'receipt_email' => $request->email,
                ]);

                if($charge->status == 'succeeded') {
                    $order->code = $code;
                    $order->address = $request->street.', '.$request->postcode.', '.$request->city;
                    $order->email = isset($request->email) ? $request->email : NULL;
                    $order->phone = isset($request->tel) ? $request->tel : NULL;
                    $order->payment = $total;
                    $order->payment_type = 'card';
                    $order->note = $request->note;
                    $order->save();

                    $payment_ok = 1;
                } else {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                       '' => ['Betalningen misslyckades'],
                    ]);

                    throw $error;
                }
            }

            if($payment_ok) {
                foreach(Cart::content() as $row) {
                    $product = $row->model;
                    $orderToProduct = new ProductOrder;

                    if($product->id == 14) {
                        $items = Product::where('quantity', '>=', 0)->get();
                        do {
                            $item_id = array_rand($items->toArray());
                        } while($item_id == 14);

                        $product = $items[$item_id];
                    }

                    $orderToProduct->product_id = $product->id;
                    $orderToProduct->order_id = $order->id;

                    // Remove item from DB
                    if($product->quantity) {
                        $product->quantity--;
                    }

                    $product->save();

                    $orderToProduct->save();
                }

                Cart::destroy();

                return back()->with([
                    'code' => $code,
                ]);
            }
        } else {
            return back()->withErrors([
                'Tyvärr kör vi inte ut till din stad just nu, oroa dig inte, ingen betalning har utförts.'
            ]);
        }
    }
}
