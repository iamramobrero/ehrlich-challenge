<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cartID = $request->cartID;

        $cartItems = CartItem::where('cart_id', $cartID)
                    ->select(['cart_items.id','name','image','price_regular','price_sale','quantity'])
                    ->leftJoin('products','products.id', '=', 'cart_items.product_id')
                    ->get();


        return response()->json($cartItems);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $cart = new Cart();
        $cart->user_id = Auth::check() ? Auth::user()->id : null;
        $cart->save();
        return $cart->id;
    }

    public function show(Cart $cart)
    {
        return $cart;
    }

    public function edit(Cart $cart)
    {
        //
    }


    public function update(Request $request, Cart $cart)
    {
        //
    }


    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response('',200);
    }
}
