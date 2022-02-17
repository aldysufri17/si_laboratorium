<ul class="navbar-nav sidebar sidebar-dark accordion bgdark" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon fa-pulse">
            <i class="fas fa-robot "></i>
        </div>
        <div class="sidebar-brand-text mx-3">Laboratorium</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
         <span style="color: rgba(148, 148, 148, 0.938)">Dashboard</span></a>
    </li>

    {{-- @hasrole('') --}}

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fas fa-user-alt text-warning"></i>
            <span>Masters Akun</span>
        </a>
        <div id="taTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <h6 class="collapse-header text-dark">Admin Management:</h6>
                <a class="collapse-item text-red" href="{{ route('operator.index') }}">Operator Master</a>
                <a class="collapse-item text-red" href="{{ route('users.index') }}">User Master</a>
                <a class="collapse-item text-red" href="{{ route('roles.index') }}">Roles</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barangDropDown"
            aria-expanded="true" aria-controls="barangDropDown">
            <i class="fas fa-calendar-alt text-info"></i>
            <span>Barang</span>
        </a>
        <div id="barangDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('barang.index') }}">Data Barang</a>
                <a class="collapse-item text-red" href="{{ route('barang.create') }}">Tambah Barang</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt text-danger"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>