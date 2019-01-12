<?php

namespace boardit\Http\Controllers;

use boardit\ProductOrder;

use Illuminate\Routing\Controller as BaseController;

use boardit\Product;

use Illuminate\Http\Request;

use \Cart;
use boardit\Order;

// https://github.com/Crinsane/LaravelShoppingcart#usage
class PaymentController extends BaseController
{
    function index() {
        $cart = Cart::content();
        $cartTotal = Cart::subtotal();

        return view('payment.index', compact('cart', 'cartTotal'));
    }

    function confirm(Request $request) {
        // Generate code and save payment to database
        $code = str_random(12);

        $order = new Order;
        $order->code = $code;
        $order->address = $request->address;
        $order->email = isset($request->email) ? $request->email : NULL;
        $order->phone = isset($request->tel) ? $request->tel : NULL;
        $order->payment = Cart::total();
        $order->save();

        foreach(Cart::content() as $row) {
            $product = $row->model;

            $orderToProduct = new ProductOrder;
            $orderToProduct->product_id = $product->id;
            $orderToProduct->order_id = $order->id;
            $orderToProduct->save();
        }

        return back()->with(['code' => $code]);
    }
}
