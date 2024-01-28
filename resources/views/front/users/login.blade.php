@extends('front.layout.layout')
@section('content')
    <br>
    <section class="vh-100 col-md-10 mx-auto" style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    @if (Session::has('success_message'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('success_message') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>
                                    <form class="mx-1 mx-md-4" id="loginForm" action="javascript:;" method="POST">@csrf
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="email">Your Email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    @if (isset($_COOKIE['user-email'])) value="{{ $_COOKIE['user-email'] }}" @endif />
                                            </div>
                                        </div>
                                        <p id="login-email"></p>
                                        <p id="login-error"></p>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control"
                                                    @if (isset($_COOKIE['user-password'])) value="{{ $_COOKIE['user-password'] }}" @endif />
                                            </div>
                                        </div>
                                        <p id="login-password"></p>
                                        <div class="mb-3 ml-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-me"
                                                    name="remember-me"
                                                    @if (isset($_COOKIE['user-password'])) checked="" @endif />
                                                <label class="form-check-label" for="remember-me">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="submit"
                                                class="btn btn-primary btn-lg">Login</button>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-4">
                                            <a href="{{ url('/register') }}">Back to Register</a>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center mt-4">
                                            <a style="color: lightgray" href="{{ url('/forgotpwd') }}">Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                        class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
@endsection
