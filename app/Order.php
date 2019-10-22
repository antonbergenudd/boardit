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

    // Order status
    // Has to be in chronological order
    const
        PROCESSING = 1,
        PAYMENT_FAILED = 2,
        CONFIRMED_AND_RESERVED = 3,
        CONFIRMED = 4,
        DELIVERED = 5,
        RETURNED = 6;

    // Payment type
    const
        PAYMENT_CARD = 1,
        PAYMENT_SWISH = 2;
}
