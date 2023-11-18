<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Validator;
use Hash;
use Log;
use Session;

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
                'email.requierd' => "Email is required",
                'email.email' => "Valid email is required",
                'password.required' => "Please enter a password",
                'password.password' => "Invalid password",
            ];

            $this->validate($request, $rules, $customMesseges);

            if (
                Auth::guard('admin')->attempt(
                    [
                        'email' => $data['email'],
                        'password' => $data['password']
                    ]
                )
            ) {
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
        Session::put('page','update_password');
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
        Session::put('page','update_admin_details');
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

            $validator = Validator::make($data, $rules, $customMessages);

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

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'image' => $imageName ?? null,
            ]);

            return redirect()->back()->with('success_message', 'Details have been updated!');
        }

        return view('admin.update_admin_details');
    }

}
