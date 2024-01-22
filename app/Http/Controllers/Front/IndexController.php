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
        //dd($categories);

        // Get products 'brand','images' are functions that coming from the Products model
        $randomProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->toArray();

        // Last 4
        $newProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->latest('id')
            ->take(4)
            ->get()
            ->toArray();

        // Best seller
        $bestSellerProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->where('is_bestseller', 'YES')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get()
            ->toArray();

        // Discount products brands or category
        $discountProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            // Apply a complex where clause using a closure
            ->where(function ($query) {
                // Check if the product has a discount and the discount value is greater than 0
                $query->where(function ($query) {
                    $query->whereNotNull('product_discount')->where('product_discount', '>', 0);
                })
                    // Or, check if the product belongs to a category with a discount value greater than 0
                    ->orWhereHas('category', function ($query) {
                    $query->whereNotNull('category_discount')->where('category_discount', '>', 0);
                })
                    // Or, check if the product belongs to a brand with a discount value greater than 0
                    ->orWhereHas('brand', function ($query) {
                    $query->whereNotNull('brand_discount')->where('brand_discount', '>', 0);
                });
            })
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->toArray();


        // Is featured
        $featuredProducts = Product::with(['brand', 'images'])
            ->where('status', 1)
            ->where('is_featured', 'YES')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get()
            ->toArray();

        return view('front.index', compact(
            'homeSliderBanner',
            'homeFixedBanner',
            'categories',
            'newProducts',
            'randomProducts',
            'featuredProducts',
            'discountProducts',
            'bestSellerProducts'
        ));
    }

}
