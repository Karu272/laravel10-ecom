<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AdminsRole;
use Auth;
use Session;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categoriesDBdata = Category::with('parentcategory')->get()->toArray();
        //dd($categoriesDBdata);

        // Set Admin/subadmins Permissions for Categories
        $pagesModule = [];

        // Check if the user is an admin
        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->first();

            // If no role is found or all permissions are 0, redirect to dashboard
            if (!$role || ($role->view_access == 0 && $role->edit_access == 0 && $role->full_access == 0)) {
                $message = "This feature is restricted for you!";
                return redirect()->route('admin.dashboard')->with('error_message', $message);
            }

            $pagesModule = $role->toArray();
        }

        return view('admin.categories.categories', compact('categoriesDBdata','pagesModule'));
    }

    public function update(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function edit(Request $request, $id = null){
        $getCategories = Category::getCategories();

        if ($id == "") {
            $title = "Add Category";
            $editCat = new Category;
            $message = "Category added successfully!";
        } else {
            $title = "Edit Category";
            $editCat = Category::find($id);
            $message = "Category Edited successfully!";
        }
        //dd($editCat);
        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $imageName = null; // Initialize $imageName

            $rules = [
                'category_name' => 'required|max:255',
                'description' => 'required',
                'url' => 'required|unique:categories',
                'image' => 'image',
            ];

            $customMessages = [
                'category_name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'url.required' => 'URL is required',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $editCat->category_name = $data['category_name'];
            $editCat->parent_id = $data['parent_id'];
            $editCat->category_discount = $data['category_discount'];
            $editCat->description = $data['description'];
            $editCat->url = $data['url'];
            $editCat->meta_title = $data['meta_title'];
            $editCat->meta_keywords = $data['meta_keywords'];
            $editCat->meta_description = $data['meta_description'];
            $editCat->status = 1;
            $editCat->save();

            if ($request->has('cropped_image_data')) {
                $base64Image = $request->input('cropped_image_data');

                // Check if the base64 data is present and properly formatted
                if (strpos($base64Image, ';base64,') !== false) {
                    list(, $data) = explode(';', $base64Image);
                    list(, $data) = explode(',', $data);
                    $decodedImage = base64_decode($data);

                    // Get Image Extension
                    $extension = 'jpg'; // Adjust this based on your requirements

                    // Generate New Name
                    $imageName = rand(111, 90000) . '.' . $extension;

                    // Save Image
                    $image_path = 'admin/img/categories/' . $imageName;
                    file_put_contents($image_path, $decodedImage);
                } else {
                    // Handle the case where the base64 data is not in the expected format
                    return redirect()->back()->with('error_message', 'Invalid image data format.');
                }
            } else if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Name
                    $imageName = rand(111, 90000) . '.' . $extension;

                    // Save Image
                    $image_path = 'admin/img/categories/' . $imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            }

            // Update Admin Details
            $editCat->image = $imageName ?? null;
            $editCat->save();


            return redirect()->route('categories.categories')->with('success_message', $message);
        }

        return view('admin.categories.add_edit_category', compact("title", "editCat","getCategories"));
    }

    public function destroy($id){
        // Delete
        Category::where('id', $id)->delete();
        $message = 'Category deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function destroycatimg($id){
        // Get Category img
        $categoryImg = Category::select('image')->where('id',$id)->first();

        // Get Category Img path
        $category_image_path = 'admin/img/categories/';

        // Delete Category Image from categories folder if exists
        if(file_exists($category_image_path . $categoryImg->image)){
            unlink($category_image_path . $categoryImg->image);
        }

        // Delete Category Img from categories table
        Category::where('id', $id)->update(['image' => '']);

        return redirect()->back()->with('success_message', 'Category img deleted successfully');
    }
}
