@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-9">
        <div class="mb-2 mt-1">
            <span style="background-color: white;">&nbsp;FOUND {{ count($categoryProducts) }} RESULTS&nbsp;</span>
            <nav class="mt-4" aria-label="breadcrumb">
                <ol style="background-color: white;" class="breadcrumb">
                    <form name="sortProducts" id="sortProducts">
                        <select name="sort" id="sort" class="select_item">
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
            </nav>
        </div>
        <div class="row" id="products-listing-container">
            @foreach ($categoryProducts as $item)
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3 mb-4 ">
                    <br>
                    <div class="card" style="height: 100%;">
                        <!-- Product Image -->
                        @php
                            $images = $item['images'];
                            $randomImage = null;

                            if ($images->isNotEmpty()) {
                                $randomImageIndex = array_rand($images->toArray()); // Get a random index
                                $randomImage = $images[$randomImageIndex]['image']; // Use the 'image' key from the nested array
                            }
                        @endphp

                        @if ($randomImage)
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
        <br>
        <div class="here">{{ $categoryProducts->links() }}</div>
    </div>
@endsection
