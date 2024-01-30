@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <br>
                <br>
                <h3> {{ $title }} </h3>
                <br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('success_message'))
                    <div class="greenDanger alert alert-danger" role="alert">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form name="couponForm" id="couponForm"
                    @if (empty($couponData['id'])) action="{{ route('admin.coupons.add_edit_coupon') }}" @else
          action="{{ route('admin.coupons.add_edit_coupon', ['id' => $couponData['id']]) }}" @endif
                    method="POST" enctype="multipart/form-data">@csrf
                    <div class="form-row">
                        @if (empty($couponData['coupon_code']))
                            <div class="form-group col-md-8">
                                <label for="coupon_option">Coupon Option</label>
                                <span><input type="radio" id="AutomaticCoupon" name="coupon_option" value="Automatic"
                                        checked>&nbsp;Automatic&nbsp;</span>
                                <span><input type="radio" id="ManualCoupon" name="coupon_option"
                                        value="Manual">&nbsp;Manual&nbsp;</span>
                                <br>
                                <div id="couponField" style="display: none;">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                        placeholder="Enter Coupon Code">
                                </div>
                                <br>
                            </div>
                        @else
                            <input type="hidden" name="coupon_option" value="{{ $couponData['coupon_option'] }}">
                            <input type="hidden" name="coupon_code" value="{{ $couponData['coupon_code'] }}">
                            <div class="form-group col-md-8">
                                <label for="coupon_code">Coupon Code:&nbsp;</label>
                                <span><strong>&nbsp;&nbsp;&nbsp;{{ $couponData['coupon_code'] }}</strong></span>
                            </div>
                        @endif
                        <div class="form-group col-md-8">
                            <label for="coupon_type">Coupon Type</label>
                            <span><input type="radio" name="coupon_type" value="Multiple" checked
                                    @if (isset($couponData['coupon_type']) && $couponData['coupon_type'] == 'Multiple') checked @endif>&nbsp;Multiple
                                Times&nbsp;</span>
                            <span><input type="radio" name="coupon_type" value="Single"
                                    @if (isset($couponData['coupon_type']) && $couponData['coupon_type'] == 'Single') checked @endif>&nbsp;Single
                                Time&nbsp;</span>
                            <br>
                            <br>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="amount_type">Amount Type</label>
                            <span><input type="radio" name="amount_type" value="Percentage" checked
                                    @if (isset($couponData['amount_type']) && $couponData['amount_type'] == 'Percentage') checked @endif>&nbsp;Precentage&nbsp;</span>
                            <span><input type="radio" name="amount_type" value="Fixed"
                                    @if (isset($couponData['amount_type']) && $couponData['amount_type'] == 'Fixed') checked @endif>&nbsp;Fixed&nbsp;</span>
                            <br>
                            <br>
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount"
                                placeholder="Enter Amount" value="{{ !empty($couponData) ? $couponData->amount : '' }}">
                            <br>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="categories">Select Category</label>
                            <select name="categories[]" class="form-control" multiple>
                                @foreach ($getCategories as $cat)
                                    <option @if (in_array($cat['id'], $selCats)) selected @endif value="{{ $cat['id'] }}">
                                        &loz; {{ $cat['category_name'] }} &loz;
                                    </option>
                                    @if (!empty($cat['subcategories']))
                                        @foreach ($cat['subcategories'] as $subcat)
                                            <option @if (in_array($subcat['id'], $selCats)) selected @endif
                                                value="{{ $subcat['id'] }}">
                                                &nbsp;&nbsp;&raquo; {{ $subcat['category_name'] }}
                                            </option>
                                            @if (!empty($subcat['subcategories']))
                                                @foreach ($subcat['subcategories'] as $subsubcat)
                                                    <option @if (in_array($subsubcat['id'], $selCats)) selected @endif
                                                        value="{{ $subsubcat['id'] }}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;
                                                        {{ $subsubcat['category_name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <br>
                            <label for="brands">Select Brand</label>
                            <select name="brands[]" class="form-control" multiple>
                                @foreach ($getBrands as $brand)
                                    <option value="{{ $brand['id'] }}" @if (in_array($brand['id'], $selBrands)) selected @endif>
                                        {{ $brand['brand_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <br>
                            <label for="users">Select User</label>
                            <select name="users[]" class="form-control" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user['email'] }}"
                                        @if (in_array($user['email'], $selUsers)) selected @endif>{{ $user['email'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <br>
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                                placeholder="Enter Expiry Date"
                                value="{{ !empty($couponData) ? $couponData->expiry_date : '' }}">
                            <br>
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ url('admin/coupons/coupons') }}">Back</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
