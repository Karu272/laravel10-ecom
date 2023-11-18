<div class="container">
    <div class="row">
        <div class="col-6 col-md-4">
            <h3>Welcome
                {{ Auth::guard('admin')->user()->name }} ||
                {{ Auth::guard('admin')->user()->type }}
            </h3>
        </div>
        <div class="col-6 col-md-6 marTop">
            <li><a href="{{ URL('admin/dashboard') }}">Dashboard</a></li>
        </div>
        <div class="col-4 col-md-2 marTop">
            <li><a href="{{ URL('admin/logout') }}">Logout</a></li>
        </div>
    </div>
</div>
