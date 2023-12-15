<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-transparent">
    <a class="navbar-brand" href="#">Your Logo</a>
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">///</span>
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Category 1</a>
                    <a class="dropdown-item" href="#">Category 2</a>
                    <a class="dropdown-item" href="#">Category 3</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
        </ul>
    </div>
</nav>

<!-- banner -->
<div class="pogoSlider" id="js-main-slider">
    <div class="pogoSlider-slide" data-transition="verticalSlide" data-duration="2000" style="background-image:url({{asset('front/banner1.jpg')}});">
        <div class="pogoSlider-slide-element">
            <div class="container">
                <h3 class="text-white">Title 1</h3>
                <p class="font-italic text-uppercase">Sub title 1</p>
                <a class="bubbly-button" href="#">View</a>
            </div>
        </div>
    </div>
    <div class="pogoSlider-slide" data-transition="verticalSlide" data-duration="2000" style="background-image:url({{asset('front/banner2.jpg')}});">
        <div class="pogoSlider-slide-element">
            <div class="container">
                <h3 class="text-white">Title 2</h3>
                <p class="font-italic text-uppercase">Sub title 2</p>
                <a class="bubbly-button" href="#">View</a>
            </div>
        </div>
    </div>
    <div class="pogoSlider-slide" data-transition="verticalSlide" data-duration="2000" style="background-image:url({{asset('front/banner3.jpg')}});">
        <div class="pogoSlider-slide-element">
            <div class="container">
                <h3 class="text-white">Title 3</h3>
                <p class="font-italic text-uppercase">Sub title 3</p>
                <a class="bubbly-button" href="#">View</a>
            </div>
        </div>
    </div>
</div>
<!-- //banner -->

</div>
