<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use boardit\Product;

use \Cart;

// https://github.com/Crinsane/LaravelShoppingcart#usage
class CartController extends BaseController
{
    public function add(Product $product) {
        if(! Cart::content()->where('id', $product->id)->count() && $product->quantity) {
            Cart::add($product, 1)->associate('boardit\Product');
        }

        return back();
    }

    public function destroy() {
        Cart::destroy();

        return back();
    }

    public function removeById($id) {
        $items = Cart::search(function($cartItem, $rowId) use ($id) {
            return $cartItem->id == $id;
        });

        Cart::remove($items->first()->rowId);

        return back();
    }

    public function removeByRowId($rowId) {
        Cart::remove($rowId);

        return back();
    }
}
