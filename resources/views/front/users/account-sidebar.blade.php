 <!-- Sidebar -->
 <div class="col-md-2 bg-light">
     <nav class="nav flex-column" style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
         <h2 style="text-align: center; cursor: pointer;" class="ml-sm-0"> Hello, {{ Auth::user()->name }} </h2>
         <hr>
         <a class="nav-link" href="#billing">My Billing/Contact Address</a>
         <a class="nav-link" href="#orders">My Orders</a>
         <a class="nav-link" href="#wishlist">My Wish List</a>
         <a class="nav-link" href="#password">Update Password</a>
     </nav>
 </div>
