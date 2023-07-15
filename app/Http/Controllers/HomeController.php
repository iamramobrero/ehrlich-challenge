<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function recent_purchases(){
        // get recent purchase
        // get value from cart item table, where cart is paid
        $arrRecentPurchases = Product::select(['id', 'name', 'price_regular', 'price_sale', 'image'])->get()->toArray();
        return response()->json($arrRecentPurchases);
    }

    public function trending_items(){
        // get trending items from db
        // for demo purpose just return fixed array
        $arrTrendingItems = [
            ['winter fashion','trending-1.png'],
            ['boots','trending-8.png'],
            ['night out','trending-7.png'],
            ['holidays','trending-6.png'],
            ['outerwear','trending-5.png'],
            ['white dresses','trending-4.png'],
            ['sweaters','trending-3.png'],
            ['party','trending-2.png'],
        ];

        return response()->json($arrTrendingItems);
    }

    public function checkout(){
        return view('checkout');
    }

    public function doCheckout(){
        return 1;
    }
}
