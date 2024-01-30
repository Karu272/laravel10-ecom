@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);"
        class="col-md-10 mx-auto" id="appendCartItems">
        <p id="login-success"></p>
        @include('front.products.cart_items')
    </div>
    <div style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);"
        class="col-md-10 mx-auto">
        <div class="row justify-content-center">
            <div class="coupon-container">
                <form action="javascript:;" method="post" id="ApplyCoupon" @if (Auth::check()) user="1" @endif>
                    @csrf
                    <span class="coupon-span">Apply Coupon Code:</span>
                    <span class="coupon-span"><input class="form-control" name="code" id="code" type="text"
                            style="border: 1px solid black; background: rgb(228, 228, 228);"
                            placeholder="Enter Coupon Code"></span>
                    <span class="coupon-span"><button type="submit" class="btn btn-primary">Apply</button></span>
                </form>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div id="coupon-error"></div>
            <div id="coupon-success" class="mb-3"></div>
        </div>
    </div>
@endsection
