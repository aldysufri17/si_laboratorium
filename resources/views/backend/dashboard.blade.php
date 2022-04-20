@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    @include('sweetalert::alert')
    <!-- Page Heading -->
    @php
    date_default_timezone_set('Asia/jakarta');
    $Hour = date('G');
    if ( $Hour >= 5 && $Hour <= 11 ) { $time="Selamat Pagi" ; } else if ( $Hour>= 12 && $Hour <= 15 ) {
            $time="Selamat Siang" ; }else if ( $Hour>= 15 && $Hour <= 18 ) { $time="Selamat Sore" ; }else if ( $Hour>=
                19 || $Hour <= 4 ) { $time="Selamat Malam" ; } @endphp <div
                    class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-light">{{$time .', '. auth()->user()->name}}.</h1>
</div>
@role('operator embedded|operator rpl|operator jarkom|operator mulmed')
@if($peminjaman->isNotEmpty())
@if ($message = Session::get('eror'))
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>{{ $message }}</strong> {{ session('error') }}
</div>
@endif
@endif
@endrole
<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    @role('admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Akun Pengurus</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ App\Models\User::where('role_id', '>', 2)->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Akun Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ App\Models\User::where('role_id', 1)->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @role('operator embedded|admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Barang Lab Sistem Tertanam dan Robotika</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 1)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Inventaris Barang Lab Sistem Tertanam dan Robotika</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Inventaris::where('kategori_lab', 1)->where('status',2)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Barang Rusak Lab Sistem Tertanam dan Robotika</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 1)->sum('jml_rusak')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator embedded')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Dipinjam
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 1)->where('status', '=', '3')->sum('jumlah')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-right-from-bracket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Peminjaman Active
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 1)->where('status', 3)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-creative-commons-by fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator rpl|admin')
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Barang Lab Rekayasa
                            Perangkat Lunak
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Barang::where('kategori_lab', 2)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Inventaris Barang Lab Rekayasa
                            Perangkat Lunak
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Inventaris::where('kategori_lab', 2)->where('status',2)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Barang Rusak Lab
                            Rekayasa
                            Perangkat Lunak
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Barang::where('kategori_lab', 2)->sum('jml_rusak')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator rpl')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Dipinjam
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 2)->where('status', '=', '3')->sum('jumlah')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-right-from-bracket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Peminjaman Active
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 2)->where('status', 3)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-creative-commons-by fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator jarkom|admin')
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Barang Lab Jaringan dan Keamanan Komputer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 3)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-network-wired fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Inventaris Barang Lab Jaringan dan Keamanan Komputer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Inventaris::where('kategori_lab', 3)->where('status',2)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-network-wired fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Barang Rusak Lab Jaringan dan Keamanan Komputer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 3)->sum('jml_rusak')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-network-wired fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator jarkom')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Dipinjam
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 3)->where('status', '=', '3')->sum('jumlah')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-right-from-bracket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Peminjaman Active
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 3)->where('status', 3)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-creative-commons-by fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator mulmed|admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-light bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Total Barang Lab Multimedia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 4)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-masks-theater fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-light bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Total Inventaris Barang Lab Multimedia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Inventaris::where('kategori_lab', 4)->where('status',2)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-masks-theater fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-light bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-light text-uppercase mb-1">
                            Total Barang Rusak Lab Multimedia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Barang::where('kategori_lab', 4)->sum('jml_rusak')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-masks-theater fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('operator mulmed')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Dipinjam
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 4)->where('status', '=', '3')->sum('jumlah')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-right-from-bracket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Peminjaman Active
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{App\Models\Peminjaman::where('kategori_lab', 4)->where('status', 3)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-creative-commons-by fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('admin')
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Histori Peminjaman Seluruh Lab</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Peminjaman::where('status', 4)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark bgdark border-0 shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Surat Bebas Lab</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{App\Models\Surat::where('status', 3)->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-file-lines fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection
