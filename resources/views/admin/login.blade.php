<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <link rel="stylesheet" href="{{ Url('admin/css/login.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates&display=swap" rel="stylesheet">
    <title>Admin Login</title>
</head>

<body>
    <div class="container">
        <form action="{{ URL('/admin/login') }}" method="post">@csrf
            <div class="box1">
                <h3>Admin Login</h3>
                @if ($errors->any())
                    <div class="alert alert-danger loginalert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="redDanger alert alert-danger" role="alert">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="box2">
                <label for="title">E-mail</label>
            </div>
            <div class="box3">
                <input class="email" type="email" name="email" id="email" placeholder="E-mail"
                    @if (isset($_COOKIE['email'])) value="{{ $_COOKIE['email'] }}" @endif>
            </div>
            <div class="box4">
                <label for="title2">Password</label>
            </div>
            <div class="box5">
                <input class="password" type="password" name="password" id="password" placeholder="Password"
                    @if (isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endif>
            </div>
            <div class="box5">
                <input type="checkbox" id="remember" name="remember" @if (isset($_COOKIE['password'])) checked="" @endif>
                <label for="remember">
                    Remember Me
                </label>
            </div>
            <div class="box6">
                <button class="btn" type="submit">Login</button>
            </div>
        </form>
    </div>
</body>

</html>
