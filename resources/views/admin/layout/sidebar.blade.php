<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column">
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
                        <p><i class="far fa-circle nav-icon"></i> Update Admin Password</p>
                    </a>
                </li>
                @if (Session::get('page') == 'update-admin-details')
                    @php $active="active" @endphp
                @else
                    @php $active="" @endphp
                @endif
                <li class="nav-item">
                    <a href="{{ url('admin/update-admin-details') }}" class="nav-link">
                        <p><i class="far fa-circle nav-icon"></i> Update Admin Details</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
