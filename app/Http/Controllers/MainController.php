<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Cart;
use boardit\Product;
use boardit\Order;

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
}
