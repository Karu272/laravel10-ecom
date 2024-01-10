@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-10 mx-auto">
        <div class="row">
            <!-- Move col-md-4 to the left of col-md-8 -->
            <div class="col-md-4">
                <div class="breadccrums">
                    <a href="">Home</a>
                    <a href="">Category</a>
                    <a href="">SubCategory</a>
                    <a href="">Product</a>
                </div>
                <hr>
                <div class="imgcard">
                    <!-- Center and make largeimg span full width -->
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <img src="{{ asset('admin/img/products/small/1809.jpg') }}" alt=""
                                class="img-fluid largeimg">
                        </div>
                    </div>
                    <hr>
                    <div class="smallerrow row">
                        <!-- Arrange small images horizontally using Bootstrap grid -->
                        <div class="col-md-3">
                            <img src="{{ asset('admin/img/products/small/4917.jpg') }}" alt=""
                                class="img-fluid small1">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('admin/img/products/small/4917.jpg') }}" alt=""
                                class="img-fluid small2">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('admin/img/products/small/4917.jpg') }}" alt=""
                                class="img-fluid small3">
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('admin/img/products/small/4917.jpg') }}" alt=""
                                class="img-fluid small4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="txtcard">
                    <h2>Product Name</h2>
                    <span class="d-flex align-items-end">
                        <h1 class="mb-0" style="color: orange">1000kr</h1>
                        <span class="d-flex align-items-end">&nbsp;&nbsp;&nbsp;
                            <p class="mb-0 mr-3" style="color: orange">(10% off)</p>
                        </span>
                        <span class="d-flex align-items-end">
                            <p class="mb-0 mr-3" style="text-decoration: line-through;">1100kr</p>
                        </span>
                    </span>
                    <br>
                    <span class="d-flex">
                        <p class="mr-3 detail-stock-green">200 in stock</p>
                        <p class="mr-3 detail-stock-orange">Only 2 left</p>
                    </span>
                    <br>
                    <div class="description">
                        <h5>Description:</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod. Quidem, quasi. Ea,</p>
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
                        <p class="mr-3">Blue</p>
                        <p class="mr-3">Green</p>
                        <p class="mr-3">Red</p>
                        <p class="mr-3">Yellow</p>
                        <p class="mr-3">Orange</p>
                    </span>
                    <br>
                    <span class="d-flex">
                        <h6 class="mr-3">Size:&nbsp; </h6>
                        <p class="mr-3 detail-size">S</p>
                        <p class="mr-3 detail-size">M</p>
                        <p class="mr-3 detail-size">L</p>
                    </span>
                    <br>
                    <span class="d-flex">
                        <p class="minusBtn mr-3">-</p>
                        <p class="quantity mr-3">5</p>
                        <p class="plusBtn mr-3">+</p>
                        <button class="mr-3 btn btn-success btn1" type="submit">Add to Cart</button>
                    </span>
                    <br>
                    <div class="policy">
                        <h6>Product Policy:</h6>
                        <p><i class="fas fa-check-circle text-success"></i> Buyer protection.</p>
                        <p><i class="fas fa-check-circle text-success"></i> Full Refund if you don't receive your order.</p>
                        <p><i class="fas fa-check-circle text-success"></i> Returns accapted if product not as described.
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
                                <p>Alalalalaalalal</p>
                            </div>
                            <div class="col-md-3 mb-4 category-product" data-category="video">
                                <h6>Video</h6>
                                <p>video goes here</p>
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
    @endsection
