<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar">
        <div class="mt-3 pb-3 mb-3 d-flex">
            <div class="img">
                @if (!empty(Auth::guard('admin')->user()->image))
                    <img src="{{ asset('admin/img/' . Auth::guard('admin')->user()->image) }}" alt="UserImage"
                        class="img-circle elevation-2">
                @else
                    <img src="{{ asset('admin/img/no-img.png') }}" alt="UserImage"
                        class="img-circle elevation-2">
                @endif
            </div>
            <div class="userProfileBox-Name">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <p>
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
    </ul>
    <ul class="nav nav-pills nav-sidebar">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <p>
                    <i class="nav-icon fas fa-tachometer-alt"></i>
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
    </ul>
</nav>
