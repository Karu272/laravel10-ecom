<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\CmsPage;
use App\Models\AdminsRole;
use Auth;
use Validator;
use Hash;
use Log;
use Session;
use DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30',
            ];

            $customMesseges = [
                'email.required' => "Email is required",
                'email.email' => "Valid email is required",
                'password.required' => "Please enter a password",
                'password.password' => "Invalid password",
            ];

            $this->validate($request, $rules, $customMesseges);

            if (
                Auth::guard('admin')->attempt(
                    [
                        'email' => $data['email'],
                        'password' => $data['password'],
                        'status' => 1,
                    ]
                )
            ) {
                // Remember Admin email & password with cookies
                if (isset($data['remember']) && !empty($data['remember'])) {
                    setcookie('email', $data['email'], time() + 3600);
                    setcookie('password', $data['password'], time() + 3600);
                } else {
                    setcookie('email', '');
                    setcookie('password', '');
                }

                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password!');
            }

        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function updatePassword(Request $request)
    {
        Session::put('page', 'update_password');
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();

                if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                    // Check if the new and confirm passwords match
                    if ($data['new_pwd'] == $data['confirm_pwd']) {
                        // Update new password
                        Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => Hash::make($data['new_pwd'])]);
                        return redirect()->back()->with('success_message', "Your new password has been updated!");
                    } else {
                        return redirect()->back()->with('error_message', "Your new password and confirmation password do not match!");
                    }
                } else {
                    return redirect()->back()->with('error_message', "Your current password is incorrect!");
                }
            } catch (\Exception $e) {
                Log::error('Error in updatePassword: ' . $e->getMessage());
                return "error";
            }
        }

        return view('admin.update_password');
    }


    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();

        try {
            if (isset($data['current_password']) && Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                return "true";
            } else {
                return "false";
            }
        } catch (\Exception $e) {
            Log::error('Error in checkCurrentPassword: ' . $e->getMessage());
            return "error";
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update_admin_details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $imageName = null; // Initialize $imageName

            $rules = [
                'admin_name' => 'required|alpha|max:255',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image',
            ];

            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Only numbers are required',
                'admin_image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'name' => $data['admin_name'],
                'mobile' => $data['admin_mobile'],
            ]);
            // =================== Image crop and upload ===================
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
                    $image_path = 'admin/img/' . $imageName;
                    file_put_contents($image_path, $decodedImage);
                } else {
                    // Handle the case where the base64 data is not in the expected format
                    return redirect()->back()->with('error_message', 'Invalid image data format.');
                }
            } else if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Name
                    $imageName = rand(111, 90000) . '.' . $extension;

                    // Save Image
                    $image_path = 'admin/img/' . $imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            }

            // Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'image' => $imageName ?? null,
            ]);

            return redirect()->back()->with('success_message', 'Details have been updated!');
        }

        return view('admin.update_admin_details');
    }

    public function subadmins()
    {
        $subadminDbData = Admin::where('type', 'subadmin')->get();

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

        return view('admin.subadmins.subadmins', compact('subadminDbData','pagesModule'));
    }

    // Update status on Subadmin
    public function updateSubadmin(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function editSubadmin(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add SubAdmin";
            $subadmin = new Admin;
            $message = "SubAdmin added successfully!";
        } else {
            $title = "Edit SubAdmin";
            $subadmin = Admin::find($id);
            $message = "SubAdmin Edited successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $imageName = null; // Initialize $imageName

            if ($id == "") {
                $subadminCount = Admin::where('email', $data['email'])->count();
                if ($subadminCount > 0) {
                    return redirect()->back()->with('error_message', 'Subadmin already exists!');
                }
            }


            $rules = [
                'name' => 'required|max:255',
                'mobile' => 'required|numeric',
                'password' => 'required',
                'image' => 'image',
            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric' => 'Only numbers are required',
                'email.required' => 'Email is required',
                'email.email' => 'Incorrect email syntax',
                'password.required' => 'Password reuired',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $subadmin->name = $data['name'];
            $subadmin->mobile = $data['mobile'];
            if ($id == "") {
                $subadmin->email = $data["email"];
                $subadmin->type = 'subadmin';
            }
            if ($data['password'] != "") {
                $subadmin->password = bcrypt($data['password']);
            }
            $subadmin->save();

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
                    $image_path = 'admin/img/' . $imageName;
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
                    $image_path = 'admin/img/' . $imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            }

            // Update Admin Details
            $subadmin->image = $imageName ?? null;
            $subadmin->save();


            return redirect()->route('subadmins.subadmins')->with('success_message', $message);
        }

        return view("admin.subadmins.add_edit_subadmin", compact("title", "subadmin"));
    }

    public function destroySubadmin($id)
    {
        // Delete
        Admin::where('id', $id)->delete();
        $message = 'Subadmin deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function updateRole(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Delete all earlier roles for subadmin
            AdminsRole::where('subadmin_id', $id)->delete();

            $permissions = ['view', 'edit', 'full'];

            $role = new AdminsRole;
            $role->subadmin_id = $id;
            $role->module = 'cms_pages';

            foreach ($permissions as $permission) {
                $storedData = "cms_pages_$permission";

                // The double dollar sign ($$) is used for variable variables in PHP.
                // It takes the value of the variable whose name is stored in $variable_name.
                if (isset($data['cms_pages'][$permission])) {
                    $$storedData = $data['cms_pages'][$permission];
                } else {
                    $$storedData = 0;
                }

                // Assign values to the corresponding attributes of the $role object
                //  if $permission is 'view', it becomes 'view_access'.
                $role->{$permission . '_access'} = $$storedData;
            }
            $role->save();

            $message = 'Subadmin Roles Updated Successfully!';
            return redirect()->back()->with('success_message', $message);
        }

        // if already selected. show -> when enter edit part.
        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();

        $subadminDetails = Admin::where('id', $id)->first()->toArray();
        $title = 'Update ' . $subadminDetails['name'] . ' Roles & Permissions';

        return view('admin.subadmins.update_role', compact('title', 'id', 'subadminRoles'));
    }


    // ====================== Cms Pages ======================

    public function index()
    {
        Session::put('page', 'cms-pages');
        $CmsPages = CmsPage::get()->toArray();

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

        return view('admin.pages.cms_pages', compact('CmsPages', 'pagesModule'));
    }


    // Update status value
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function edit(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add CMS Page";
            $cmspage = new CmsPage;
            $message = "CMS Page Info added successfully!";
        } else {
            $title = "Edit CMS Page";
            $cmspage = CmsPage::find($id);
            $message = "CMS Page Edited successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            // CMS PAges Validation
            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
            ];
            $customMessages = [
                'title.required' => 'Page Title is required',
                'url.required' => 'Page URL is required',
                'description.required' => 'Page Description is required',
            ];
            $this->validate($request, $rules, $customMessages);

            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_keywords = $data['meta_keywords'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->status = 1;
            $cmspage->save();
            return redirect('admin/pages/cms-pages')->with('success_message', $message);
        }

        return view('admin.pages.add_edit_cmsPage', compact("title", "cmspage"));
    }


    public function destroy($id)
    {
        // Delete
        CmsPage::where('id', $id)->delete();
        $message = 'CMS Page deleted successfully!';
        session::flash('success_message', $message);
        return redirect()->back();
    }


}