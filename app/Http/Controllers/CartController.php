<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use boardit\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

// https://github.com/Crinsane/LaravelShoppingcart#usage
class CartController extends BaseController
{
    public function add(Product $product) {
        if(! Cart::content()->where('id', $product->id)->count() && $product->quantity) {
            $item = Cart::add($product, 1)->associate('boardit\Product');

            return [
                $item,
                $item->model
            ];
        }

        return null;
    }

    public function destroy() {
        Cart::destroy();

        return back();
    }

    public function removeById($rowId) {
        if(Cart::search(function($cartItem) use ($rowId) {
            return $cartItem->rowId == $rowId;
        })->first() != null) {
            Cart::remove($rowId);

            return "true";
        };

        return "false";
    }

    public function removeByRowId($rowId) {
        Cart::remove($rowId);

        return back();
    }
}
