@extends('front.layout.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('front.users.account-sidebar')
            <section class="vh-100 col-md-9 mx-auto"
                style="background-color: rgb(252, 243, 255); box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <br>
                <div class="container h-100">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-4">My billing/Contact address</h3>
                                <p class="mb-4">To make sure you recive your order please make sure to fill in all details
                                    correctly</p>
                                <p class="success" id="account-success"></p>
                                <form name="accountForm" id="accountForm" action="javascript:;" method="POST">@csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Type name" value="{{ Auth::user()->name }}" autocomplete="name">
                                            <p id="account-name"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Type address" value="{{ Auth::user()->address }}" autocomplete="address">
                                            <p id="account-address"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Type City" value="{{ Auth::user()->city }}" autocomplete="off">
                                            <p id="account-city"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="state">state</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                placeholder="Type state" value="{{ Auth::user()->state }}" autocomplete="off">
                                            <p id="account-state"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">Country</label>
                                            <select class="form-control" name="country" id="country" required autocomplete="country">
                                                @foreach ($countries as $item)
                                                    <option value="{{ $item['country_name'] }}" @if ($item['country_name'] == Auth::user()->country) selected @endif >{{ $item['country_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <p id="account-country"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="zip">Zip Code</label>
                                            <input type="text" class="form-control" id="zip" name="zip"
                                                placeholder="Type zip code" value="{{ Auth::user()->zip }}" autocomplete="off">
                                            <p id="account-zip"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="phone">Mobile number</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Type mobile number" value="{{ Auth::user()->phone }}" autocomplete="mobile">
                                            <p id="account-phone"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Type mobile number" value="{{ Auth::user()->email }}" readonly autocomplete="email">
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
