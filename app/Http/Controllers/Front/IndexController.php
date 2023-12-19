<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Index;
use App\Models\Banner;
use App\Models\Category;

class IndexController extends Controller
{
    public function index()
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();

        $homeFixedBanner = Banner::where('type', 'fixed')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();

        // Fetching the categories and subcategories
        $categories = Category::getCategories();

        // Get products 'brand','images' are functions that coming from the Products model
        $randomProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->toArray();
        //dd($randomProducts);
        // Last 4
        $newProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->latest('id')
            ->take(4)
            ->get()
            ->toArray();
        // Is featured
        $featuredProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->where('is_featured', 'YES') // Use the correct column name
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get()
            ->toArray();



        return view('front.index', compact('homeSliderBanner', 'homeFixedBanner', 'categories', 'newProducts', 'randomProducts','featuredProducts'));
    }
}
