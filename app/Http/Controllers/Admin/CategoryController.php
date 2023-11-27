<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Set Admin/subadmins Permissions for CMS pages
        $pagesModule = [];

        // Check if the user is an admin
        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->first();

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
}
