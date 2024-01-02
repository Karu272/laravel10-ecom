<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\ProductsFilter;
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
                ->whereIn('category_id', $getCategoriesDetails['catIDs'])
                ->where('status', 1);

            // Handle sorting based on the 'sort' parameter
            if ($request->has('sort') && !empty($request->input('sort'))) {
                $sortValue = $request->input('sort');

                switch ($sortValue) {
                    case "product_latest":
                        $categoryProducts->orderByDesc('id');
                        break;
                    case "lowest_price":
                        $categoryProducts->orderBy('final_price', 'ASC');
                        break;
                    case "best_selling":
                        $categoryProducts->where('is_bestseller', 'YES');
                        break;
                    case "highest_price":
                        $categoryProducts->orderBy('final_price', 'DESC');
                        break;
                    case "featured_items":
                        $categoryProducts->where('is_featured', 'YES');
                        break;
                    case "discounted_items":
                        $categoryProducts->where('product_discount', '>', 0);
                        break;
                    default:
                        // Handle other cases or no sorting
                        break;
                }
            }

            // Fetch colors using ProductsFilter model
            $colors = ProductsFilter::getColors($getCategoriesDetails['catIDs']);

            if (isset($request['color']) && !empty($request['color'])) {
                $colors = explode('~', $request['color']);
                $categoryProducts->whereIn('products.family_color', $colors);
            }

            $categoryProducts = $categoryProducts->paginate(4);

            if ($request->ajax()) {
                // If it's an Ajax request, return JSON
                return response()->json([
                    'view' => (string) View::make(
                        'front.products.ajax_products_listing',
                        compact(
                            'getCategoriesDetails',
                            'categoryProducts',
                            'categories',
                            'homeSliderBanner',
                            'url',
                            'colors',
                        )
                    )
                ]);
            } else {
                // If it's a regular request, return HTML
                return view(
                    'front.products.listing',
                    compact(
                        'getCategoriesDetails',
                        'categoryProducts',
                        'categories',
                        'homeSliderBanner',
                        'url',
                        'colors',
                    )
                );
            }
        } else {
            abort(404);
        }
    }
}
