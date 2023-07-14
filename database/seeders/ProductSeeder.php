<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Festive Looks Rust Red Ribbed Velvet Long Sleeve Bodysuit',
                'image' => 'recent-1.png',
                'price_regular' => 38,
                'price_sale' => 0,
            ],[
                'name' => 'Chevron Flap Crossbody Bag',
                'image' => 'recent-2.png',
                'price_regular' => 7.34,
                'price_sale' => 5.77,
            ],[
                'name' => 'Manilla Tan Multi Plaid Oversized Fringe Scarf',
                'image' => 'recent-3.png',
                'price_regular' => 39,
                'price_sale' => 29,
            ],[
                'name' => 'Diamante Puff Sleeve Dress - Black',
                'image' => 'recent-4.png',
                'price_regular' => 45.99,
                'price_sale' => 0,
            ],[
                'name' => 'Banneth Open Front Formal Dress in Black',
                'image' => 'recent-5.png',
                'price_regular' => 99.95,
                'price_sale' => 69,
            ]
        ]);
    }
}
