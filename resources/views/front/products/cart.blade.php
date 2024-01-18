@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-10 mx-auto" id="appendCartItems">
        @include('front.products.cart_items')
    </div>
@endsection
