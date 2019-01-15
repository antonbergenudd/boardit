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
        if(! Cart::content()->where('id', $product->id)->count() && $product->quantity) {
            Cart::add($product, 1)->associate('boardit\Product');

            $product->quantity--;
            if($product->quantity == 0) {
                $product->in_store = 0;
            }

            $product->save();
        }

        return back();
    }

    public function destroy() {
        foreach(Cart::content() as $item) {
            $product = $item->model;

            $product->quantity++;
            if($product->quantity > 0) {
                $product->in_store = 1;
            }

            $product->save();
        }

        Cart::destroy();

        return back();
    }

    public function remove($rowId) {
        $item = Cart::content()->where('rowId', $rowId)->first();

        $product = $item->model;

        $product->quantity++;

        if($product->quantity > 0) {
            $product->in_store = 1;
        }

        $product->save();

        Cart::remove($rowId);

        return back();
    }
}
