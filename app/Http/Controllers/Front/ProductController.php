<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    public function listing(Request $request)
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
                ->select('products.*', 'final_price', 'is_featured', 'is_bestseller', 'product_discount')
                ->whereIn('category_id', $getCategoriesDetails['catIDs'])
                ->where('status', 1);

            // Check the sort option
            if ($request->sort == "product_latest") {
                $categoryProducts->orderByDesc('id');
            } else if ($request->sort == "lowest_price") {
                $categoryProducts->orderBy('final_price', 'ASC');
            } else if ($request->sort == "best_selling") {
                $categoryProducts->where('is_bestseller', 'YES');
            } else if ($request->sort == "highest_price") {
                $categoryProducts->orderBy('final_price', 'DESC');
            } else if ($request->sort == "featured_items") {
                $categoryProducts->where('is_featured', 'YES');
            } else if ($request->sort == "discounted_items") {
                $categoryProducts->where('product_discount', '>', 0);
            }

            $categoryProducts = $categoryProducts->paginate(4);

            return view('front.products.listing', compact(
                'getCategoriesDetails',
                'categoryProducts',
                'categories',
                'homeSliderBanner',
            ))->with('sort', $request->sort);
        } else {
            abort(404);
        }
    }
}
