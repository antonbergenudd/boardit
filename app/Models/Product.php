<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
    
    public function orders() {
        return $this->belongsToMany(Order::class);
    }
}
