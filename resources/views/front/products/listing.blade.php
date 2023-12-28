@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-9">
        @include('front.products.filters')
        <div class="row" id="products-listing-container">
                @include('front.products.ajax_products_listing')
        </div>
        <br>
        <div class="here">{{ $categoryProducts->links() }}</div>
    </div>
@endsection
