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

        if(isset($request->payment_by_swish)) {
            // Swish
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
                $order->address = $request->address;
                $order->email = isset($request->email) ? $request->email : NULL;
                $order->phone = isset($request->tel) ? $request->tel : NULL;
                $order->payment = $total;
                $order->payment_type = 'card';
                $order->save();
            } else {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                   '' => ['Betalningen misslyckades'],
                ]);

                throw $error;
            }
        }

        foreach(Cart::content() as $row) {
            $product = $row->model;
            $orderToProduct = new ProductOrder;
            $orderToProduct->product_id = $product->id;
            $orderToProduct->order_id = $order->id;
            $orderToProduct->save();
        }

        return back()->with([
            'message' => 'Bekräftelse kommer skickas inom kort via sms alternativt email!',
            'code' => $code,
        ]);
    }
}
