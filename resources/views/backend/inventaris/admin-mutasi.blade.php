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
    <div class="d-sm-flex mb-4">
        <a class="btn btn-sm btn-danger mr-3" href="{{route('mutasi')}}"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <div class="dropdown mr-3">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownexel" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-file-csv"></i> Export Exel
            </button>
            <div class="dropdown-menu bgdark" aria-labelledby="dropdownexel">
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => Request::Route('data'),'status' => 1])}}">Status Masuk</a>
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => Request::Route('data'),'status' => 0])}}">Status Keluar</a>
                <a class="dropdown-item text-light" href="{{route('export.mutasi',['data' => Request::Route('data'),'status' => 2])}}">Semua Status</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownPDF" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-file-csv"></i> Export PDF
            </button>
            <div class="dropdown-menu bgdark" aria-labelledby="dropdownPDF">
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => Request::Route('data'),'status' => 1])}}">Status Masuk</a>
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => Request::Route('data'),'status' => 0])}}">Status Keluar</a>
                <a class="dropdown-item text-light" href="{{route('mutasi.pdf',['data' => Request::Route('data'),'status' => 2])}}">Semua Status</a>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <div class="my-2">
                    <form action="{{route('admin.mutasi', Request::route('data'))}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Tanggal Mutasi</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Date</th>
                            <th width="25%">Kode Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="5%">Masuk</th>
                            <th width="5%">Keluar</th>
                            <th width="5%">Sisa</th>
                            <th width="10%">Status</th>
                            <th width="10%">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>
                                <div class="col">
                                    <div class="row">{{$data->created_at->format('d M Y')}}</div>
                                    <div class="row text-muted">
                                        <strong>({{$data->created_at->format('H:i:s A')}})</strong></div>
                                </div>
                            </td>
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
                        </tr>
                        @endforeach
                    </tbody>
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
    <div class="d-sm-flex mb-4">
        <a class="btn btn-sm btn-danger mr-3" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
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
            order: [[0, 'desc']],
        });
    });

</script>
@endsection
