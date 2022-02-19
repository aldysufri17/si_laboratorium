<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow bgdark">
    <a class="sidebar-brand d-flex" style=" color:rgb(202, 202, 202)" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-desktop"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Web</div>
    </a>    
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-light small">
                    {{ auth()->user()->name }}
                </span>
                <img class="img-profile rounded-circle"
                    src="{{asset('admin/img/undraw_profile.svg')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu  dropdown-menu-right bgdark shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item text-light" href="{{ route('profile.detail') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-light"></i>
                    Profile
                </a>
                <div class="dropdown-divider border-0"></div>
                <a class="dropdown-item text-light" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-light"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>