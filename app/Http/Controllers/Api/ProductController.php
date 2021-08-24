<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        return Product::with('categories:id,name')->get();
    }
    
    public function show(Product $product) {
        return view('product', compact('product'));
    }
}
