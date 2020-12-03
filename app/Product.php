<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Product extends Model implements Buyable
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
    

    public function getCategories() {
        return $this->belongsToMany('boardit\Category', 'category_product');
    }

    // TODO: POSSIBLE SQL INJECTION
    public function scopeName($query, $name)
    {
        if (!is_null($name)) {
            return $query->where('name', 'like', '%'.$name.'%');
        }

        return $query;
    }

    // TODO: POSSIBLE SQL INJECTION
    public function scopePrice($query, $price)
    {  
        if (!is_null($price)) {
            return $query->where('price', '>=', compact('price'));
        }

        return $query;
    }
}
