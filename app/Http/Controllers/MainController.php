<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MainController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function assortment() {
        $products = Product::all();
        return view('assortment', compact('products'));
    }
}
