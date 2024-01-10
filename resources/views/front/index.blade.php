@extends('front.layout.layout')
@section('content')
<!-- Side Menu (Hidden on Mobile) -->
@include('front.layout.sidebar')
    <br>
    <div class="col-md-9" style="background-color: aliceblue">
        <div class="row">
            @if (isset($homeFixedBanner[0]['image']))
                <!-- Banner 1 -->
                <div class="col-md-6 mb-4">
                    <br>
                    <div class="card banner-card">
                        <a href="{{ $homeFixedBanner[0]['link'] }}" title="{{ $homeFixedBanner[0]['title'] }}">
                            <img src="{{ asset('admin/img/banners/' . $homeFixedBanner[0]['image']) }}"
                                class="card-img banner-img" alt="{{ $homeFixedBanner[0]['alt'] }}">
                        </a>
                    </div>
                </div>
            @endif
            @if (isset($homeFixedBanner[1]['image']))
                <!-- Banner 2 -->
                <div class="col-md-6 mb-4">
                    <br>
                    <div class="card banner-card">
                        <a href="{{ $homeFixedBanner[1]['link'] }}" title="{{ $homeFixedBanner[1]['title'] }}">
                            <img src="{{ asset('admin/img/banners/' . $homeFixedBanner[1]['image']) }}"
                                class="card-img banner-img" alt="{{ $homeFixedBanner[1]['alt'] }}">
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <hr>
        <div class="container-fluid">
            <!-- Menu Row -->
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="mb-0">TOP TRENDING</h2>
                    <p class="text-muted mb-4"><small>Choose category:</small></p>
                    <!-- Add your category buttons here using Bootstrap's button styles -->
                    <button type="button" class="btn btn-outline-primary category-btn" data-category="all">ALL</button>
                    <button type="button" class="btn btn-outline-primary category-btn" data-category="new_arrivals">NEW
                        ARRIVALS</button>
                    <button type="button" class="btn btn-outline-primary category-btn" data-category="best_sellers">BEST
                        SELLERS</button>
                    <button type="button" class="btn btn-outline-primary category-btn"
                        data-category="discounted_products">DISCOUNTED PRODUCTS</button>
                    <button type="button" class="btn btn-outline-primary category-btn"
                        data-category="featured_products">FEATURED PRODUCTS</button>
                </div>
            </div>

            <!-- Product Cards -->
            <div class="row" id="product-container">
                <!-- Sample Product Card -->
                @foreach ($randomProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-3 mb-4 category-product" data-category="all">
                        <div class="card" style="height: 100%;">
                            <!-- Product Image -->
                            @if (is_array($item['images']) && count($item['images']) > 0)
                                @php
                                    $randomImageIndex = array_rand($item['images']); // Get a random index
                                    $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                @endphp
                                <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}" class="card-img-top"
                                    alt="Product Image" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <!-- Brand Name -->
                                <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}</p>
                                <!-- Product Name -->
                                <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                <!-- Prices -->
                                <div class="d-flex justify-content-between">
                                    @if ($item['product_discount'] > 0)
                                        <p class="card-text category-new-price">
                                            New Price: {{ $item['final_price'] }} ({{ $item['product_discount'] }}% off)
                                        </p>
                                        <p class="card-text text-muted category-old-price">
                                            Old Price: <span
                                                style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                            <span class="badge badge-danger">{{ $item['product_discount'] }}% off</span>
                                        </p>
                                    @else
                                        <p class="card-text category-new-price">Price: {{ $item['product_price'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($newProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-3 mb-4 category-product" data-category="new_arrivals">
                        <div class="card" style="height: 100%;">
                            <!-- Product Image -->
                            @if (is_array($item['images']) && count($item['images']) > 0)
                                @php
                                    $randomImageIndex = array_rand($item['images']); // Get a random index
                                    $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                @endphp
                                <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}" class="card-img-top"
                                    alt="Product Image" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <!-- Brand Name -->
                                <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}</p>
                                <!-- Product Name -->
                                <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                <!-- Prices -->
                                <div class="d-flex justify-content-between">
                                    @if ($item['product_discount'] > 0)
                                        <p class="card-text category-new-price">
                                            New Price: {{ $item['final_price'] }} ({{ $item['product_discount'] }}% off)
                                        </p>
                                        <p class="card-text text-muted category-old-price">
                                            Old Price: <span
                                                style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                            <span class="badge badge-danger">{{ $item['product_discount'] }}% off</span>
                                        </p>
                                    @else
                                        <p class="card-text category-new-price">Price: {{ $item['product_price'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($bestSellerProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-3 mb-4 category-product" data-category="best_sellers">
                        <div class="card" style="height: 100%;">
                            <!-- Product Image -->
                            @if (is_array($item['images']) && count($item['images']) > 0)
                                @php
                                    $randomImageIndex = array_rand($item['images']); // Get a random index
                                    $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                @endphp
                                <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}" class="card-img-top"
                                    alt="Product Image" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <!-- Brand Name -->
                                <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}</p>
                                <!-- Product Name -->
                                <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                <!-- Prices -->
                                <div class="d-flex justify-content-between">
                                    @if ($item['product_discount'] > 0)
                                        <p class="card-text category-new-price">
                                            New Price: {{ $item['final_price'] }} ({{ $item['product_discount'] }}% off)
                                        </p>
                                        <p class="card-text text-muted category-old-price">
                                            Old Price: <span
                                                style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                            <span class="badge badge-danger">{{ $item['product_discount'] }}% off</span>
                                        </p>
                                    @else
                                        <p class="card-text category-new-price">Price: {{ $item['product_price'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($discountProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-3 mb-4 category-product" data-category="discounted_products">
                        <div class="card" style="height: 100%;">
                            <!-- Product Image -->
                            @if (is_array($item['images']) && count($item['images']) > 0)
                                @php
                                    $randomImageIndex = array_rand($item['images']); // Get a random index
                                    $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                @endphp
                                <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}" class="card-img-top"
                                    alt="Product Image" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <!-- Brand Name -->
                                <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}</p>
                                <!-- Product Name -->
                                <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                <!-- Prices -->
                                <div class="d-flex justify-content-between">
                                    @if ($item['product_discount'] > 0)
                                        <p class="card-text category-new-price">
                                            New Price: {{ $item['final_price'] }} ({{ $item['product_discount'] }}% off)
                                        </p>
                                        <p class="card-text text-muted category-old-price">
                                            Old Price: <span
                                                style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                            <span class="badge badge-danger">{{ $item['product_discount'] }}% off</span>
                                        </p>
                                    @else
                                        <p class="card-text category-new-price">Price: {{ $item['product_price'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($featuredProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-3 mb-4 category-product" data-category="featured_products">
                        <div class="card" style="height: 100%;">
                            <!-- Product Image -->
                            @if (is_array($item['images']) && count($item['images']) > 0)
                                @php
                                    $randomImageIndex = array_rand($item['images']); // Get a random index
                                    $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                @endphp
                                <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}" class="card-img-top"
                                    alt="Product Image" style="max-width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <!-- Brand Name -->
                                <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}</p>
                                <!-- Product Name -->
                                <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                <!-- Prices -->
                                <div class="d-flex justify-content-between">
                                    @if ($item['product_discount'] > 0)
                                        <p class="card-text category-new-price">
                                            New Price: {{ $item['final_price'] }} ({{ $item['product_discount'] }}% off)
                                        </p>
                                        <p class="card-text text-muted category-old-price">
                                            Old Price: <span
                                                style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                            <span class="badge badge-danger">{{ $item['product_discount'] }}% off</span>
                                        </p>
                                    @else
                                        <p class="card-text category-new-price">Price: {{ $item['product_price'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
