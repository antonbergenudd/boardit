<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\BuyAble;

class Product extends Model implements BuyAble
{
    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->name;
    }

    public function getBuyablePrice($options = null) {
        return $this->price;
    }

    public function getOrders() {
        return $this->belongsToMany('boardit\Order', 'product_order');
    }
}
