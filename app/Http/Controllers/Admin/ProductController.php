<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AdminsRole;
use App\Models\Category;
use Session;
use Auth;


class ProductController extends Controller
{
    public function index()
    {
        Session::put('page', 'products');
        $getProductDBdata = Product::all();
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
        if ($id == "") {
            $title = "Add Product";
            $editPro = new Product;
            $message = "Product added successfully!";
        } else {
            $title = "Edit Product";
            $editPro = Product::find($id);
            $message = "Product Edited successfully!";
        }

        return view("admin.products.add_edit_product", compact("title","editPro","message"));
    }

    public function destroy($id)
    {
        // Delete
        Product::where('id', $id)->delete();
        $message = 'Product deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function destroycatproimg($id)
    {
        // Get product img
        $productImg = Product::select('image')->where('id', $id)->first();

        // Get product Img path
        $product_image_path = 'admin/img/products/';

        // Delete product Image from products folder if exists
        if (file_exists($product_image_path . $productImg->image)) {
            unlink($product_image_path . $productImg->image);
        }

        // Delete product Img from products table
        Product::where('id', $id)->update(['image' => '']);

        return redirect()->back()->with('success_message', 'Product img deleted successfully');
    }
}
