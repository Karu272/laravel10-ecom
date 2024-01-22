<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        \Log::info('Received request data:', $request->all());
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 1;
            $user->save();

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $redirectUrl = url('/cart');
                return response()->json(['redirectUrl' => $redirectUrl]);
            }
        }
        return view('front.users.register', compact('homeSliderBanner', 'categories'));
    }

    public function login()
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        return view('front.users.login', compact('homeSliderBanner', 'categories'));
    }
}
