@extends('backend.layouts.app')

@section('title', 'Catatan Inventaris')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Catatan Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Catatan Inventaris</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{ route('inventaris.index') }}"><i class="fas fa-angle-double-left"></i> Kembali</a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Catatan Inventaris</h6>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">ID Inventaris</th>
                            <th width="20%">ID Barang</th>
                            <th width="25%">Tanggal</th>
                            <th width="25%">Barang</th>
                            <th width="10%">Penambahan</th>
                            <th width="10%">Pengurangan</th>
                            <th width="25%">Sisa</th>
                            <th width="25%">Status</th>
                            <th width="25%">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                            <td>{{ $data->masuk }}</td>
                            <td>{{ $data->keluar }}</td>
                            <td>{{ $data->total }}</td>
                            <td>@if ($data->status == 1)
                                <span class="badge badge-success">Masuk</span>
                                @else
                                <span class="badge badge-danger">Keluar</span>
                                @endif</td>
                            <td>{{ $data->deskripsi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $inventaris->links() }}
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false,
            responsive: true,
            autoWidth: false,
            "order": [
                [0, "desc"]
            ]
        });
    });

</script>
@endsection
