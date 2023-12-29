@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-9">
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
            </nav>
        </div>
        <div class="row" id="appendProducts">
            @include('front.products.ajax_products_listing')
        </div>
    </div>
@endsection
