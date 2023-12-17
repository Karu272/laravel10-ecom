<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Your Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Login</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach ($categories as $category)
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                {{ $category['category_name'] }}
                            </a>
                            @if (isset($category['subcategories']) && count($category['subcategories']) > 0)
                                <ul class="dropdown-menu">
                                    @foreach ($category['subcategories'] as $subcategory)
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                {{ $subcategory['category_name'] }}
                                            </a>
                                            @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                                <ul class="dropdown-menu">
                                                    @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                {{ $subsubcategory['category_name'] }}
                                                            </a>
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
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
        </ul>
    </div>
</nav>

<!-- banner -->
<div class="pogoSlider" id="js-main-slider">
    @if (!empty($homeSliderBanner))
        @foreach ($homeSliderBanner as $sliderBanner)
            <div class="pogoSlider-slide" data-transition="verticalSlide" data-duration="2000"
                style="background-image:url({{ asset('admin/img/banners/' . $sliderBanner['image']) }});"
                alt="{{ $sliderBanner['alt'] }}">
                <div class="pogoSlider-slide-element">
                    <div class="container">
                        <h3 class="text-black"> {{ $sliderBanner['title'] }} </h3>
                        <!--<p class="font-italic text-uppercase">Sub title 1</p>-->
                        <a class="bubbly-button" href="{{ $sliderBanner['link'] }}">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <!-- Display a default image when there are no banners -->
        <div class="pogoSlider-slide" data-transition="verticalSlide" data-duration="2000"
            style="background-image:url({{ asset('admin/img/no-img.png') }});" alt="noImage">
            <div class="pogoSlider-slide-element">
                <div class="container">
                    <h3 class="text-vlack">No image was found</h3>
                    <p class="font-italic text-uppercase">No image was found</p>
                    <a class="bubbly-button" href="#">View</a>
                </div>
            </div>
        </div>
    @endif
</div>
<!-- //banner -->

</div>
