@extends('front.layout.layout')
@section('content')
<br>
<div class="col-md-9">
    <div class="row">
      <!-- Product 1 -->
      <div class="col-md-6 col-lg-3 mb-4">
        <br>
        <div class="card">
          <img src="{{ asset('front/40dd.jpg') }}" class="card-img-top" alt="Product 1">
          <div class="card-body">
            <h5 class="card-title">Product 1</h5>
            <p class="card-text">Description of Product 1.</p>
            <p class="card-text">$19.99</p>
          </div>
        </div>
      </div>

      <!-- Add more product cards as needed -->

    </div>
  </div>
  @endsection