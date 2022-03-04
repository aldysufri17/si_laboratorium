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
        <a class="nav-link" href="{{ route('dashboard') }}">
        <span style="color: rgba(148, 148, 148, 0.938)">Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fas fa-user-alt"></i>
            <span>Masters</span>
        </a>
        <div id="taTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <h6 class="collapse-header text-dark">Admin Management:</h6>
                <a class="collapse-item text-red" href="{{ route('users.index') }}">User Master</a>
                @role('admin')
                <a class="collapse-item text-red" href="{{ route('operator.index') }}">Operator Master</a>
                <a class="collapse-item text-red" href="{{ route('roles.index') }}">Roles</a>
                @endrole
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barangDropDown"
            aria-expanded="true" aria-controls="barangDropDown">
            <i class="fas fa-box"></i>
            <span>Barang</span>
        </a>
        <div id="barangDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('barang.index') }}">Data Barang</a>
                <a class="collapse-item text-red" href="{{ route('barang.create') }}">Tambah Barang</a>
                <a class="collapse-item text-red" href="{{ route('damaged') }}">Barang Rusak</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventarisDropDown"
            aria-expanded="true" aria-controls="inventarisDropDown">
            <i class="fa-solid fa-cubes"></i>
            <span>Inventaris</span>
        </a>
        <div id="inventarisDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('inventaris.index') }}">Data Inventaris</a>
                <a class="collapse-item text-red" href="{{ route('inventaris.create') }}">Tambah Inventaris</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#peminjamanDropDown"
            aria-expanded="true" aria-controls="peminjamanDropDown">
            <i class="fa-solid fa-handshake"></i>
            <span>Konfirmasi</span>
        </a>
        <div id="peminjamanDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('konfirmasi.peminjaman') }}">Peminjaman</a>
                <a class="collapse-item text-red" href="{{route('konfirmasi.pengembalian')}}">Pengembalian</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('daftar.peminjaman')}}">
            <i class="fa-solid fa-book"></i>
            <span>Daftar Peminjaman</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('surat.index')}}">
            <i class="fa-solid fa-book"></i>
            <span>Surat Bebas Lab</span>
        </a>
    </li>
</ul>