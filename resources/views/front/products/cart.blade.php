@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);" class="col-md-10 mx-auto" id="appendCartItems">
        <p id="login-success"></p>
        @include('front.products.cart_items')
    </div>
@endsection
