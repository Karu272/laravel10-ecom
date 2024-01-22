<?php

use App\Models\Cart;

function totalCartItems() {
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalCartItems = Cart::where('user_id', $user_id)->sum('product_qty');
    }else{
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id', $session_id)->sum('product_qty');
    }
    return $totalCartItems;
}

function emptyCart() {
    if(Auth::check()){
        $user_id = Auth::user()->id;
        Cart::with('product')->where('user_id', $user_id)->delete();
    }else{
        $session_id = Session::get('session_id');
        Cart::with('product')->where('session_id', $session_id)->delete();
    }
}