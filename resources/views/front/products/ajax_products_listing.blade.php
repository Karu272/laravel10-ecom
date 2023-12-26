@foreach ($categoryProducts as $item)
    <!-- Product 1 -->
    <div class="col-md-6 col-lg-3 mb-4">
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
                            Old Price: <span style="text-decoration: line-through;">{{ $item['product_price'] }}</span>
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
