<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\AdminsRole;
use App\Models\Brand;
use App\Models\Product;
use Session;
use Auth;
use DB;

class BrandController extends Controller {
    public function index() {
        Session::put('page', 'brands');
        $brandDBdata = Brand::all();

        // Set Admin/subadmins Permissions for brands
        $pagesModule = [];

        // Check if the user is an admin
        if(Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->first();

            // If no role is found or all permissions are 0, redirect to dashboard
            if(!$role || ($role->view_access == 0 && $role->edit_access == 0 && $role->full_access == 0)) {
                $message = "This feature is restricted for you!";
                return redirect()->route('admin.dashboard')->with('error_message', $message);
            }

            $pagesModule = $role->toArray();
        }

        return view('admin.brands.brands', compact('brandDBdata', 'pagesModule'));
    }

    public function update(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            if($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function edit(Request $request, $id = null) {
        if(empty($id)) {
            $title = "Add Brand";
            $editBrand = new Brand;
            $message = "Brand added successfully!";
        } else {
            $title = "Edit Brand";
            $editBrand = Brand::find($id);
            $message = "Brand Edited successfully!";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            $imageName = null;

            $rules = [
                'brand_name' => 'required|max:255|unique:brands,brand_name,'.$editBrand->id,
                'description' => 'required',
                'url' => 'required|unique:brands,url,'.$editBrand->id,
                'image' => 'image',
            ];

            $customMessages = [
                'brand_name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'url.required' => 'URL is required',
                'image.image' => 'The uploaded file must be an image.',
            ];

            $this->validate($request, $rules, $customMessages);

            // Remove Brand Discount from all products to specific Brand
            if(empty($data['brand_discount'])) {
                // If brand discount is not set, set it to 0
                $data['brand_discount'] = 0;

                // Check if $id is not empty
                if($id != "") {
                    // Fetch products belonging to the specified brand
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();

                    // Loop through each product in the brand
                    foreach($brandProducts as $key => $product) {
                        // Check if the product has a brand discount
                        if($product['discount_type'] == 'brand') {
                            // Update the product with no category discount
                            Product::where('id', $product['id'])->update([
                                'discount_type' => '',
                                'final_price' => $product['product_price']
                            ]);
                        }
                    }
                }
            }

            $editBrand->fill([
                'brand_name' => $data['brand_name'],
                'brand_discount' => $data['brand_discount'],
                'description' => $data['description'],
                'url' => $data['url'],
                'meta_title' => $data['meta_title'],
                'meta_keywords' => $data['meta_keywords'],
                'meta_description' => $data['meta_description'],
                'status' => 1,
            ])->save();

            // Brand Image
            $imageName = $this->processImage($request, 'image', 'admin/img/brands/', 'jpg');
            $editBrand->image = $imageName;
            $editBrand->save();

            // Brand Logo
            $logoName = $this->processImage($request, 'brand_logo', 'admin/img/brands/logos/', 'jpg');
            $editBrand->brand_logo = $logoName;
            $editBrand->save();

            return redirect()->route('admin.brands.brands')->with('success_message', $message);
        }

        return view('admin.brands.add_edit_brand', compact("title", "editBrand"));
    }

    private function processImage($request, $inputName, $destinationPath, $defaultExtension) {
        $imageName = null;

        if($request->has("cropped_{$inputName}_data")) {
            // Process base64 image
            $base64Image = $request->input("cropped_{$inputName}_data");
            $imageName = $this->saveBase64Image($base64Image, $destinationPath);
        } elseif($request->hasFile($inputName)) {
            // Process uploaded file
            $imageFile = $request->file($inputName);
            $imageName = $this->saveUploadedFile($imageFile, $destinationPath, $defaultExtension);
        }

        return $imageName;
    }

    private function saveBase64Image($base64Image, $destinationPath) {
        if(strpos($base64Image, ';base64,') !== false) {
            list(, $data) = explode(';', $base64Image);
            list(, $data) = explode(',', $data);
            $decodedImage = base64_decode($data);

            $extension = 'jpg'; // Adjust this based on your requirements
            $imageName = rand(111, 90000).'.'.$extension;

            $imagePath = $destinationPath.$imageName;
            file_put_contents($imagePath, $decodedImage);

            return $imageName;
        }

        return null;
    }

    private function saveUploadedFile($file, $destinationPath, $defaultExtension) {
        if($file->isValid()) {
            $extension = $file->getClientOriginalExtension();
            $imageName = rand(111, 90000).'.'.$extension;

            $imagePath = $destinationPath.$imageName;
            Image::make($file)->save($imagePath);

            return $imageName;
        }

        return null;
    }


    public function destroy($id) {
        // Delete
        Brand::where('id', $id)->delete();
        $message = 'Product deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }
}
