@if (!request()->is('/') && !request()->is(url('/')))
    <br>
    <div class="col-md-3 d-none d-md-block">
        <br>
        <div class="col-md-12 text-center mb-3">
            <img class="img-fluid" style="width: 45%;" src="{{ asset('front/img/logos/logo1.png') }}" alt="logo">
        </div>
        <div class="container-fluid">
            <div style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center;" class="ml-sm-0">Categories</h2>
                <hr>
                <!-- Add your side menu content here -->
                <div class="row mb-5 ml-sm-0">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link mb-1 boldtxt" data-toggle="collapse"
                                        href="#{{ strtolower(str_replace(' ', '', $category['category_name'])) }}"
                                        aria-expanded="false">
                                        <h5>&hearts;&nbsp;{{ $category['category_name'] }}</h5>
                                    </a>
                                    <div class="collapse"
                                        id="{{ strtolower(str_replace(' ', '', $category['category_name'])) }}">
                                        @if (isset($category['subcategories']) && count($category['subcategories']) > 0)
                                            <ul class="nav flex-column ml-3">
                                                @foreach ($category['subcategories'] as $subcategory)
                                                    <li class="nav-item">
                                                        <a class="nav-link mb-1" data-toggle="collapse"
                                                            href="#{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}"
                                                            aria-expanded="false">
                                                            <h6>&nbsp;&rarr;{{ $subcategory['category_name'] }}</h6>
                                                        </a>
                                                        <div class="collapse"
                                                            id="{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}">
                                                            @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                                                <ul class="nav flex-column ml-3">
                                                                    @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link mb-1"
                                                                                href="{{ $subsubcategory['url'] }}">
                                                                                <h6>&nbsp;&rarr;{{ $subsubcategory['category_name'] }}
                                                                                </h6>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <script>
                function toggleCollapse(collapseId, iconId, contentId) {
                    var iconElement = document.getElementById(iconId);
                    var contentElement = document.getElementById(contentId);

                    // Check if the content is visible or not
                    var isContentVisible = contentElement.style.display === "block" || contentElement.style.display === "";

                    if (isContentVisible) {
                        contentElement.style.display = "none";
                        iconElement.innerHTML = "&#8595;"; // Down arrow
                    } else {
                        contentElement.style.display = "block";
                        iconElement.innerHTML = "&#8593;"; // Up arrow
                    }
                }
            </script>
            <!-- Color Section -->
            <div id="collapsible-color" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"
                    onclick="toggleCollapse('collapsible-color', 'collapse-color-icon', 'content-color')">
                    Color<span id="collapse-color-icon" class="float-right">&#8593;</span>
                </h2>
                <hr>
                <div class="row mb-5 ml-sm-0" id="content-color">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($colors as $key => $color)
                                <li class="d-flex align-items-center">
                                    <input type="checkbox" id="color{{ $key }}" name="color"
                                        value="{{ $color }}" class="filterAjax">
                                    <label
                                        style="background-color: {{ $color }}; width: 20px; height: 20px; border: 1px solid #000;"
                                        for="color{{ $key }}" title="{{ $color }}"
                                        class="ml-2"></label>&nbsp;&nbsp;{{ $color }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>

            <!-- Sizes Section -->
            <div id="collapsible-size" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"
                    onclick="toggleCollapse('collapsible-size', 'collapse-size-icon', 'content-size')">
                    Sizes<span id="collapse-size-icon" class="float-right">&#8593;</span>
                </h2>
                <hr>
                <div class="row mb-5 ml-sm-0" id="content-size">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($sizes as $key => $size)
                                <?php
                                if (isset($_GET['size']) && !empty($_GET['size'])) {
                                    $sizes = explode('~', $_GET['size']);
                                    if (!empty($sizes) && in_array($size, $sizes)) {
                                        $sizecheck = 'checked';
                                    } else {
                                        $sizecheck = '';
                                    }
                                } else {
                                    $sizecheck = '';
                                }
                                ?>
                                <li class="d-flex align-items-center">
                                    <input type="checkbox" id="size{{ $key }}" name="size"
                                        value="{{ $size }}" class="filterAjax" {{ $sizecheck }}>
                                    <label for="size{{ $key }}" title="{{ $size }}"
                                        class="ml-2"></label>&nbsp;&nbsp;{{ $size }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <!-- Brands Section -->
            <div id="collapsible-brands" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"
                    onclick="toggleCollapse('collapsible-brands', 'collapse-brands-icon', 'content-brands')">
                    Brands<span id="collapse-brands-icon" class="float-right">&#8593;</span>
                </h2>
                <hr>
                <div class="row mb-5 ml-sm-0" id="content-brands">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($brands as $key => $brand)
                                <?php
                                if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                                    $brands = explode('~', $_GET['brand']);
                                    if (!empty($brands) && in_array($brand, $brands)) {
                                        $brandcheck = 'checked';
                                    } else {
                                        $brandcheck = '';
                                    }
                                } else {
                                    $brandcheck = '';
                                }
                                ?>
                                <li class="d-flex align-items-center">
                                    <input type="checkbox" id="brand{{ $key }}" name="brand"
                                        value="{{ $brand['id'] }}" class="filterAjax" {{ $brandcheck }}>
                                    <label for="brand{{ $key }}"
                                        class="ml-2"></label>&nbsp;&nbsp;{{ $brand['brand_name'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>

            <!-- Prices Section -->
            <div id="collapsible-prices" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"
                    onclick="toggleCollapse('collapsible-prices', 'collapse-prices-icon', 'content-prices')">
                    Prices<span id="collapse-prices-icon" class="float-right">&#8593;</span>
                </h2>
                <hr>
                <div class="row mb-5 ml-sm-0" id="content-prices">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($prices as $key => $price)
                                <?php
                                if (isset($_GET['price']) && !empty($_GET['price'])) {
                                    $prices = explode('~', $_GET['price']);
                                    if (!empty($prices) && in_array($price, $prices)) {
                                        $pricecheck = 'checked';
                                    } else {
                                        $pricecheck = '';
                                    }
                                } else {
                                    $pricecheck = '';
                                }
                                ?>
                                <li class="d-flex align-items-center">
                                    <input type="checkbox" id="price{{ $key }}" name="price"
                                        value="{{ $price }}" class="filterAjax" {{ $pricecheck }}>
                                    <label for="price{{ $key }}"
                                        class="ml-2"></label>&nbsp;&nbsp;{{ $price }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <br>

            <!-- Dynamic Filters Section -->
            @foreach ($dynamicFilters as $key => $filter)
                <div id="collapsible-{{ strtolower($filter) }}"
                    style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                    <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"
                        onclick="toggleCollapse('collapsible-{{ strtolower($filter) }}', 'collapse-{{ strtolower($filter) }}-icon', 'content-{{ strtolower($filter) }}')">
                        {{ ucwords($filter) }}<span id="collapse-{{ strtolower($filter) }}-icon"
                            class="float-right">&#8593;</span>
                    </h2>
                    <hr>
                    <div class="row mb-5 ml-sm-0" id="content-{{ strtolower($filter) }}">
                        <div class="col-md-12">
                            <ul class="nav flex-column">
                                @foreach ($dynamicFilterValues[$filter] as $fkey => $value)
                                    @php $checkFilter = "" @endphp
                                    @if (isset($_GET[$filter]) && !empty($_GET[$filter]))
                                        @php $explodeFilters = explode('~', $_GET[$filter]) @endphp
                                        @if (in_array($value, $explodeFilters))
                                            @php $checkFilter = "checked"; @endphp
                                        @endif
                                    @endif
                                    <li class="d-flex align-items-center">
                                        <input type="checkbox" id="filter{{ $fkey }}"
                                            name="{{ $filter }}" value="{{ $value }}"
                                            class="filterAjax" {{ $checkFilter }}>
                                        <label class="ml-2"
                                            for="filter{{ $fkey }}"></label>&nbsp;&nbsp;{{ $value }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach

        </div>
    </div>
@endif

@if (request()->is('/'))
    <br>
    <div class="col-md-3 d-none d-md-block">
        <br>
        <div class="col-md-12 text-center mb-3">
            <img class="img-fluid" style="width: 45%;" src="{{ asset('front/img/logos/logo1.png') }}"
                alt="logo">
        </div>
        <div class="container-fluid">
            <!-- Add your content here -->
            <img class="img-fluid" style="width: 100%;" src="{{ asset('front/img/logos/69.jpg') }}"
                alt="largerlogo">
        </div>
    </div>
@endif
