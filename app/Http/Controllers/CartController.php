<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cartID = $request->cartID;

        $cartItems = CartItem::where('cart_id', $cartID)
        ->select(['cart_items.id','cart_items.product_id','name','image','price_regular','price_sale','quantity'])
        ->leftJoin('products','products.id', '=', 'cart_items.product_id')
        ->with('product')
        ->get();

        $subtotal = 0;
        $temp = [];
        foreach($cartItems as $item){
            $prod = Product::find($item->product_id);
            $temp[] = [
                'id' => $item->id,
                'image' => $item->image,
                'quantity' => $item->quantity,
                'name' => $item->name,
                'price' => number_format($prod->price,2),
            ];

            $subtotal += ($item->quantity * $prod->price);
        }

        $discount = ($subtotal > 100) ? 10:0;
        $shipping = 25;
        $total = (($subtotal + $shipping) - $discount);

        $response = [
            'cart' => [
                'items' => $temp,
                'subtotal' => number_format($subtotal,2),
                'total' => number_format($total,2),
                'shipping' => number_format($shipping,2),
                'discount' => number_format($discount,2),
            ]
        ];


        return response()->json($response);
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
