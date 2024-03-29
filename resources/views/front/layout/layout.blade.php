<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- costume CSS -->
    <link rel="stylesheet" href="{{ url('front/css/front.css') }}">
    <title>Your E-Commerce Website</title>
</head>

<body>
    <div class="loader">
        <img src="{{ asset('admin/img/loader.gif') }}" alt="loading...">
    </div>
    @include('front.layout.header')
    <hr>
    <!-- Side Menu and Product Cards -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Product Cards -->
            @yield('content')
        </div>
    </div>
    <!-- Footer -->
    @include('front.layout.footer')

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Costume js -->
    <script src="{{ url('front/js/front.js') }}"></script>
    <script src="{{ url('front/js/filters.js') }}"></script>
    <!-- // Costum js -->
</body>

</html>
