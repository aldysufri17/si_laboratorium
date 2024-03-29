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
                @role('admin')
                <a class="collapse-item text-red" href="{{ route('lab.index') }}">Data Laboratorium</a>
                {{-- <a class="collapse-item text-red" href="{{ route('roles.index') }}">Data Roles</a> --}}
                <a class="collapse-item text-red" href="{{ route('operator.index') }}">Data Pengurus</a>
                @endrole
                <a class="collapse-item text-red" href="{{ route('users.index') }}">Data Pengguna</a>
                @role('operator')
                <a class="collapse-item text-red" href="{{ route('satuan.index') }}">Data Satuan</a>
                <a class="collapse-item text-red" href="{{ route('kategori.index') }}">Data Kategori</a>
                <a class="collapse-item text-red" href="{{ route('pengadaan.index') }}">Jenis Pengadaan</a>
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
                <a class="collapse-item text-red" href="{{ route('mutasi') }}">Data Mutasi</a>
                <a class="collapse-item text-red" href="{{ route('barang.damaged') }}">Barang Rusak</a>
                @role('operator')
                <a class="collapse-item text-red" href="{{ route('stok.show') }}">Update Stok</a>
                <a class="collapse-item text-red" href="{{ route('barang.dipinjam') }}">Barang Dipinjam</a>
                @endrole
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
                {{-- @role('operator')
                <a class="collapse-item text-red" href="{{ route('inventaris.add', auth()->user()->role_id) }}">Tambah Inventaris</a>
                @endrole --}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    @role('operator')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#peminjamanDropDown"
            aria-expanded="true" aria-controls="peminjamanDropDown">
            <i class="fa-solid fa-handshake"></i>
            <span>Peminjaman</span>
        </a>
        <div id="peminjamanDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('konfirmasi.pengajuan') }}">Pengajuan</a>
                <a class="collapse-item text-red" href="{{ route('konfirmasi.peminjaman') }}">Daftar Peminjam</a>
                <a class="collapse-item text-red" href="{{ route('daftar.riwayat') }}">Riwayat Peminjam</a>
                {{-- <a class="collapse-item text-red" href="{{route('konfirmasi.pengembalian')}}">Pengembalian</a> --}}
            </div>
        </div>
    </li>
    @endrole
    <!-- Nav Item - Pages Collapse Menu -->
    @role('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('daftar.riwayat')}}">
            <i class="fa-solid fa-book"></i>
            <span>Riwayat Peminjam</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#suratDropDown"
            aria-expanded="true" aria-controls="suratDropDown">
            <i class="fa-solid fa-file-lines"></i>
            <span>Surat Bebas Lab</span>
        </a>
        <div id="suratDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class=" py-2 collapse-inner rounded" style="background-color: rgb(230, 230, 230)">
                <a class="collapse-item text-red" href="{{ route('persuratan.create') }}">Buat Surat</a>
                <a class="collapse-item text-red" href="{{ route('persuratan.konfirmasi') }}">Konfirmasi Surat</a>
                <a class="collapse-item text-red" href="{{ route('persuratan.riwayat') }}">Riwayat Surat</a>
            </div>
        </div>
    </li>
    @endrole
</ul>