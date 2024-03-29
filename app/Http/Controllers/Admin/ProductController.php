<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Productimage;
use App\Models\Attribute;
use App\Models\Brand;
use Session;
use Auth;
use DB;


class ProductController extends Controller
{
    // Method to display products and handle permissions
    public function index()
    {
        Session::put('page', 'products');
        // category() comes from the model products
        $getProductDBdata = Product::with('category')->get()->toArray();
        //dd($getProductDBdata);

        // Set Admin/subadmins Permissions for products
        $pagesModule = [];

        // Check if the user is an admin
        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'products'])->first();

            // If no role is found or all permissions are 0, redirect to dashboard
            if (!$role || ($role->view_access == 0 && $role->edit_access == 0 && $role->full_access == 0)) {
                $message = "This feature is restricted for you!";
                return redirect()->route('admin.dashboard')->with('error_message', $message);
            }

            $pagesModule = $role->toArray();
        }

        return view("admin.products.products", compact("getProductDBdata", "pagesModule"));
    }

    // Method to update product status via Ajax
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    // Method to handle product editing (add or edit)
    public function edit(Request $request, $id = null)
    {
        // Getting the Categories from the model
        $getCategories = Category::getCategories();

        // Getting the Brands from the model
        $getBrands = Brand::where('status', 1)->get()->toArray();

        if ($id == "") {
            $title = "Add Product";
            $editPro = new Product;
            $message = "Product added successfully!";
        } else {
            $title = "Edit Product";
            // Images comes from product model
            $editPro = Product::with(['attributes', 'images'])->find($id);
            //dd($editPro);
            $message = "Product Edited successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_code' => 'required|regex:/^[\w-]*$/|max:200',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'family_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_weight' => 'required',
                'group_code' => 'required|regex:/^[\w-]*$/|max:200',
                'product_discount' => 'nullable|numeric',
                'description' => 'required',
                'wash_care' => 'required',
                'meta_description' => 'required',
                'keywords' => 'required',
                'meta_title' => 'required',
                'meta_keywords' => 'required',
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Name is required',
                'product_name.regex' => 'Valid Name is required',
                'product_code.required' => 'Code is required',
                'product_code.regex' => 'Valid Code is required',
                'product_price.required' => 'Price is required',
                'product_price.numeric' => 'Valid price is required',
                'product_color.required' => 'Color is required',
                'product_color.regex' => 'Valid color is required',
                'family_color.required' => 'Family color is required',
                'family_color.regex' => 'Valid Family color is required',
                'product_weight.required' => 'Product weight is required',
                'group_code.required' => 'Group code is required',
                'group_code.regex' => 'Valid group code is required',
                'description.required' => 'Description is required',
                'wash_care.required' => 'Wash care is required',
                'meta_description.required' => 'Meta description is required',
                'keywords.required' => 'Keywords are required',
                'meta_title.required' => 'Meta title is required',
                'meta_keywords.required' => 'Meta keywords are required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Update product information based on the form data
            $editPro->product_name = $data['product_name'];
            $editPro->category_id = $data['category_id'];
            $editPro->brand_id = $data['brand_id'];
            $editPro->product_code = $data['product_code'];
            $editPro->product_color = $data['product_color'];
            $editPro->family_color = $data['family_color'];
            $editPro->product_weight = $data['product_weight'];
            $editPro->group_code = $data['group_code'];
            $editPro->product_price = $data['product_price'];
            $editPro->product_discount = $data['product_discount'] ?? 0;

            // Calculate final price based on product discount and category discount
            if (!empty($data['product_discount']) && $data['product_discount'] > 0) {
                $editPro->discount_type = 'editPro';
                $editPro->final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount']) / 100;
            } else {
                $getCategoryDiscount = Category::select('category_discount')->where('id', $data['category_id'])->first();
                if ($getCategoryDiscount->category_discount == 0) {
                    $editPro->discount_type = null;
                    $editPro->final_price = $data['product_price'];
                } else {
                    $editPro->discount_type = 'category';
                    $editPro->final_price = $data['product_price'] - ($data['product_price'] * $getCategoryDiscount->category_discount) / 100;
                }
            }

            $editPro->description = $data['description'];
            $editPro->wash_care = $data['wash_care'];
            $editPro->meta_description = $data['meta_description'];
            $editPro->keywords = $data['keywords'];
            $editPro->meta_title = $data['meta_title'];
            $editPro->meta_keywords = $data['meta_keywords'];
            $editPro->is_featured = !empty($data['is_featured']) ? $data['is_featured'] : "NO";
            $editPro->is_bestseller = !empty($data['is_bestseller']) ? $data['is_bestseller'] : "NO";

            // Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    // Upload Video
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(11, 9999) . '.' . $extension;
                    $video_path = 'admin/videos/';
                    $video_tmp->move($video_path, $videoName);
                    // Save video name in products table
                    $editPro->product_video = $videoName;
                }
            }


            $editPro->fabric = $data['fabric'] ?? 'none';
            $editPro->sleeve = $data['sleeve'] ?? 'none';
            $editPro->pattern = $data['pattern'] ?? 'none';
            $editPro->fit = $data['fit'] ?? 'none';
            $editPro->occasion = $data['occasion'] ?? 'none';
            $editPro->status = 1;
            $editPro->save();

            // Determine the product ID for new products or edited products
            if ($id == "") {
                $product_id = DB::getPdo()->lastInsertId();
            } else {
                $product_id = $id;
            }

            // Add attributes
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    // Check if SKU already exists
                    $countSKU = Attribute::where('sku', $value)->count();
                    if ($countSKU > 0) {
                        $message = "SKU already exists. Please try another SKU";
                        return redirect()->back()->with('error_message', $message);
                    }

                    // Check if size already exists
                    $countSize = Attribute::where([
                        'product_id' => $product_id,
                        'size' => $data['size'][$key],
                    ])->count();

                    if ($countSize > 0) {
                        $message = "Size already exists. Please try another Size";
                        return redirect()->back()->with('error_message', $message);
                    }

                    // Create a new attribute
                    $attribute = new Attribute;
                    $attribute->product_id = $product_id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            // Edit existing attributes
            if (isset($data['attributeId'])) {
                foreach ($data['attributeId'] as $akey => $atr) {
                    if (!empty($atr)) {
                        Attribute::where([
                            'id' => $data['attributeId'][$akey],
                        ])->update([
                                    'price' => $data['price'][$akey],
                                    'stock' => $data['stock'][$akey],
                                ]);
                    }
                }
            }

            // Save product images
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $key => $image) {
                    // Get temporary image
                    $image_temp = Image::make($image);
                    // Get image extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate a new name for the image
                    $imageName = rand(111, 90000) . '.' . $extension;

                    // Save the image in different sizes
                    $large_image_path = 'admin/img/products/large/' . $imageName;
                    $medium_image_path = 'admin/img/products/medium/' . $imageName;
                    $small_image_path = 'admin/img/products/small/' . $imageName;

                    // Resize the image
                    Image::make($image_temp)->resize(1040, 1200)->save($large_image_path);
                    Image::make($image_temp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_temp)->resize(260, 300)->save($small_image_path);

                    // Create a new Productimage record
                    $image = new Productimage;
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->save();
                }
            }

            // Sort product images
            if ($id != '') {
                if (isset($data['image'])) {
                    try {
                        foreach ($data['image'] as $key => $image) {
                            // Check if 'image_sort' key exists in $data
                            $imageSort = isset($data['image_sort'][$key]) ? $data['image_sort'][$key] : null;

                            Productimage::where([
                                'product_id' => $id,
                                'image' => $image,
                            ])->update([
                                        'image_sort' => $imageSort, // Use $imageSort instead of $data['image_sort'][$key]
                                    ]);
                        }
                    } catch (\Exception $e) {
                        // Handle the exception (e.g., log it, show a user-friendly error message)
                        \Log::error('Error updating product images: ' . $e->getMessage());
                        // You may also throw the exception again if you want it to propagate
                        // throw $e;
                    }
                }
            }

            return redirect()->route('admin.products.products')->withInput()->with('success_message', $message);
        }

        // Product Filters
        $productsFilters = Product::productFilters();

        return view("admin.products.add_edit_product", compact("title", "editPro", "message", "getCategories", "productsFilters", "getBrands"));
    }

    // Method to delete a product
    public function destroy($id)
    {
        // Call the destroyproVideo method to delete the product video
        $this->destroyproVideo($id);

        // Call the destroyproimg method to delete the product images
        $this->destroyproimg($id);

        // Call the destroyproimg method to delete the product attributes
        $this->destroyattribute($id);

        // Delete
        Product::where('id', $id)->delete();
        $message = 'Product deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    // Method to delete a product video
    public function destroyproVideo($id)
    {
        // Get product video
        $productVid = Product::select('product_video')->where('id', $id)->first();

        // Get product video path
        $video_path = 'admin/videos/';

        // Delete product video from products folder if it exists
        $video_file_path = $video_path . $productVid->product_video;

        if (file_exists($video_file_path) && is_file($video_file_path)) {
            unlink($video_file_path);
        }

        // Delete product video from products table
        Product::where('id', $id)->update(['product_video' => '']);

        return redirect()->back()->with('success_message', 'Product video deleted successfully');
    }

    // Method to delete a product image
    public function destroyproimg($id)
    {
        // Get image information
        $productImage = Productimage::select('image')->where('id', $id)->first();

        // Define image paths
        $imagePaths = [
            'admin/img/products/small/',
            'admin/img/products/medium/',
            'admin/img/products/large/',
        ];

        // Loop through each image path and delete the corresponding image file
        foreach ($imagePaths as $path) {
            $imageFullPath = public_path($path . $productImage->image);

            if (file_exists($imageFullPath)) {
                unlink($imageFullPath);
            }
        }

        Productimage::where('id', $id)->delete();

        $message = 'Product image deleted successfully!';
        session()->flash('success_message', $message);

        return redirect()->back();
    }

    // Method to update attribute status via Ajax
    public function updateAtrStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Attribute::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    // Method to delete an attribute
    public function destroyattribute($id)
    {
        // Delete
        Attribute::where('id', $id)->delete();
        $message = 'Attribute deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }

}
