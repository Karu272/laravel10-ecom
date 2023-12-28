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

            if ($request->ajax()) {
                // If it's an AJAX request, return a JSON response with the updated content
                return response()->json([
                    'view' => view('front.products.ajax_products_listing', compact(
                        'getCategoriesDetails',
                        'categoryProducts',
                        'categories',
                        'homeSliderBanner',
                    ))->with('sort', $request->sort)->render(),
                    'pagination' => $categoryProducts->links()->toHtml(),
                ]);
            } else {
                // If it's a regular request, return the view as usual
                return view('front.products.listing', compact(
                    'getCategoriesDetails',
                    'categoryProducts',
                    'categories',
                    'homeSliderBanner',
                ))->with('sort', $request->sort);
            }
        } else {
            abort(404);
        }
    }

    public function ajaxListing(Request $request)
    {
        // Similar to your existing listing method, but tailored for AJAX requests
        $getCategoriesDetails = Category::categoryDetails($request->category); // Assuming you have a category parameter in your AJAX request

        // Check if 'catIDs' key is present in the response array
        if (array_key_exists('catIDs', $getCategoriesDetails)) {
            $categoryProducts = Product::with(['brand', 'images'])
                ->select('products.*', 'final_price', 'is_featured', 'is_bestseller', 'product_discount')
                ->whereIn('category_id', $getCategoriesDetails['catIDs'])
                ->where('status', 1);

            // Apply sorting logic if needed

            $categoryProducts = $categoryProducts->paginate(4);

            return response()->json([
                'view' => view('front.products.ajax_products_listing', compact(
                    'getCategoriesDetails',
                    'categoryProducts',
                    'categories',
                    'homeSliderBanner',
                ))->with('sort', $request->sort)->render(),
                'pagination' => $categoryProducts->links()->toHtml(),
            ]);
        } else {
            // Handle the case where 'catIDs' key is not present (category not found)
            return response()->json([
                'error' => 'Category not found',
            ], 404);
        }
    }

}
