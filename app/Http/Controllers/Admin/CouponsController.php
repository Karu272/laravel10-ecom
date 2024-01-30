<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use Auth;

class CouponsController extends Controller
{
    public function coupons()
    {
        $couponsData = Coupon::get();

        // Set Admin/subadmins Permissions for brands
        $pagesModule = [];

        // Check if the user is an admin
        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else {
            // Retrieve the role for subadmins
            $role = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'coupons'])->first();

            // If no role is found or all permissions are 0, redirect to dashboard
            if (!$role || ($role->view_access == 0 && $role->edit_access == 0 && $role->full_access == 0)) {
                $message = "This feature is restricted for you!";
                return redirect()->route('admin.dashboard')->with('error_message', $message);
            }

            $pagesModule = $role->toArray();
        }


        return view('admin.coupons.coupons', compact('couponsData', 'pagesModule'));
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
            Coupon::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    public function edit(Request $request, $id = null)
    {
        if (empty($id)) {
            $title = "Add Coupon";
            $couponData = new Coupon;
            // We are not able to edit the coupon. So we will only be displaying some of the editable fields.
            $selCats = [];
            $selBrands = [];
            $selUsers = [];
            $message = "Coupon added successfully!";
        } else {
            $title = "Edit Coupon";
            $couponData = Coupon::find($id);
            // We have to cut up the array cuz we sapparate them with comma atm.
            $selCats = explode(',', $couponData['categories']);
            $selBrands = explode(',', $couponData['brands']);
            $selUsers = explode(',', $couponData['users']);
            $message = "Coupon Edited successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // If the user select a category we need to sepperate the category ids by comma
            // For categories
            $categories = isset($data['categories']) ? implode(',', $data['categories']) : '';

            // For brands
            $brands = isset($data['brands']) ? implode(',', $data['brands']) : '';

            // For users
            $users = isset($data['users']) ? implode(',', $data['users']) : '';

            // If Automatic code is selected, we need to generate a random code
            if ($data['coupon_option'] == 'Automatic') {
                $coupon_code = strtoupper(substr(uniqid(sha1(time())), 0, 8));
            } else {
                $coupon_code = $data['coupon_code'];
            }
            //echo "<pre>"; print_r($data); die;

            // Validation rules for adding coupon
            $request->validate([
                'coupon_option' => 'required|in:Automatic,Manual',
                'coupon_code' => $request->input('coupon_option') == 'Manual' ? 'required' : '',
                'amount' => 'required|numeric',
                'amount_type' => 'required|in:Fixed,Percentage',
                'coupon_type' => 'required|in:Multiple,Single',
                'expiry_date' => 'required|date|after_or_equal:today',
            ], [
                'coupon_option.required' => 'The coupon option field is required.',
                'coupon_option.in' => 'The selected coupon option is invalid.',
                'coupon_code.required' => 'The coupon code field is required when the coupon option is set to Manual.',
                'amount.required' => 'The amount field is required.',
                'amount.numeric' => 'The amount must be a number.',
                'amount_type.required' => 'The amount type field is required.',
                'amount_type.in' => 'The selected amount type is invalid.',
                'coupon_type.required' => 'The coupon type field is required.',
                'coupon_type.in' => 'The selected coupon type is invalid.',
                'expiry_date.required' => 'The expiry date field is required.',
                'expiry_date.date' => 'The expiry date must be a valid date.',
                'expiry_date.after_or_equal' => 'The expiry date must be a date after or equal to today.',
            ]);
            // Save the coupon to database
            $couponData->coupon_option = $data['coupon_option'];
            $couponData->coupon_code = $coupon_code;
            $couponData->coupon_type = $data['coupon_type'];
            $couponData->amount = $data['amount'];
            $couponData->amount_type = $data['amount_type'];
            $couponData->expiry_date = $data['expiry_date'];
            $couponData->categories = $categories;
            $couponData->brands = $brands;
            $couponData->users = $users;
            $couponData->status = 1;
            $couponData->save();
            session()->flash('success_message', $message);
            return redirect()->back();
        }


        // Getting the Categories from the model
        $getCategories = Category::getCategories();

        // Getting the Brands from the model
        $getBrands = Brand::where('status', 1)->get()->toArray();

        //Get All User Emails
        $users = User::Select('email')->where('status', 1)->get();

        return view('admin.coupons.add_edit_coupon', compact('couponData', 'title', 'getCategories', 'getBrands', 'users','selCats','selBrands','selUsers'));
    }

    public function destroy($id)
    {
        // Delete
        Coupon::where('id', $id)->delete();
        $message = 'Coupon deleted successfully!';
        session()->flash('success_message', $message);
        return redirect()->back();
    }
}
