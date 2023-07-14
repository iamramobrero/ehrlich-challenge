<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        //
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
