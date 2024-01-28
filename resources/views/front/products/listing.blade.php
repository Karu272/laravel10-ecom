@extends('front.layout.layout')
@section('content')
<!-- Side Menu (Hidden on Mobile) -->
@include('front.layout.sidebar')
    <br>
    <div style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);" class="col-md-9">
        <div class="mb-2 mt-1">
            <span style="background-color: white;">&nbsp;FOUND {{ count($categoryProducts) }} RESULTS&nbsp;</span>
            <nav class="mt-4" aria-label="breadcrumb">
                <ol style="background-color: white;" class="breadcrumb">
                    <form name="sortProducts" id="sortProducts">
                        <input type="hidden" name="url" id="url" value="{{ $url }}">
                        <select name="sort" id="sort" class="select_item getsort">
                            <option value="">Sorting</option>
                            <option value="product_latest" @if (isset($_GET['sort']) && $_GET['sort'] == 'product_latest') selected="" @endif>Latest
                                Products</option>
                            <option value="lowest_price" @if (isset($_GET['sort']) && $_GET['sort'] == 'lowest_price') selected="" @endif>Lowest Price
                            </option>
                            <option value="highest_price" @if (isset($_GET['sort']) && $_GET['sort'] == 'highest_price') selected="" @endif>Highest Price
                            </option>
                            <option value="best_selling" @if (isset($_GET['sort']) && $_GET['sort'] == 'best_selling') selected="" @endif>Best Seller
                            </option>
                            <option value="featured_items" @if (isset($_GET['sort']) && $_GET['sort'] == 'featured_items') selected="" @endif>Featured
                                Items</option>
                            <option value="discounted_items" @if (isset($_GET['sort']) && $_GET['sort'] == 'discounted_items') selected="" @endif>Discounted
                                Items</option>
                        </select>
                    </form>
                    <li class="breadcrumb-item ml-auto"><a
                            href="{{ url('/') }}">Home</a>&nbsp;&rarr;<?php echo $getCategoriesDetails['breadcrumbs']; ?>
                    </li>
                </ol>
                <div style="background-color: white;" class="d-md-none"> <!-- Hide on medium and larger screens -->
                    <form class="form-check">
                        @foreach ($colors as $key => $color)
                            <?php
                            if (isset($_GET['color']) && !empty($_GET['color'])) {
                                    $colors = explode('~', $_GET['color']);
                                    if(!empty($colors) &&  in_array($color, $colors)){
                                        $colorcheck = "checked";
                                    }else{
                                        $colorcheck = "";
                                    }
                                }else {
                                    $colorcheck = "";
                                }
                            ?>
                            <div class="form-check-inline mx-2 my-1">
                                <input type="checkbox" id="color{{ $key }}" name="color" value="{{ $color }}" class="form-check-input filterAjax" {{ $colorcheck }}>
                                <label class="form-check-label" for="color{{ $key }}" title="{{ $color }}" style="background-color: {{ $color }}; width: 20px; height: 20px; border: 1px solid #000;"></label>
                                <small class="ml-2">{{ $color }}</small>
                            </div>
                        @endforeach
                    </form>
                </div>
                <hr>
                <div style="background-color: white;" class="d-md-none"> <!-- Hide on medium and larger screens -->
                    <form class="form-check">
                        <span>Size</span>
                        @foreach ($sizes as $key => $size)
                            <?php
                            if (isset($_GET['size']) && !empty($_GET['size'])) {
                                    $sizes = explode('~', $_GET['size']);
                                    if(!empty($sizes) &&  in_array($size, $sizes)){
                                        $sizecheck = "checked";
                                    }else{
                                        $sizecheck = "";
                                    }
                                }else {
                                    $sizecheck = "";
                                }
                            ?>
                            <div class="form-check-inline mx-2 my-1">
                                <input type="checkbox" id="size{{ $key }}" name="size" value="{{ $size }}" class="form-check-input filterAjax" {{ $sizecheck }}>
                                <small class="ml-2">{{ $size }}</small>
                            </div>
                        @endforeach
                ||&nbsp;&nbsp;<span>Brands</span>
                        @foreach ($brands as $key => $brand)
                            <?php
                            if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                                    $brands = explode('~', $_GET['brand']);
                                    if(!empty($brands) &&  in_array($brand, $brands)){
                                        $brandcheck = "checked";
                                    }else{
                                        $brandcheck = "";
                                    }
                                }else {
                                    $brandcheck = "";
                                }
                            ?>
                            <div class="form-check-inline mx-2 my-1">
                                <input type="checkbox" id="brand{{ $key }}" name="brand" value="{{ $brand['id'] }}" class="form-check-input filterAjax" {{ $brandcheck }}>
                                <small class="ml-2">{{ $brand['brand_name'] }}</small>
                            </div>
                        @endforeach
                    </form>
                </div>
                <div style="background-color: white;" class="d-md-none"> <!-- Hide on medium and larger screens -->
                    <form class="form-check">
                        <span>Prices</span>
                        @foreach ($prices as $key => $price)
                            <?php
                            if (isset($_GET['price']) && !empty($_GET['price'])) {
                                    $prices = explode('~', $_GET['price']);
                                    if(!empty($prices) &&  in_array($price, $prices)){
                                        $pricecheck = "checked";
                                    }else{
                                        $pricecheck = "";
                                    }
                                }else {
                                    $pricecheck = "";
                                }
                            ?>
                            <div class="form-check-inline mx-2 my-1">
                                <input type="checkbox" id="price{{ $key }}" name="price" value="{{ $price }}" class="form-check-input filterAjax" {{ $pricecheck }}>
                                <small class="ml-2">{{ $price }}</small>
                            </div>
                        @endforeach
                    </form>
                </div>
            </nav>
        </div>
        <div class="row" id="appendProducts">
            @include('front.products.ajax_products_listing')
        </div>
    </div>
@endsection
