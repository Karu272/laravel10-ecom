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
                ->select('products.*', 'fabric', 'sleeve', 'fit', 'occassion', 'pattern')
                ->where('products.status', 1);


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
            // Fetch Sizes using ProductsFilter model
            $sizes = ProductsFilter::getSizes($getCategoriesDetails['catIDs']);
            // Fetch Brands using ProductsFilter model
            $brands = ProductsFilter::getBrands($getCategoriesDetails['catIDs']);
            // Fetch Brands using ProductsFilter model
            $prices = ['0-50', '50-100', '100-150', '150-200', '200-300', '300-400', '400-500'];

            // Update query for colors filter
            if (isset($request['color']) && !empty($request['color'])) {
                $colors = explode('~', $request['color']);
                $categoryProducts->whereIn('products.family_color', $colors);
            }

            // update query for sizes filter
            // Check if the 'size' parameter is set in the request and is not empty
            if (isset($request['size']) && !empty($request['size'])) {
                // Split the 'size' parameter into an array using tilde (~) as the delimiter
                $sizes = explode('~', $request['size']);
                // Use the 'whereHas' method to filter products based on the 'attributes' relationship
                // The closure function within 'whereHas' adds a condition to check if any attribute's 'size' column
                // matches any value in the 'sizes' array
                $categoryProducts->whereHas('attributes', function ($query) use ($sizes) {
                    $query->whereIn('size', $sizes);
                });
            }

            // Update query for brands filter
            if (isset($request['brand']) && !empty($request['brand'])) {
                $brands = explode('~', $request['brand']);
                $categoryProducts->whereIn('products.brand_id', $brands);
            }

            // Update query for prices filter
            // Check if the 'price' parameter is set in the request and is not empty
            if (isset($request['price']) && !empty($request['price'])) {
                // Replace any tilde (~) characters in the 'price' parameter with hyphen (-)
                $request['price'] = str_replace("~", "-", $request['price']);
                // Split the modified 'price' parameter into an array using hyphen (-) as the delimiter
                $prices = explode('-', $request['price']);
                // Count the number of elements in the 'prices' array
                $count = count($prices);
                // Use the 'whereBetween' method to filter the products based on the price range
                // The 'final_price' column of the 'products' table should fall within the range
                // defined by the first and last elements of the 'prices' array
                $categoryProducts->whereBetween('products.final_price', [$prices[0], $prices[$count - 1]]);
            }

            $categoryProducts = $categoryProducts->paginate(5);

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
                            'sizes',
                            'brands',
                            'prices',
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
                        'sizes',
                        'brands',
                        'prices',
                    )
                );
            }
        } else {
            abort(404);
        }
    }
}
