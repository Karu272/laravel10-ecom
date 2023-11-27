<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... --->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- cropp addons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <!-- //cropp addons -->
    <link rel="stylesheet" type="text/css"
        href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link href="{{ asset('admin/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <!-- //for-mobile-apps -->
    <link href="{{ url('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- js -->
    <script src="{{ url('admin/js/jquery.min.js') }}"></script>
    <!-- //js -->
    <!-- for bootstrap working -->
    <script type="text/javascript" src="{{ url('admin/js/bootstrap-3.1.1.min.js') }}"></script>
    <!-- //for bootstrap working -->
    <link rel="stylesheet" href="{{ Url('admin/css/admin.css') }}">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
</head>

<body>
    @include('admin.layout.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                @include('admin.layout.sidebar')
            </div>

            @yield('content')
        </div>
    </div>
    <div class="container">
        @include('admin.layout.footer')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Cropper.js -->
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    <!-- Custom Admin JS -->
    <script src="{{ url('admin/js/Jquery.js') }}" type="text/javascript"></script>
    <script src="{{ url('admin/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ url('admin/js/Jquery.map.js') }}" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script>
        (function($) {
            $(document).ready(function() {
                $("#example").dataTable();
            });
        })(jQuery);
    </script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ url('admin/js/admin_script.js') }}" type="text/javascript"></script>
</body>

</html>
