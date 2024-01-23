<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Banner;
use App\Models\Category;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        \Log::info('Received request data:', $request->all());
        if ($request->ajax()) {
            // Make a validation for registration form
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:150',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ],
                [
                    'name.required' => 'Please enter your name',
                    'email.email' => 'Please enter a valid email address',
                    'password.required' => 'Please enter a password',
                    'password.min' => 'Password must be at least 6 characters',
                ]
            );

            if ($validator->passes()) {
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                // Activate the user only after user confirm his email account
                // Send Conformation Email
                $email = $data['email'];
                $messageData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'code' => base64_encode($data['email']),
                ];
                Mail::send('emails.confirmation', $messageData, function($message) use($email) {
                    $message->to($email)->subject('Confirm your email address');
                });

                // Redirect bavk user with a success message
                $redirectUrl = url('/login');
                return response()->json(['status' => true, 'type' => 'success', 'redirectUrl' => $redirectUrl, 'message' => 'You have successfully registered. Please check your email to confirm your account.']);
            } else {
                return response()->json(['status' => false, 'type' => 'validation', 'errors' => $validator->messages()]);
            }
        }
        return view('front.users.register', compact('homeSliderBanner', 'categories'));
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if($userCount > 0){
            $userDetails = User::where('email', $email)->first();
            if($userDetails->status == 1){
                return redirect('/login')->with('flash_message_error', 'Your account is already activated. Please login to your account.');
            }else{
               User::where('email', $email)->update(['status' => 1]);
               // Send Welcome Email
               $messageData = [
                   'name' => $userDetails->name,
                   'email' => $email,
               ];
               \Log::info('About to send confirmation email to: ' . $email);
               Mail::send('emails.register', $messageData, function($message) use($email) {
                   $message->to($email)->subject('Laravel 10 confirmation email');
               });
               // Redirect user to the login page with success message
               return redirect('/login')->with('success_messge', 'Your account is activated successfully. Please login to your account.');
            }
        }else{
            abort(404);
        }
    }

    public function login()
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        return view('front.users.login', compact('homeSliderBanner', 'categories'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
