<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use boardit\Product;

use Illuminate\Http\Request;

use \Cart;

// https://github.com/Crinsane/LaravelShoppingcart#usage
class CartController extends BaseController
{
    public function add(Product $product) {
        if(! Cart::content()->where('id', $product->id)->count()) {
            Cart::add($product, 1)->associate('boardit\Product');
        }

        return back();
    }

    public function destroy() {
        Cart::destroy();

        return back();
    }

    public function remove($rowId) {
        Cart::remove($rowId);

        return back();
    }
}
