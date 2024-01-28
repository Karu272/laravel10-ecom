@extends('front.layout.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('front.users.account-sidebar')
            <section class="vh-100 col-md-9 mx-auto" style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <br>
                <div class="container h-100">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-4">My billing/Contact address</h3>
                                <p class="mb-4">To make sure you recive your order please make sure to fill in all details
                                    correctly</p>
                                <p class="account-success" id="account-success"></p>
                                <form name="accountForm" id="accountForm" action="javascript:;" method="POST">@csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Type name" value="{{ Auth::user()->name }}">
                                            <p id="account-name"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Type address" value="{{ Auth::user()->address }}">
                                            <p id="account-address"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Type City" value="{{ Auth::user()->city }}">
                                            <p id="account-city"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="state">state</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                placeholder="Type state" value="{{ Auth::user()->state }}">
                                            <p id="account-state"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                placeholder="Type country" value="{{ Auth::user()->country }}">
                                            <p id="account-country"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="zip">Zip Code</label>
                                            <input type="text" class="form-control" id="zip" name="zip"
                                                placeholder="Type zip code" value="{{ Auth::user()->zip }}">
                                            <p id="account-zip"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="phone">Mobile number</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Type mobile number" value="{{ Auth::user()->phone }}">
                                            <p id="account-phone"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Type mobile number" value="{{ Auth::user()->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
