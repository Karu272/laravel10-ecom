@extends('front.layout.layout')
@section('content')
    <br>
    <div class="col-md-9" style="background-color: aliceblue">
        <div class="row">
            @if (isset($homeFixedBanner[0]['image']))
                <!-- Banner 1 -->
                <div class="col-md-6 mb-4">
                    <br>
                    <div class="card banner-card">
                        <a href="{{ $homeFixedBanner[0]['link'] }}" title="{{ $homeFixedBanner[0]['title'] }}">
                            <img src="{{ asset('admin/img/banners/'. $homeFixedBanner[0]['image']) }}" class="card-img banner-img" alt="{{ $homeFixedBanner[0]['alt'] }}">
                        </a>
                    </div>
                </div>
            @endif
            @if (isset($homeFixedBanner[1]['image']))
                <!-- Banner 2 -->
                <div class="col-md-6 mb-4">
                    <br>
                    <div class="card banner-card">
                        <a href="{{ $homeFixedBanner[1]['link'] }}" title="{{ $homeFixedBanner[1]['title'] }}">
                            <img src="{{ asset('admin/img/banners/'. $homeFixedBanner[1]['image']) }}" class="card-img banner-img" alt="{{ $homeFixedBanner[1]['alt'] }}">
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
