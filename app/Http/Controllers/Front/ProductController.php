<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;

class ProductController extends Controller
{
    public function listing()
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();

        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        // Getting the route
        $url = Route::getFacadeRoot()->current()->uri;

        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {
            // Get Category details
            $getCategoriesDetails = Category::categoryDetails($url);
            // Get Categories and sub products categories
            $categoryProducts = Product::with(['brand', 'images'])
                ->whereIn('category_id', $getCategoriesDetails['catIDs'])
                ->where('status', 1)
                ->orderByDesc('id')
                ->paginate(4);

            return view('front.products.listing', compact(
                'getCategoriesDetails',
                'categoryProducts',
                'categories',
                'homeSliderBanner',
            ));
        } else {
            abort(404);
        }
    }
}
