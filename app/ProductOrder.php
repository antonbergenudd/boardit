<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    //
    protected $table = 'product_order';

    public function product() {
        return $this->belongsTo('boardit\Product', 'product_id');
    }
}
