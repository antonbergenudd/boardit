<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use boardit\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductController extends BaseController
{
    function view(Product $product) {
        return view('product.view', compact('product'));
    }
}
