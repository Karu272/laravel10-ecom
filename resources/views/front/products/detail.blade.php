@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-10 mx-auto">
        <br>
        <div class="container-fluid text-center">
            <div class="row justify-content-center">
                <!-- Move col-md-4 to the left of col-md-8 -->
                <div class="col-md-4 ">
                    <nav class="mt-4" aria-label="breadcrumb">
                        <ol style="background-color: white;" class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a>&nbsp;&rarr;<?php echo $getCategoriesDetails['breadcrumbs']; ?>
                            </li>
                        </ol>
                    </nav>
                    <hr>
                    <!-- FIX THIS WITH JAVASCRIPT LATER -->
                    <div class="imgcard">
                        <!-- Product Image -->
                        @php
                            $images = $productDetails['images'];
                            $randomImage = null;

                            if (!empty($images)) {
                                $randomImageIndex = array_rand($images); // Get a random index
                                $randomImage = $images[$randomImageIndex]['image']; // Use the 'image' key from the nested array
                            }
                        @endphp
                        <!-- Center and make largeimg span full width -->
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                @if ($randomImage)
                                    <img src="{{ asset('admin/img/products/small/' . $randomImage) }}" alt="product image"
                                        class="img-fluid largeimg">
                                @else
                                    <img src="{{ asset('admin/img/no-img.png') }}" class="img-fluid largeimg"
                                        alt="No Image">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="smallerrow row">
                            @foreach ($productDetails['images'] as $item)
                                <!-- Arrange small images horizontally using Bootstrap grid -->
                                @if ($loop->index < 4)
                                    <div class="col-md-3">
                                        <!-- Limit to 4 images -->
                                        @if (isset($item['image']))
                                            <img src="{{ asset('admin/img/products/small/' . $item['image']) }}"
                                                alt="small product image" class="img-fluid small1">
                                        @else
                                            <img src="{{ asset('admin/img/no-img.png') }}" class="img-fluid small1"
                                                alt="No Image">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!-- ///// FIX THIS WITH JAVASCRIPT LATER -->
                </div>
                <div class="col-md-4 ">
                    <div class="txtcard">
                        <div style="display: flex; align-items: center;">
                            <p class="mb-0 mr-1">FROM</p>
                            <h2 style="display: flex; align-items: center;">
                                {{ $productDetails['brand']['brand_name'] }}
                                <i class="fas fa-long-arrow-alt-right ml-2 mr-2"></i>
                                {{ $productDetails['product_name'] }}
                            </h2>
                        </div>
                        <span class="d-flex align-items-end getAttributePrice">&nbsp;&nbsp;&nbsp;
                            @if (isset($productDetails['product_discount']))
                                <h1 class="mb-0" style="color: orange">{{ $productDetails['final_price'] }}Kr</h1>
                                <span class="d-flex align-items-end">&nbsp;&nbsp;&nbsp;
                                    <p class="mb-0 mr-3" style="color: orange">({{ $productDetails['product_discount'] }}%
                                        off)
                                    </p>
                                </span>
                                <span class="d-flex align-items-end">
                                    <p class="mb-0 mr-3" style="text-decoration: line-through;">
                                        {{ $productDetails['product_price'] }}</p>
                                </span>
                            @else
                                <h1 class="mb-0" style="color: orange">{{ $productDetails['final_price'] }}Kr</h1>
                            @endif
                        </span>
                        <br>
                        <span class="d-flex">
                            <p class="mr-3 detail-stock-green">200 in stock</p>
                            <p class="mr-3 detail-stock-orange">Only 2 left</p>
                        </span>
                        <br>
                        <div class="d-flex flex-column align-items-start">
                            <h5 >Description:</h5>
                            <p>{{ $productDetails['meta_description'] }}</p>
                        </div>
                        <br>
                        <a class="d-flex" href="#">
                            <i class="mr-3">&hearts;</i>
                            <p class="mr-3">Add to wishlist</p>
                        </a>
                        <br>
                        <span class="d-flex social-icons">
                            <i class="fab fa-facebook"></i>
                            <i class="fab fa-twitter"></i>
                            <i class="fab fa-instagram"></i>
                            <i class="fab fa-whatsapp"></i>
                            <i class="fab fa-google-plus"></i>
                        </span>
                        <br>
                        <span class="d-flex">
                            <h6 class="mr-3">Color:&nbsp;</h6>
                            @if (count($groupProducts) > 0)
                                @foreach ($groupProducts as $item)
                                    <a href="{{ url('product/' . $item['id']) }}">
                                        <label style="background-color: {{ $item['family_color'] }};" for="folly"
                                            class="mr-3 colorBtn"></label>
                                    </a>
                                @endforeach
                            @endif
                        </span>
                        <br>
                        <div class="d-flex">
                            <h6 class="mr-3">Size:&nbsp; </h6>
                            @foreach ($productDetails['attributes'] as $attribute)
                                @if ($attribute['stock'] > 0 && $attribute['status'] === 1)
                                    <div class="mr-3 detail-size">
                                        <input type="radio" id="{{ $attribute['size'] }}"
                                            value="{{ $attribute['size'] }}" product-id="{{ $productDetails['id'] }}"
                                            class="getPrice visually-hidden" name="size" checked>
                                        <label for="{{ $attribute['size'] }}">{{ $attribute['size'] }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <br>
                        <span class="d-flex">
                            <p class="minusBtn mr-3">-</p>
                            <p class="quantity mr-3">5</p>
                            <p class="plusBtn mr-3">+</p>
                            <button class="mr-3 btn btn-success btn1" type="submit">Add to Cart</button>
                        </span>
                        <br>
                        <div class="d-flex flex-column align-items-start">
                            <h6>Product Policy:</h6>
                            <p><i class="fas fa-check-circle text-success"></i> Buyer protection.</p>
                            <p><i class="fas fa-check-circle text-success"></i> Full Refund if you don't receive your order.
                            </p>
                            <p><i class="fas fa-check-circle text-success"></i> Returns accapted if product not as
                                described.
                            </p>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
                <!-- Move col-md-12 mx-auto to the bottom -->
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="container-fluid">
                            <!-- Menu Row -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <br>
                                    <button type="button" class="btn btn-outline-primary category-btn"
                                        data-category="description">Description</button>
                                    <button type="button" class="btn btn-outline-primary category-btn"
                                        data-category="video">Video</button>
                                    <button type="button" class="btn btn-outline-primary category-btn"
                                        data-category="reviews">Reviews <small>(23)</small></button>
                                </div>
                            </div>
                            <!-- Menu Row -->
                            <div class="row" id="product-container">
                                <div class="col-md-3 mb-4 category-product" data-category="description">
                                    <h6>Description</h6>
                                    <p>{{ $productDetails['description'] }}</p>
                                    <div class="container mt-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    @if (isset($productDetails['brand']['brand_name']))
                                                        <tr>
                                                            <td>Brand</td>
                                                            <td>{{ $productDetails['brand']['brand_name'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['product_code']))
                                                        <tr>
                                                            <td>Product Code</td>
                                                            <td>{{ $productDetails['product_code'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['product_color']))
                                                        <tr>
                                                            <td>Product Color</td>
                                                            <td>{{ $productDetails['product_color'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['family_color']))
                                                        <tr>
                                                            <td>Family Color</td>
                                                            <td>{{ $productDetails['family_color'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['product_weight']))
                                                        <tr>
                                                            <td>Product Weight</td>
                                                            <td>{{ $productDetails['product_weight'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['group_code']))
                                                        <tr>
                                                            <td>Group Code</td>
                                                            <td>{{ $productDetails['group_code'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['keywords']))
                                                        <tr>
                                                            <td>Keywords</td>
                                                            <td>{{ $productDetails['keywords'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['fabric']))
                                                        <tr>
                                                            <td>Fabric</td>
                                                            <td>{{ $productDetails['fabric'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['sleeve']))
                                                        <tr>
                                                            <td>Sleeve</td>
                                                            <td>{{ $productDetails['sleeve'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['fit']))
                                                        <tr>
                                                            <td>Fit</td>
                                                            <td>{{ $productDetails['fit'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['occasion']))
                                                        <tr>
                                                            <td>Occasion</td>
                                                            <td>{{ $productDetails['occasion'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['pattern']))
                                                        <tr>
                                                            <td>Pattern</td>
                                                            <td>{{ $productDetails['pattern'] }}</td>
                                                        </tr>
                                                    @endif

                                                    @if (isset($productDetails['wash_care']))
                                                        <tr>
                                                            <td>Wash Care</td>
                                                            <td>{{ $productDetails['wash_care'] }}</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4 category-product" data-category="video">
                                    <h6>Video</h6>
                                    @if (isset($productDetails['product_video']) && !empty($productDetails['product_video']))
                                        <video width="400" controls>
                                            <source src="{{ url('admin/videos/' . $productDetails['product_video']) }}"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <p>Product video does not exist or is empty.</p>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-4 category-product" data-category="reviews">
                                    <h6>Reviews</h6>
                                    <p>reviews goes here</p>
                                    <p>reviews goes here</p>
                                    <p>reviews goes here</p>
                                    <p>reviews goes here</p>
                                    <p>reviews goes here</p>
                                    <p>reviews goes here</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <!-- Related Products -->
        <div class="container-fluid text-center"> <!-- Centering the content -->
            <!-- Title -->
            <h2 class="mb-4">Related Products</h2>

            <!-- Product Cards -->
            <div class="row justify-content-center"> <!-- Centering the row -->
                <!-- Sample Product Card -->
                @foreach ($relatedProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-2 mb-4"> <!-- Reduced the column size to make the cards smaller -->
                        <a href="{{ url('product/' . $item['id']) }}">
                            <div class="card" style="height: 100%;">
                                <!-- Product Image -->
                                @if (is_array($item['images']) && count($item['images']) > 0)
                                    @php
                                        $randomImageIndex = array_rand($item['images']); // Get a random index
                                        $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                    @endphp
                                    <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}"
                                        class="card-img-top" alt="Product Image" style="max-width: 100%; height: auto;">
                                @else
                                    <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                                @endif
                                <div class="card-body">
                                    <!-- Brand Name -->
                                    <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}
                                    </p>
                                    <!-- Product Name -->
                                    <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                    <!-- Prices -->
                                    <div class="d-flex justify-content-between">
                                        @if ($item['product_discount'] > 0)
                                            <p class="card-text category-new-price">
                                                New Price: {{ $item['final_price'] }}
                                                ({{ $item['product_discount'] }}%
                                                off)
                                            </p>
                                            <p class="card-text text-muted category-old-price">
                                                Old Price: <span
                                                    style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                                <span class="badge badge-danger">{{ $item['product_discount'] }}%
                                                    off</span>
                                            </p>
                                        @else
                                            <p class="card-text category-new-price">Price:
                                                {{ $item['product_price'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <hr>

            <!-- Title -->
            <h2 class="mb-4">Recently viewed Products</h2>

            <!-- Product Cards -->
            <div class="row justify-content-center"> <!-- Centering the row -->
                <!-- Sample Product Card -->
                @foreach ($recentlyViewedProducts as $item)
                    <!-- Product Card Template -->
                    <div class="col-md-2 mb-4"> <!-- Reduced the column size to make the cards smaller -->
                        <a href="{{ url('product/' . $item['id']) }}">
                            <div class="card" style="height: 100%;">
                                <!-- Product Image -->
                                @if (is_array($item['images']) && count($item['images']) > 0)
                                    @php
                                        $randomImageIndex = array_rand($item['images']); // Get a random index
                                        $randomImage = $item['images'][$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                    @endphp
                                    <img src="{{ asset('admin/img/products/medium/' . $randomImage) }}"
                                        class="card-img-top" alt="Product Image" style="max-width: 100%; height: auto;">
                                @else
                                    <img src="{{ asset('admin/img/no-img.png') }}" class="card-img-top" alt="No Image">
                                @endif
                                <div class="card-body">
                                    <!-- Brand Name -->
                                    <p class="card-text text-muted category-brand">{{ $item['brand']['brand_name'] }}
                                    </p>
                                    <!-- Product Name -->
                                    <h5 class="card-title category-product-name">{{ $item['product_name'] }}</h5>
                                    <!-- Prices -->
                                    <div class="d-flex justify-content-between">
                                        @if ($item['product_discount'] > 0)
                                            <p class="card-text category-new-price">
                                                New Price: {{ $item['final_price'] }}
                                                ({{ $item['product_discount'] }}%
                                                off)
                                            </p>
                                            <p class="card-text text-muted category-old-price">
                                                Old Price: <span
                                                    style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
                                                <span class="badge badge-danger">{{ $item['product_discount'] }}%
                                                    off</span>
                                            </p>
                                        @else
                                            <p class="card-text category-new-price">Price:
                                                {{ $item['product_price'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
