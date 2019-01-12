<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function getProducts() {
        return $this->belongsToMany('boardit\Product', 'product_order');
    }
}
