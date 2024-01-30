<nav class="mt-4" aria-label="breadcrumb">
    <ol style="background-color: white;" class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <p>&nbsp;&rarr;Cart</p>
    </ol>
</nav>
<div class="container-fluid text-center">
    <div class="card-header">
        <h3>Cart</h3>
    </div>
    <br>
    <div class="row justify-content-center">
        @php
            $total_price = 0;
        @endphp
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
                                <a href="{{ url('product/' . $item['product']['id']) }} ">
                                    <img src="{{ asset('admin/img/products/small/' . $randomImage) }}"
                                        alt="product image" class="img-fluid" style="width: 50%">
                                </a>
                            @else
                                <img src="{{ asset('admin/img/no-img.png') }}" class="img-fluid" alt="No Image"
                                    style="width: 50%">
                            @endif
                            <div class="">
                                <h4><a
                                        href="{{ url('product/' . $item['product']['id']) }}">{{ $item['product']['product_name'] }}</a>
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
                                <p class="minusBtn updateCartItem qtyMinus" data-cartid="{{ $item['id'] }}"
                                    data-qty="{{ $item['product_qty'] }}">-</p>
                                <input name="qty" value="{{ $item['product_qty'] }}" data-min="1" data-max="100"
                                    class="quantity text-center">
                                <p class="plusBtn updateCartItem qtyPlus" data-cartid="{{ $item['id'] }}"
                                    data-qty="{{ $item['product_qty'] }}">+</p>
                            </div>
                            <br>
                            <a title="Delete Item" href="#" class="deleteCartItem"
                                data-cartid="{{ $item['id'] }}"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $total_price = $total_price + $item['product']['final_price'] * $item['product_qty'];
            @endphp
        @endforeach
    </div>
    <br>
    <div class="card-header text-right">
        <span>
            <a href="javascript:;" style="background-color: white" class="btn border p-3 emptyCart">Clear Cart</a>
        </span>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="card">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>SUBTOTAL</td>
                        <td>Kr.{{ $total_price }}</td>
                    </tr>
                    <tr>
                        <td>COUPON DISCOUNT</td>
                        <td><span class="couponAmount">
                            @if(Session::has('couponAmount'))
                            Kr.{{ Session::get('couponAmount') }}
                            @else
                            Kr.0
                            @endif
                        </span></td>
                    </tr>
                    <tr>
                        <th> GRAND TOTAL</th>
                        <td><strong style="color: orange;" class="grand_total">Kr.{{ max($total_price - Session::get('couponAmount'), 0) }}</strong></td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td><button type="submit" class="btn btn-success"> PROCEED TO CHECKOUT</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>
