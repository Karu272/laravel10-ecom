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
                    // unique:users is checking if the email is already taken in users table
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
                Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
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

    public function confirmAccount($code)
    {
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                return redirect('/login')->with('error_message', 'Your account is already activated. Please login to your account.');
            } else {
                User::where('email', $email)->update(['status' => 1]);
                // Send Welcome Email
                $messageData = [
                    'name' => $userDetails->name,
                    'email' => $email,
                ];
                \Log::info('About to send confirmation email to: ' . $email);
                Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Laravel 10 confirmation email');
                });
                // Redirect user to the login page with success message
                return redirect('/login')->with('success_message', 'Your account is activated successfully. Please login to your account.');
            }
        } else {
            abort(404);
        }
    }

    public function login(Request $request)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);

        // Validation when login form is submitted
        if ($request->ajax()) {
            $data = $request->all();

            $validator = Validator::make(
                $request->all(),
                [
                    // exist in the database named users
                    'email' => 'required|string|email|max:255|exists:users',
                    'password' => 'required|min:6',
                ],
                [
                    'email.email' => 'Please enter a valid email address',
                    'email.exists' => 'Email does not exists in our database',
                    'password.required' => 'Please enter a password',
                ]
            );
            if ($validator->passes()) {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    // Remember the user after login with cookies using the checkbox
                    if (!empty($data['remember-me'])) {
                        setcookie("user-email", $data['email'], time() + 3600);
                        setcookie("user-password", $data['password'], time() + 3600);
                    } else {
                        setcookie("user-email");
                        setcookie("user-password");
                    }

                    // Message the user if the account is not activated or not
                    if (Auth::user()->status == 0) {
                        Auth::logout();
                        return response()->json([
                            'status' => false,
                            'type' => 'inactivated',
                            'message' => 'Your account is not activated. Please check your email to activate your account.'
                        ]);
                    }
                    // Send the user to the cart page if logged in
                    $redirectUrl = url('/cart');
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'redirectUrl' => $redirectUrl,
                        'message' => 'You have successfully logged in.'
                    ]);
                } else {
                    // If the login fails with either passowrd or email, return error message
                    return response()->json([
                        'status' => false,
                        'type' => 'incorrect',
                        'message' => 'Invalid email or password. Please try again.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'type' => 'error',
                    'errors' => $validator->messages()
                ]);
            }
        }
        return view('front.users.login', compact('homeSliderBanner', 'categories'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        if ($request->ajax()) {
            $data = $request->all();

            $validator = Validator::make(
                $request->all(),
                [
                    // exist in the database named users
                    'email' => 'required|string|email|max:255|exists:users',
                ],
                [
                    'email.email' => 'Please enter a valid email address',
                    'email.exists' => 'Email does not exists in our database',
                ]
            );

            if ($validator->passes()) {
                // Send email with reset password link
                $email = $data['email'];
                $messageData = ['email' => $data['email'], 'code' => base64_encode($data['email'])];

                \Log::info('About to send reset password email to: ' . $email);
                Mail::send('emails.reset_password', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Reset password email');
                });

                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'message' => 'A reset password link has been sent to your email address.'
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'type' => 'error',
                    'errors' => $validator->messages()
                ]);
            }

        } else {
            return view('front.users.forgot_password', compact('homeSliderBanner', 'categories'));
        }
    }

    public function resetPassword(Request $request, $code = null)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();
        //dd($categories);
        if ($request->ajax()) {
            $data = $request->all();
            //echo '<pre>'; print_r($data); die;
            // decode the code
            $email = base64_decode($data['code']);
            // check if the email/user exists in the database
            $userCount = User::where('email', $email)->count();
            if ($userCount > 0) {
                // Update new password
                User::where('email', $email)->update(['password' => bcrypt($data['password'])]);
                // Send Confermation email to user that password has been changed
                $messageData = ['email' => $email];
                \Log::info('About to send reset confirm email to: ' . $email);
                Mail::send('emails.new_pwd_confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Password changed successfully - Laravel10 e-com');
                });
                // Show success message
                return response()->json([
                    'type' => 'success',
                    'message' => 'Password changed successfully. Please login with your new password.'
                ]);
            } else {
                abort(404);
            }

        } else {
            return view('front.users.reset_password', compact('code', 'categories', 'homeSliderBanner'));
        }
    }

    public function account(Request $request)
    {
        // Getting the banners
        $homeSliderBanner = Banner::where('type', 'slider')->where('status', 1)->orderBy('sort', 'ASC')->get()->toArray();
        // Fetching the categories and subcategories
        $categories = Category::getCategories();

        // Update user details with ajax request
        if ($request->ajax()) {
            $data = $request->all();
            //echo '<pre>'; print_r($data); die;

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255', // Required validation rule for name
                    'address' => 'required|string|max:255', // Required validation rule for address
                    'city' => 'required|string|max:255', // Required validation rule for city
                    'state' => 'required|string|max:255', // Required validation rule for state
                    'country' => 'required|string|max:255', // Required validation rule for country
                    'zip' => 'required|string|max:20', // Required validation rule for zip
                    'phone' => 'required|numeric', // Required validation rule for phone
                ]
            );

            if ($validator->passes()) {
                // Update user details
                User::where('id', Auth::user()->id)->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'zip' => $data['zip'],
                    'phone' => $data['phone']
                ]);
                // Redirect user with success message
                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'message' => 'Your account details have been updated successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'type' => 'validation',
                    'errors' => $validator->messages()
                ]);
            }

        } else {
            return view('front.users.account', compact('homeSliderBanner', 'categories', ));
        }
    }
}
