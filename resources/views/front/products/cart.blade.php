@extends('front.layout.layout')
@section('content')
    <br>
    <div style="background-color: rgb(252, 243, 255);" class="col-md-10 mx-auto">
        <br>
        <div class="container-fluid text-center">
            <div class="card-header text-center">
                <h3>Cart</h3>
            </div>
            <br>
            <div class="row justify-content-center">
                @foreach ($getCartItems as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body border">
                                <div class="">
                                    <!-- Product Image -->
                                    @php
                                        $images = $item['product']['images'];
                                        $randomImage = null;

                                        if (!empty($images)) {
                                            $randomImageIndex = array_rand($images); // Get a random index
                                            $randomImage = $images[$randomImageIndex]['image']; // Use the 'image' key from the nested array
                                        }
                                    @endphp
                                    @if ($randomImage)
                                        <a href="{{ url('product/' . $item['id']) }} ">
                                            <img src="{{ asset('admin/img/products/small/' . $randomImage) }}"
                                                alt="product image" class="img-fluid" style="width: 50%">
                                        </a>
                                    @else
                                        <img src="{{ asset('admin/img/no-img.png') }}" class="img-fluid" alt="No Image"
                                            style="width: 50%">
                                    @endif
                                    <div class="">
                                        <h4><a
                                                href="{{ url('product/' . $item['id']) }}">{{ $item['product']['product_name'] }}</a>
                                        </h4>
                                        <p>{{ $item['product']['brand']['brand_name'] }}</p>
                                        <p>Size: {{ $item['product_size'] }}</p>
                                        <p>Color: {{ $item['product']['product_color'] }}</p>
                                    </div>
                                    <div>
                                        <h4 style="color: orange; display: inline-block; margin-right: 10px;">
                                            {{ $item['product']['final_price'] * $item['product_qty'] }}Kr</h4>
                                        @if (isset($item['product']['product_discount']) && $item['product']['product_discount'] > 0)
                                            <span style="display: inline-block; margin-right: 10px;">
                                                <p style="color: orange; margin: 0;">
                                                    {{ $item['product']['product_discount'] }}% off</p>
                                            </span>
                                            <span style="display: inline-block;">
                                                <p style="text-decoration: line-through; margin: 0;">
                                                    {{ $item['product']['product_price'] }}</p>
                                            </span>
                                        @endif
                                    </div>
                                    <br>
                                    <div class="">
                                        <p class="minusBtn">-</p>
                                        <input name="qty" value="{{ $item['product_qty'] }}" data-min="1"
                                            data-max="100" class="quantity text-center ">
                                        <p class="plusBtn">+</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <div class="card-header text-right">
                <span>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                    <a href="#" class="btn btn-danger">Clear Cart</a>
                </span>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="card">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Apply Coupon Code</th>
                                <td>SUBTOTAL</td>
                                <td>2700</td>
                            </tr>
                            <tr>
                                <td>Enter Coupon Code to avail Discount</td>
                                <td>COUPON DISCOUNT</td>
                                <td>cd 0kr</td>
                            </tr>
                            <tr>
                                <td><input type="text" style="border: 1px solid black; background: rgb(228, 228, 228);"
                                        placeholder="Enter Coupon Code">
                                </td>
                                <th> GRAND TOTAL</th>
                                <td>2700KR</td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-primary">Apply</button></td>
                                <td>-</td>
                                <td><button class="btn btn-success"> PROCEED TO CHECKOUT</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
        </div>
    </div>
@endsection
