<!-- Top Navigation Bar -->
<nav id="mynavbar">
    <ul id="mynavbar-menu">
        <a href="{{ url('/') }}"><img style="width: 20%;" src="{{ asset('front/img/logos/toplogo.png') }}"
                alt="toplogo"></a>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="has-children">
            <a href="#" aria-haspopup="true">Categories</a>
            <ul aria-label="submenu">
                @foreach ($categories as $category)
                    <li class="has-children">
                        <a href="{{ $category['url'] }}" aria-haspopup="true">{{ $category['category_name'] }}</a>
                        @if (isset($category['subcategories']) && count($category['subcategories']) > 0)
                            <ul aria-label="submenu">
                                @foreach ($category['subcategories'] as $subcategory)
                                    <li class="has-children">
                                        <a href="{{ $subcategory['url'] }}"
                                            aria-haspopup="true">{{ $subcategory['category_name'] }}</a>
                                        @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                            <ul aria-label="submenu">
                                                @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                    <li><a
                                                            href="{{ $subsubcategory['url'] }}">{{ $subsubcategory['category_name'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>
        <li><a href="#!">Login</a></li>
        <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
    </ul>
</nav>
<!-- Mobile Navbar-->
<nav id="myMobileNavbar" class="navbar navbar-light light-blue lighten-4">
    <!-- Flex container for brand and toggle button -->
    <div class="d-flex justify-content-between w-100">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ url('/') }}"><img style="width: 20%;"
                src="{{ asset('front/img/logos/toplogo.png') }}" alt="toplogo"></a>
        <!-- Collapse button -->
        <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false"
            aria-label="Toggle navigation"><span class="dark-blue-text"><i
                    class="fas fa-bars fa-1x"></i></span></button>
    </div>
    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent1">
        <!-- Links -->
        <ul class="navbar-nav">
            @foreach ($categories as $category)
                <li class="align-self-center nav-item">
                    <a class="nav-link mb-1 boldtxt" data-toggle="collapse"
                        href="#{{ strtolower(str_replace(' ', '', $category['category_name'])) }}"
                        aria-expanded="false">
                        &hearts;&nbsp;{{ $category['category_name'] }}
                    </a>
                    <div class="collapse" id="{{ strtolower(str_replace(' ', '', $category['category_name'])) }}">
                        @if (isset($category['subcategories']) && count($category['subcategories']) > 0)
                            <ul class="nav flex-column ml-3">
                                @foreach ($category['subcategories'] as $subcategory)
                                    <li class="nav-item">
                                        <a class="nav-link mb-1" data-toggle="collapse"
                                            href="#{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}"
                                            aria-expanded="false">
                                            &nbsp;&rarr;{{ $subcategory['category_name'] }}
                                        </a>
                                        <div class="collapse"
                                            id="{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}">
                                            @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                                <ul class="nav flex-column ml-3">
                                                    @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                        <li class="nav-item">
                                                            <a class="nav-link mb-1"
                                                                href="{{ $subsubcategory['url'] }}">
                                                                &nbsp;&rarr;{{ $subsubcategory['category_name'] }}
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
        <!-- // Links -->
    </div>
    <!-- Collapsible content -->
</nav>
<!--/.Mobile Navbar-->

<!-- Bootstrap Carousel -->
@if (!empty($homeSliderBanner) && count($homeSliderBanner) > 0)
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            @foreach ($homeSliderBanner as $key => $sliderBanner)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ asset('admin/img/banners/' . $sliderBanner['image']) }}"
                        alt="First slide">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@else
    <!-- Handle case when $homeSliderBanner is empty -->
    <p>No banners found</p>
@endif
<!-- //banner -->
