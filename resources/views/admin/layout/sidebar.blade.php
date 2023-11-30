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
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Settings
                        <i class="fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @if (Session::get('page') == 'update-password')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('admin/update-password') }}" class="nav-link">
                            <p><i class="nav-icon fas fa-users"></i> Update Admin Password</p>
                        </a>
                    </li>
                    @if (Session::get('page') == 'update-admin-details')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('admin/update-admin-details') }}" class="nav-link">
                            <p><i class="nav-icon fas fa-users"></i> Update Admin Details</p>
                        </a>
                    </li>
                    @if (Session::get('page') == 'subadmins')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
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
                    @if (Session::get('page') == 'cms-pages')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('admin/pages/cms-pages') }}" class="nav-link">
                            <p><i class="far fa-circle nav-icon"></i> CMS info</p>
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
                    @if (Session::get('page') == 'categories')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('admin/categories/categories') }}" class="nav-link">
                            <p><i class="far fa-circle nav-icon"></i> Categories </p>
                        </a>
                    </li>
                    @if (Session::get('page') == 'products')
                        @php $active="active" @endphp
                    @else
                        @php $active="" @endphp
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('admin/products/products') }}" class="nav-link">
                            <p><i class="far fa-circle nav-icon"></i> Products </p>
                        </a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</div>
