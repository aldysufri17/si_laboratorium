@extends('backend.layouts.app')

@section('title', 'Daftar Stock')

@section('content')
@if ($stock->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Stock</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Stock</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('stock.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Stock</h6>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="20%">ID Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="25%">Tipe</th>
                            <th width="25%">ID Inventaris</th>
                            <th width="25%">Penambahan</th>
                            <th width="25%">Pengurangan</th>
                            <th width="25%">Sisa</th>
                            <th width="25%">Status</th>
                            <th width="25%">Deskripsi</th>
                            <th width="25%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stock as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->tipe }}</td>
                            <td>{{ $data->inventaris }}</td>
                            <td>{{ $data->masuk }}</td>
                            <td>{{ $data->keluar }}</td>
                            <td>{{ $data->total }}</td>
                            <td>@if ($data->status == 1)
                            <span class="badge badge-success">Masuk</span>
                            @else
                            <span class="badge badge-danger">Keluar</span>
                            @endif</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $stock->links() }}
            </div>
        </div>
    </div>

</div>

@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Stock</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Stock</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('stock.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Barang</p>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false,
            responsive: true,
            autoWidth: false,
        });
    });

</script>
@endsection
