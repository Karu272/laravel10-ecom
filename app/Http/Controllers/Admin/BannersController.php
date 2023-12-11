<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\AdminsRole;
use Auth;

class BannersController extends Controller
{
    public function index()
    {
        $bannersDBdata = Banner::all();
        //dd($bannersDBdata);

        // Set Admin/subadmins Permissions for banners
        $pagesModule = [];

        // Check if the user is an admin
        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->first();

            // If no role is found or all permissions are 0, redirect to dashboard
            if (!$role || ($role->view_access == 0 && $role->edit_access == 0 && $role->full_access == 0)) {
                $message = "This feature is restricted for you!";
                return redirect()->route('admin.dashboard')->with('error_message', $message);
            }

            $pagesModule = $role->toArray();
        }

        return view('admin.banners.banners', compact('bannersDBdata', 'pagesModule'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function edit(Request $request, $id = null)
    {
        if ($id == "") {
            $bannerData = new Banner;
            $title = "Add new banner";
            $message = "Banner added successfully!";
        } else {
            $bannerData = Banner::find($id);
            $title = "Edit banner";
            $message = "Banner edited successfully!";
        }

        if ($request->isMethod("post")) {
            $data = $request->all();

            $rules = [
                'image' => 'image',
                'link' => 'required|unique:banners,link,' . $bannerData->id,
                'title' => 'required|max:255',
                'alt' => 'required|max:255',
            ];

            $customMessages = [
                'image.image' => 'The uploaded file must be an image',
                'type.required' => 'Type is required',
                'title.required' => 'Title is required',
                'alt.required' => 'Alt text is required',
                'link.required' => 'Unique link required'
            ];

            $this->validate($request, $rules, $customMessages);

            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(11, 9999) . '.' . $extension;
                    // set path
                    $image_path = 'admin/img/banners/' . $imageName;

                    Image::make($image_tmp)->resize(1500, 500)->save($image_path);
                    $bannerData->image = $imageName;
                }
            }

            $bannerData->type = $data['type'];
            $bannerData->link = $data['link'];
            $bannerData->title = $data['title'];
            $bannerData->alt = $data['alt'];
            $bannerData->sort = $data['sort'];
            $bannerData->status = 1;
            $bannerData->save();

            return redirect()->route('admin.banners.banners')->with('success_message', $message);
        }

        return view('admin.banners.add_edit_banner', compact("title", "bannerData"));
    }

}
