<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- costume CSS -->
    <link rel="stylesheet" href="{{ url('front/css/front.css') }}">
    <link rel="stylesheet" href="{{ url('front/css/pogo-slider.min.css') }}" type="text/css" media="all" />
    <style>
        /* Add your custom styles here */
        /* Adjust styles for responsiveness as needed */
    </style>
    <title>Your E-Commerce Website</title>
</head>

<body>
    @include('front.layout.header')
    <hr>
    <!-- Side Menu and Product Cards -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Side Menu (Hidden on Mobile) -->
            @include('front.layout.sidebar')
            <!-- Product Cards -->
            @yield('content')
        </div>
    </div>
    @include('front.layout.footer')
    <!-- Footer -->

    <!-- Bootstrap JS and jQuery (required for Bootstrap) full version neeed for pogoslider -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Pogo slider (for banner) -->
    <script src="{{ url('front/js/pogo-slider.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#js-main-slider').pogoSlider({
                /* PogoSlider options go here */
                autoplay: true,
                autoplayTimeout: 5000,
                displayProgess: true,
            });
        });
    </script>
    <!-- Pogo slider (for banner) -->
    <!-- Costume js -->
    <script src="{{ url('front/js/front.js') }}"></script>
    <!-- // Costum js -->
</body>

</html>
