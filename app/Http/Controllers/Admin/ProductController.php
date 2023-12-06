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
use Session;
use Auth;
use DB;


class ProductController extends Controller
{
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

    // Update status
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

    public function edit(Request $request, $id = null)
    {
        $getCategories = Category::getCategories();

        if ($id == "") {
            $title = "Add Product";
            $editPro = new Product;
            $message = "Product added successfully!";
        } else {
            $title = "Edit Product";
            // Images comes from product model
            $editPro = Product::with(['attributes','images'])->find($id);
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
            ];

            $this->validate($request, $rules, $customMessages);

            $editPro->product_name = $data['product_name'];
            $editPro->category_id = $data['category_id'];
            $editPro->product_code = $data['product_code'];
            $editPro->product_color = $data['product_color'];
            $editPro->family_color = $data['family_color'];
            $editPro->product_weight = $data['product_weight'];
            $editPro->group_code = $data['group_code'];
            $editPro->product_price = $data['product_price'];
            $editPro->product_discount = $data['product_discount'];
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
            // Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    // Upload Video
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(11, 9999) . '.' . $extension;
                    $video_path = 'admin/products/videos';
                    $video_tmp->move($video_path, $video_name);
                    // save video in products table
                    $editPro->product_video = $videoName;
                }
            }
            $editPro->fabric = $data['fabric'];
            $editPro->sleeve = $data['sleeve'];
            $editPro->pattern = $data['pattern'];
            $editPro->fit = $data['fit'];
            $editPro->occassion = $data['occassion'];
            $editPro->status = 1;
            $editPro->save();

            if ($id == "") {
                $product_id = DB::getPdo()->lastInsertId();
            } else {
                $product_id = $id;
            }


            // Add atttributes
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    // SKU already exist check
                    $countSKU = Attribute::where('sku', $value)->count();
                    if ($countSKU > 0) {
                        $message = "SKU already exists. Place try another SKU";
                        return redirect()->back()->with('error_message', $message);
                    }
                    $countSize = Attribute::where([
                        'product_id' => $product_id,
                        'size' => $data['size'][$key]
                    ])->count();

                    if ($countSize > 0) {
                        $message = "Size already exists. Place try another Size";
                        return redirect()->back()->with('error_message', $message);
                    }

                    $atttribute = new Attribute;
                    $atttribute->product_id = $product_id;
                    $atttribute->sku = $value;
                    $atttribute->size = $data['size'][$key];
                    $atttribute->price = $data['price'][$key];
                    $atttribute->stock = $data['stock'][$key];
                    $atttribute->status = 1;
                    $atttribute->save();
                }
            }

            // Edit Attributes
            foreach ($data['attributeId'] as $akey => $atr) {
                if (!empty($atr)) {
                    Attribute::where([
                        'id' =>$data['attributeId'][$akey]
                        ])->update([
                            'price' => $data['price'][$akey],
                            'stock' => $data['stock'][$akey],
                        ]);
                }
            }

            // Save Image
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $key => $image) {
                    // Get temp image
                    $image_temp = Image::make($image);
                    // Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Name
                    $imageName = rand(111, 90000) . '.' . $extension;

                    // Save Image
                    $large_image_path = 'admin/img/products/large/' . $imageName;
                    $medium_image_path = 'admin/img/products/medium/' . $imageName;
                    $small_image_path = 'admin/img/products/small/' . $imageName;
                    // resize
                    Image::make($image_temp)->resize(1040, 1200)->save($large_image_path);
                    Image::make($image_temp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_temp)->resize(260, 300)->save($small_image_path);

                    $image = new Productimage;
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->save();
                }
            }

            // Sort product Images
            if ($id != '') {
                if (isset($data['image'])) {
                    foreach ($data['image'] as $key => $image) {
                        $imageSort = isset($data['image_sort'][$key]) ? $data['image_sort'][$key] : null;

                        Productimage::where([
                            'product_id' => $id,
                            'image' => $image,
                        ])->update([
                                    'image_sort' => $data['image_sort'][$key]
                                ]);
                    }
                }
            }

            return redirect()->route('admin.products.products')->withInput()->with('success_message', $message);
        }

        // Product Filters
        $productsFilters = Product::productFilters();

        return view("admin.products.add_edit_product", compact("title", "editPro", "message", "getCategories", "productsFilters"));
    }

    public function destroy($id)
    {
        // Delete
        Product::where('id', $id)->delete();
        $message = 'Product deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    public function destroyproVideo($id)
    {
        // Get product img
        $productVid = Product::select('product_video')->where('id', $id)->first();

        // Get product Img path
        $video_path = 'admin/products/videos/';

        // Delete product Image from products folder if exists
        if (file_exists($video_path . $productVid->product_video)) {
            unlink($video_path . $productVid->product_video);
        }

        // Delete product Img from products table
        Product::where('id', $id)->update(['product_video' => '']);

        return redirect()->back()->with('success_message', 'Product video deleted successfully');
    }

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

    public function updateAtrStatus(Request $request) {
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

    public function destroyattribute($id)
    {
        // Delete
        Attribute::where('id', $id)->delete();
        $message = 'Attribute deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }

}
