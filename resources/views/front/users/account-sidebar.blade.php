 <!-- Sidebar -->
 <div class="col-md-2 bg-light">
     <br>
     <div class="col-md-12 text-center mb-3">
         <img class="img-fluid" style="width: 45%;" src="{{ asset('front/img/logos/logo1.png') }}" alt="logo">
     </div>
     <nav class="nav flex-column" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
         <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"> Hello, {{ Auth::user()->name }} </h2>
         <hr>
         <br>
         <a class="nav-link" href="{{ url('/account') }}">My Billing/Contact Address</a>
         <a class="nav-link" href="#orders">My Orders</a>
         <a class="nav-link" href="#wishlist">My Wish List</a>
         <a class="nav-link" href="{{ url('/update-password') }}">Update Password</a>
         <br>
     <br>
     </nav>
 </div>
