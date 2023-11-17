<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin;
use Hash;
use Log;

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

    public function updatePassword()
    {
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


}
