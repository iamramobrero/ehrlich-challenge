<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cart_id = $request->cartID;
        $product_id = $request->productID;

        // check if item is already in the cart
        $cartItem = CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();

        // get product
        $product = Product::find($product_id)->first();

        if($cartItem){
            $cartItem->quantity++;
        }
        else{
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart_id;
            $cartItem->product_id = $product_id;
            $cartItem->quantity = 1;

        }

        $cartItem->price = $product->price;
        $cartItem->save();

        return $cartItem;
    }

    public function show(CartItem $cartItem)
    {
        //
    }

    public function edit(CartItem $cartItem)
    {
        //
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return response('',200);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return response('',200);
    }
}
