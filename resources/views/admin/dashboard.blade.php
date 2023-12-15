@extends('admin.layout.layout')
@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                @if (Session::has('error_message'))
                    <div class="redDanger alert alert-danger" role="alert">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="col-sm-12">
                    <h1>Dashboard</h1>
                    <br>
                </div>
                <div class="col-sm-3 dashBgBox">
                    <span><i class="fas fa-thumb-tack  nav-icon"></i>&nbsp;&nbsp;<a href="{{ route('admin.categories.categories')}}"> Categories</a></span>
                    <span>&nbsp;&nbsp;{{ $categoriesCount }}</span>
                </div>
                <div class="col-sm-3 dashBgBox">
                    <span><i class="fas fa-truck  nav-icon"></i>&nbsp;&nbsp;<a href="{{ route('admin.products.products')}}"> Products</a></span>
                    <span>&nbsp;&nbsp;{{ $producsCount }}</span>
                </div>
                <div class="col-sm-3 dashBgBox">
                    <span><i class="fas fa-female nav-icon"></i>&nbsp;&nbsp;<a href="{{ route('admin.brands.brands')}}"> Brands</a></span>
                    <span>&nbsp;&nbsp;{{ $brandsCount }}</span>
                </div>
                <div class="col-sm-3 dashBgBox">
                    <span><i class="nav-icon fas fa-users"></i>&nbsp;&nbsp;<a href="{{ route('subadmins.subadmins')}}"> Users</span>
                    <span>&nbsp;&nbsp;{{ $usersCount }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
