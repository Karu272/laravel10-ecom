<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Auth;
use Session;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems() {
        // If the user is logged in , check from Auth (user_id)
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $getCartItems = Cart::with('product')->where('user_id', $user_id)->get()->toArray();
        } else {
            // If the user is not logged in, check from Session (session_id)
            $session_id = Session::get('session_id');
            $getCartItems = Cart::with('product')->where('session_id', $session_id)->get()->toArray();
        }
        return $getCartItems;
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->with('brand','images');
    }
}
