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
        <a class="btn btn-sm btn-danger" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('export.inventaris', Request::route('data')) }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
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
                            <th width="20%">Kode Inventaris</th>
                            <th width="15%">Kode Barang</th>
                            <th width="20%">Nama Barang</th>
                            <th width="5%">Baik</th>
                            <th width="5%">Rusak</th>
                            <th width="5%">Total</th>
                            <th width="10%">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->barang->kode_barang }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->barang->stock }}</td>
                            @if ( $data->barang->jml_rusak == null)
                            <td>0</td>
                            @else
                            <td>{{ $data->barang->jml_rusak }}</td>
                            @endif
                            <td>{{ $data->barang->stock + $data->barang->jml_rusak }}</td>
                            <td>{{substr($data->kode_inventaris,-4)}}</td>
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
