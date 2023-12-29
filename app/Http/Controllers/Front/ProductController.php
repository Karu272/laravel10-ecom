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
                ->select('products.*', 'final_price', 'is_featured', 'is_bestseller', 'product_discount')
                ->whereIn('category_id', $getCategoriesDetails['catIDs'])
                ->where('status', 1);

            if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                if ($_GET['sort'] == "product_latest") {
                    $categoryProducts->orderByDesc('id');
                } else if ($_GET['sort'] == "lowest_price") {
                    $categoryProducts->orderBy('final_price', 'ASC');
                } else if ($_GET['sort'] == "best_selling") {
                    $categoryProducts->where('is_bestseller', 'YES');
                } else if ($_GET['sort'] == "highest_price") {
                    $categoryProducts->orderBy('final_price', 'DESC');
                } else if ($_GET['sort'] == "featured_items") {
                    $categoryProducts->where('is_featured', 'YES');
                } else if ($_GET['sort'] == "discounted_items") {
                    $categoryProducts->where('product_discount', '>', 0);
                }
            }

            $categoryProducts = $categoryProducts->paginate(4);

            // If it's a regular request, return the view as usual
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
