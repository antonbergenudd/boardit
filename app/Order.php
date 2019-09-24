<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function getProducts() {
        return $this->belongsToMany('boardit\Product', 'product_order');
    }

    public function confirmedBy() {
        return $this->belongsTo('boardit\User', 'user_id');
    }

    // Member type
    const
        IDLE = 1,
        CONFIRMED = 2,
        DELIVERED = 3,
        RETURNED = 4;

    // Payment type
    const
        CARD = 1,
        SWISH = 2;
}
