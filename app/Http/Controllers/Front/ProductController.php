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
use App\Models\Attribute;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use Session;
use DB;
use Auth;


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
                ->select('products.*', 'fabric', 'sleeve', 'fit', 'occasion', 'pattern')
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
            // Fetch special dynamic filters title
            $dynamicFilters = ProductsFilter::getDynamicFilters($getCategoriesDetails['catIDs']);
            // Fetch dynamic filters values
            // Initialize an empty array to store dynamic filter values
            $dynamicFilterValues = [];

            // Loop through each dynamic filter defined in the $dynamicFilters array
            foreach ($dynamicFilters as $key => $filter) {
                // Call the selectedFilters method from the ProductsFilter model
                // to retrieve the filter values for the current dynamic filter
                $filterValues = ProductsFilter::selectedFilters($filter, $getCategoriesDetails['catIDs']);
                // Assign the retrieved filter values to the $dynamicFilterValues array
                // using the current dynamic filter as the key
                $dynamicFilterValues[$filter] = $filterValues;
            }

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

            // Update Query for Dynamic Filters
            $filterTypes = ProductsFilter::filterTypes();
            foreach ($filterTypes as $key => $filter) {
                if ($request->$filter) {
                    $explodeFilterVals = explode('~', $request->$filter);
                    $categoryProducts->whereIn($filter, $explodeFilterVals);
                }
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
                            'dynamicFilters',
                            'dynamicFilterValues',
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
                        'dynamicFilters',
                        'dynamicFilterValues',
                    )
                );
            }
        } else {
            abort(404);
        }
    }

    public function detail($id)
    {
        $productCount = Product::where('status', 1)->where('id', $id)->count();
        if ($productCount == 0) {
            abort(404);
        }

        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        // Fetch all the data about the product
        $productDetails = Product::with([
            'category',
            'brand',
            'attributes',
            'images'
        ])->find($id)->toArray();
        //dd($productDetails);
        // Get Category details
        $getCategoriesDetails = Category::categoryDetails($productDetails['category']['url']);

        // Get Group Products (Product colors)
        $groupProducts = [];
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id', 'family_color')->where('id', '!=', $id)->where(['group_code' => $productDetails['group_code'], 'status' => 1])->get()->toArray();
            //dd($groupProducts);
        }

        // Get related products in a slideshow
        $relatedProducts = Product::with('brand', 'images')->where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(4)->inRandomOrder()->get()->toArray();
        //dd($relatedProducts);

        // Set Session for recently viewed products
        if (empty(Session::get('session_id'))) {
            $session_id = md5(uniqid(rand(), true));
        } else {
            $session_id = Session::get('session_id');
        }
        Session::put('session_id', $session_id);
        //Insert product in recently_viewed_items table if it does not exist
        $countRecentlyViewedItems = DB::table('recently_viewed_items')->where(['product_id' => $id, 'session_id' => $session_id])->count();
        if ($countRecentlyViewedItems == 0) {
            DB::table('recently_viewed_items')->insert(['product_id' => $id, 'session_id' => $session_id]);
        }
        // Get Recently viewed products Ids
        $recentlyViewedProductsIds = DB::table('recently_viewed_items')->select('product_id')->where('product_id', '!=', $id)->where('session_id', $session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        //dd($recentlyViewedProductsIds);
        // Get Recently viewed products
        $recentlyViewedProducts = Product::with('brand', 'images')->whereIn('id', $recentlyViewedProductsIds)->get()->toArray();

        return view(
            'front.products.detail',
            compact(
                'categories',
                'homeSliderBanner',
                'productDetails',
                'getCategoriesDetails',
                'groupProducts',
                'relatedProducts',
                'recentlyViewedProducts',
            )
        );
    }

    public function cleanupRecentlyViewedItems()
    {
        $expirationDate = now()->subDays(1); // Adjust the number of days as needed
        DB::table('recently_viewed_items')->where('created_at', '<', $expirationDate)->delete();
    }

    public function getAttributePrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            // Get the final price of the product based on if there is a discount or not from model product.php getAttributePrice() function
            $getAttributePrice = Product::getAttributePrice($data['product_id'], $data['size']);
            //echo "<pre>"; print_r($getAttributePrice); die;
            return $getAttributePrice;
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            // Fetch data from the productStock() function in app\Models\Attribute.php
            $productStock = Attribute::productStock($data['product_id'], $data['size']);
            // Check if the product is in stock or not
            if ($data['qty'] > $productStock) {
                $message = "Required Quantity is not available";
                return response()->json(['status' => false, 'message' => $message]);
            }

            // Fetch data from the productStatus() function in app\Models\Product.php
            $productStatus = Product::productStatus($data['product_id']);
            // Check if the product is active or not
            if ($productStatus == 0) {
                $message = "Product is not available";
                return response()->json(['status' => false, 'message' => $message]);
            }

            // Generate Session Id if it does not exist
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            } else {
                $session_id = Session::get('session_id');
            }
            // Look in concole Network -> Name -> Preview
            // echo $session_id; die;

            // Check if the product is already in the cart
            if (Auth::check()) {
                // User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where([
                    'product_id' => $data['product_id'],
                    'product_size' => $data['size'],
                    'user_id' => $user_id
                ])
                    ->count();
            } else {
                // User is not logged in
                $user_id = 0;
                $countProducts = Cart::where([
                    'product_id' => $data['product_id'],
                    'product_size' => $data['size'],
                    'session_id' => $session_id
                ])
                    ->count();
            }
            if ($countProducts > 0) {
                $message = "Product already exists in the cart";
                return response()->json(['status' => false, 'message' => $message]);
            }

            // Save the product in Cart
            $item = new Cart;
            $item->session_id = $session_id;
            if (Auth::check()) {
                $item->user_id = Auth::user()->id;
            }
            $item->product_id = $data['product_id'];
            $item->product_size = $data['size'];
            $item->product_qty = $data['qty'];
            $item->save();

            // Get total cart item
            $totalCartItems = totalCartItems();

            $message = "Product has been added to the cart";
            return response()->json(
                [
                    'status' => true,
                    'totalCartItems' => $totalCartItems,
                    'message' => $message
                ],
            );
        }
    }

    public function cart()
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();

        // Get the cart items
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);

        return view(
            'front.products.cart',
            compact(
                'categories',
                'homeSliderBanner',
                'getCartItems',
            )
        );
    }

    public function updateCartItemQuantity(Request $request)
    {
        \Log::info('Received request data:', $request->all());
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Get cart Details
            $cartDetails = Cart::find($data['cartid']);
            //Get Avilable stock
            $availableStock = Attribute::select('stock')->where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['product_size']])->first()->toArray();
            //echo "<pre>"; print_r($availableStock); die;
            // Check if the quantity is less than the available stock
            if ($data['qty'] > $availableStock['stock']) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Required Quantity is not available',
                    'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
                ]);
            }
            // Check if product size is available or not
            $availableSize = Attribute::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['product_size'], 'status' => 1])->count();
            if ($availableSize == 0) {
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size is not available',
                    'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
                ]);
            }

            // Update the Cart Item Qty
            Cart::where('id', $data['cartid'])->update(['product_qty' => $data['qty']]);
            // Get Updated Cart Items
            $getCartItems = Cart::getCartItems();

            // Get total cart item
            $totalCartItems = totalCartItems();
            // Refresh the coupon code session
            Session::forget('couponAmount');
            Session::forget('couponCode');
            // Return the updated cart items via Ajax
            return response()->json([
                'status' => true,
                'totalCartItems' => $totalCartItems,
                'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
            ]);
        }
    }

    public function deleteCartItem(Request $request)
    {
        \Log::info('Received request data:', $request->all());
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            Session::forget('couponAmount');
            Session::forget('couponCode');
            Cart::where('id', $data['cartid'])->delete();
            // Get Updated Cart Items
            $getCartItems = Cart::getCartItems();
            // Get total cart item
            $totalCartItems = totalCartItems();
            // Return the updated cart items via Ajax
            return response()->json([
                'status' => true,
                'totalCartItems' => $totalCartItems,
                'message' => 'Product has been removed from the cart',
                'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
            ]);
        }
    }

    public function emptyCart(Request $request)
    {
        \Log::info('Received request data:', $request->all());
        if ($request->ajax()) {
            Session::forget('couponAmount');
            Session::forget('couponCode');
            // Empty the cart
            emptyCart();
            // Get Updated Cart Items
            $getCartItems = Cart::getCartItems();
            // Get total cart item
            $totalCartItems = totalCartItems();
            // Return the updated cart items via Ajax
            return response()->json([
                'status' => true,
                'totalCartItems' => $totalCartItems,
                'message' => 'Product has been removed from the cart',
                'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
            ]);
        }
    }

    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            Session::forget('couponAmount');
            Session::forget('couponCode');
            // Get Updated Cart Items
            $getCartItems = Cart::getCartItems();
            // Get total cart item
            $totalCartItems = totalCartItems();

            // Check wether is actually valid and match it with the coupon that user submit
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                return response()->json([
                    'status' => false,
                    'totalCartItems' => $totalCartItems,
                    'message' => 'Coupon is not valid',
                    'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
                ]);
            } else {
                // check for other coupon condition

                // Get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                // Check if the coupon is active
                if ($couponDetails->status == 0) {
                    $message = "The coupon is not active";
                }
                // Check if the coupon is expired
                if ($couponDetails->expiry_date < date('Y-m-d')) {
                    $message = "The coupon has expired";
                }

                // Check if the coupon belong to selected category
                $catArr = explode(',', $couponDetails->categories);
                // Set total ammount to 0 before pulling of amount depending on the conditions
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = "The coupon is not valid for selected category";
                    }
                    $attributePrice = Product::getAttributePrice($item['product_id'], $item['product_size']);
                    $total_amount = $total_amount + ($attributePrice['final_price'] * $item['product_qty']);
                }

                // Check if the coupon belong to selected brand
                $brandArr = explode(',', $couponDetails->brands);
                foreach ($getCartItems as $key => $item) {
                    if (!in_array($item['product']['brand_id'], $brandArr)) {
                        $message = "The coupon is not valid for selected brand";
                    }
                }

                if (isset($couponDetails->users) && !empty($couponDetails->users)) {
                    // Check if coupon can be used of the logged in user
                    $usersArr = explode(',', $couponDetails->users);
                    // Get the user IDs form all the selected users
                    if (count($usersArr)) {
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }
                        // Check if any cart item not beling to coupon users
                        foreach ($getCartItems as $key => $item) {
                            if (!in_array($item['user_id'], $usersId)) {
                                $message = "The coupon is not valid for selected user";
                            }
                        }
                    }
                }

                // If error message is there
                if (isset($message)) {
                    return response()->json([
                        'status' => false,
                        'totalCartItems' => $totalCartItems,
                        'message' => $message,
                        'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
                    ]);
                } else {
                    // The coupon is correct and meet all conditions

                    // check if coupon type is fixed or percentage
                    if ($couponDetails->amount_type == 'Fixed') {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }

                    $grand_total = $total_amount - $couponAmount;

                    // Calculate the grand total after applying the coupon
                    $grand_total = $total_amount - $couponAmount;

                    // If the grand total is negative, set it to zero
                    if ($grand_total < 0) {
                        $grand_total = 0;
                    }

                    // >Add coupon code & Amount in session variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "Coupon code applied successfully";

                    return response()->json([
                        'status' => true,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'message' => $message,
                        'view' => (string) View::make('front.products.cart_items', compact('getCartItems')),
                    ]);

                }
            }

        }
    }

}
