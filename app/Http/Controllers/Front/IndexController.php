<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Index;
use App\Models\Banner;
use App\Models\Category;

class IndexController extends Controller
{
    public function index() {
        $homeSliderBanner = Banner::where('type','slider')->where('status', 1)->orderBy('sort','ASC')->get()->toArray();

        $homeFixedBanner = Banner::where('type','fixed')->where('status', 1)->orderBy('sort','ASC')->get()->toArray();

        $categories = Category::getCategories();

        return view('front.index', compact('homeSliderBanner', 'homeFixedBanner','categories'));
    }
}
