<?php

namespace boardit;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_product';

    public function product() {
        return $this->belongsTo('boardit\Product', 'product_id');
    }

    public function category() {
        return $this->belongsTo('boardit\Category', 'category_id');
    }
}
