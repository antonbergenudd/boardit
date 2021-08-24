<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
Use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(10)->create();
        
        $categories = Category::all();
        Product::all()->each(function($product) use ($categories) {
            $product->categories()->attach($categories->random(2)->pluck('id')->toArray());
        });
    }
}
