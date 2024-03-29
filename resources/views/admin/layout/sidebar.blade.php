<div class="col-md-2">
    <div class="card">
        <div class="card-body">
            <div class="img">
                @if (!empty(Auth::guard('admin')->user()->image))
                    <img src="{{ asset('admin/img/' . Auth::guard('admin')->user()->image) }}" alt="UserImage"
                        class="img-circle imgSetup">
                @else
                    <img src="{{ asset('admin/img/no-img.png') }}" alt="UserImage" class="img-circle imgSetup">
                @endif
            </div>
            <div class="userProfileBox-Name">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle nob" data-toggle="dropdown">
                    <p class="fq">
                        <i class="nav-icon fas fa-cogs"></i>
                        Settings
                        <i class="fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <!-- must be put inside a <a></a>
                    @if (Session::get('page') == 'update-password')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif -->
                    <li class="nav-item">
                        <a href="{{ url('admin/update-password') }}" class="nav-link">
                            <p><i class="nav-icon fas fa-users"></i> Update Admin Password</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/update-admin-details') }}" class="nav-link">
                            <p><i class="nav-icon fas fa-users"></i> Update Admin Details</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/subadmins/subadmins') }}" class="nav-link">
                            <p><i class="nav-icon fas fa-users"></i> Subadmins</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle nob" data-toggle="dropdown">
                    <p class="fq2">
                        <i class="nav-icon fas fa-copy"></i>
                        Cms Pages
                        <i class="fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li class="nav-item">
                        <a href="{{ url('admin/pages/cms-pages') }}" class="nav-link">
                            <p><i class="far fa-newspaper-o nav-icon"></i> CMS info</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle nob" data-toggle="dropdown">
                    <p class="fq2">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        E-com Pages
                        <i class="fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li class="nav-item">
                        <a href="{{ url('admin/categories/categories') }}" class="nav-link">
                            <p><i class="fas fa-thumb-tack  nav-icon"></i> Categories </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/brands/brands') }}" class="nav-link">
                            <p><i class="fas fa-female nav-icon"></i> Brands </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/products/products') }}" class="nav-link">
                            <p><i class="fas fa-truck  nav-icon"></i> Products </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/banners/banners') }}" class="nav-link">
                            <p><i class="fas fa-window-maximize nav-icon"></i> Banners </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/coupons/coupons') }}" class="nav-link">
                            <p><i class="fas fa-window-maximize nav-icon"></i> Coupons </p>
                        </a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</div>
