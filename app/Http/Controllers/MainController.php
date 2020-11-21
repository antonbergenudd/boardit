<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use boardit\Product;
use boardit\Category;
use Gloudemans\Shoppingcart\Facades\Cart;

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

    function faq() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('faq', compact('cart', 'cartTotal'));
    }

    function policy() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('policy', compact('cart', 'cartTotal'));
    }

    function games() {
        $products = Product::where('show', 1)->get();
        $categories = Category::get();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('games', compact('products', 'cart', 'cartTotal', 'categories'));
    }
}
