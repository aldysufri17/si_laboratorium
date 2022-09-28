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
@role('operator')
@if($notif->isNotEmpty())
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
<div class="container-fluid">
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary bgdark border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Akun Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\User::where('role', 1)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @role('admin')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary bgdark border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Akun Pengurus</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\User::where('role', '>', 2)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger bgdark border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Peminjaman Selesai Seluruh Lab</div>
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
        @foreach ($laboratorium as $item)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success bgdark border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Barang {{$item->nama}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{App\Models\Barang::where('laboratorium_id', $item->id)->count()}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
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
                                Total Barang Rusak {{$item->nama}}</div>
                            <div class="h5 mb-0 font-weight-bold text-warning-800">
                                {{App\Models\Barang::where('laboratorium_id', $item->id)->sum('jml_rusak')}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-warning-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endrole

        @role('operator')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success bgdark border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Barang Laboratorium</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{App\Models\Barang::where('laboratorium_id', auth()->user()->post)->count()}}
                            </div>
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
                                Total Barang Rusak </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{App\Models\Barang::where('laboratorium_id', auth()->user()->post)->sum('jml_rusak')}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                        {{App\Models\Peminjaman::whereHas('barang', function ($q) {
                                            $q->where('laboratorium_id', auth()->user()->post);
                                        })->whereBetween('status', [2,3])->sum('jumlah')}}
                                    </div>
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
    </div>
    <div class="d-flex justify-content-around flex-wrap">
        <div class="Habis" style="width: 500px">
            <table class="table table-striped table-dark table-bordered">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center bg-warning">Daftar Barang Habis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="20%" class="bg-primary" scope="row">Kode Barang</th>
                        <th width="20%" class="bg-primary" scope="row">Nama Barang</th>
                        <th width="5%" class="bg-primary">Stok</th>
                    </tr>
                    @if ($habis->isNotEmpty())
                    @foreach ($habis as $data)
                    <tr>
                        <td scope="row">{{$data->kode_barang}}</td>
                        <td scope="row">{{$data->nama}} - {{$data->tipe}}</td>
                        <td><span class="badge badge-danger">Habis</span></td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="4">== Belum Terdapat Stok Barang Habis == </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{$habis->links()}}
        </div>
        <div class="Telat" style="width: 500px">
            <table class="table table-striped table-dark table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center bg-warning">Daftar Pengembalian Telat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-primary" scope="row">Nim</td>
                        <td class="bg-primary" scope="row">Nama Peminjam</td>
                        <th class="bg-primary" scope="row">Kode</th>
                        <th class="bg-primary">Telat</th>
                    </tr>
                    @if ($telat->isNotEmpty())
                    @foreach ($telat as $data)
                    <tr>
                        <td scope="row">{{$data->user->nim}}</td>
                        <td scope="row">{{$data->user->name}}</td>
                        <td scope="row"><span style="text-transform:uppercase">{{$data->kode_peminjaman}}</span></td>
                        @if ($data->tgl_end < date('Y-m-d')) @php $start=\Carbon\Carbon::createFromFormat('Y-m-d',
                            $data->
                            tgl_end);
                            $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $late = $start->diffInDays($now);
                            @endphp
                            <td><span class="badge badge-danger">{{ $late.' '.'Hari' }}</span></td>
                            @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="4">== Belum Terdapat Pengembalian Telat == </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{$telat->links()}}
        </div>
    </div>
    @if ($barang->isNotEmpty())
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-warning py-3">
            <h6 class="m-0 font-weight-bold text-light">Barang Dipinjam</h6>
        </div>
        <div class="card-body bg-dark">
            @foreach ($barang as $key=>$item)
            <h4 class="small text-light font-weight-bold">{{$item->barang->nama}}-{{$item->barang->tipe}}
                <span class="float-right">{{$item->sum}} {{$item->barang->satuan->nama_satuan}}</span></h4>
            @php
            $total = App\Models\Peminjaman::whereBetween('status', [2,
            3])->where('barang_id',$item->barang_id)->count();
            $rata_rata = $item->sum / $total;
            if ($key % 2 == 0) {
            $color = "bg-primary";
            } else {
            $color = "bg-danger";
            }
            @endphp
            <div class="progress mb-4" title="Barang dipinjam oleh {{$total}} orang">
                <div class="progress-bar {{$color}}" role="progressbar" style="width: {{$rata_rata}}%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endrole
</div>
@endsection
