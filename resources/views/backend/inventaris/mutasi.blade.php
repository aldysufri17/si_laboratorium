@extends('backend.layouts.app')

@section('title', 'Mutasi Stock Peminjaman')

@section('content')
@if ($inventaris->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Mutasi Stock Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Mutasi Stock Barang</li>
        </ol>
    </div>
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center mb-4">
        <div class="dropdown mr-3">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownexel" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-file-csv"></i> Export Exel
            </button>
            <div class="dropdown-menu bgdark" aria-labelledby="dropdownexel">
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => 0,'status' => 1])}}">Status Masuk</a>
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => 0,'status' => 0])}}">Status Keluar</a>
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => 0,'status' => 2])}}">Semua Status</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownPDF" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-file-csv"></i> Export PDF
            </button>
            <div class="dropdown-menu bgdark" aria-labelledby="dropdownPDF">
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => 0,'status' => 1])}}">Status Masuk</a>
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => 0,'status' => 0])}}">Status Keluar</a>
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => 0,'status' => 2])}}">Semua Status</a>
            </div>
        </div>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                    <thead>
                        <tr>
                            <th width="25%">Kode Mutasi</th>
                            <th width="25%">Kode Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="5%">Masuk</th>
                            <th width="5%">Keluar</th>
                            <th width="5%">Sisa</th>
                            <th width="10%">Status</th>
                            <th width="10%">Deskripsi</th>
                            <th width="25%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>{{ $data->kode_mutasi }}</td>
                            <td>{{ $data->barang->kode_barang }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->masuk }}</td>
                            <td>{{ $data->keluar }}</td>
                            <td>{{ $data->total }}</td>
                            <td>@if ($data->status == 1)
                                <span class="badge badge-success">Masuk</span>
                                @elseif($data->status == 0)
                                <span class="badge badge-danger">Keluar</span>
                                @else
                                <span class="badge badge-info">Created</span>
                                @endif</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                    @role('admin')
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Kategori</th>
                            <th width="10%" class="text-center">Jumlah</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td class="text-center">
                                @if ($data->kategori_lab == 1)
                                Laboratorium Sistem Tertanam dan Robotika
                                @elseif ($data->kategori_lab == 2)
                                Laboratorium Rekayasa Perangkat Lunak
                                @elseif($data->kategori_lab == 3)
                                Laboratorium Jaringan dan Keamanan Komputer
                                @elseif($data->kategori_lab == 4)
                                Laboratorium Multimedia
                                @endif</td>
                            <td class="text-center">{{ $data->total }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.mutasi', $data->kategori_lab)}}" class="btn btn-primary"
                                    data-toggle="tooltip" data-placement="top" title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                </table>
            </div>
        </div>
    </div>

</div>

@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Mutasi Stock Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Mutasi Stock Barang</li>
        </ol>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Mutasi</p>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });

</script>
@endsection
