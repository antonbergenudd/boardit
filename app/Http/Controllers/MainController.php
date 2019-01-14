<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use boardit\Product;
use boardit\Order;
use boardit\Mail\ConfirmationMailable;
use Cart;

class MainController extends BaseController
{
    function index() {
        $products = Product::where('popular', 1)->get();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('index', compact('products', 'cart', 'cartTotal'));
    }

    function about() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('about', compact('cart', 'cartTotal'));
    }

    function games() {
        $products = Product::all();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('games', compact('products', 'cart', 'cartTotal'));
    }

    public function orders() {
        $orders = Order::all();
        return view('auth.orders', compact('orders'));
    }

    public function confirmOrder(Order $order) {
        $order->confirmed = 1;
        $order->save();

        $this->email($order);

        return back();
    }

    private function email($data) {
        Mail::to($data->email)
            ->send(new ConfirmationMailable($data));
    }
}
