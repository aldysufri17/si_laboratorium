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
    <div class="d-sm-flex mb-4">
        <a class="btn btn-sm btn-danger" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('export.inventaris', Request::route('data')) }}" class="btn btn-sm btn-warning mx-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('inventaris.pdf',Request::route('data')) }}" class="btn btn-sm btn-info">
            <i class="fa-solid fa-file-export"></i> Export PDF
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
                            <th width="15%">Kode Inventaris</th>
                            <th width="15%">Nama Barang</th>
                            <th width="5%">Baik</th>
                            <th width="5%">Rusak</th>
                            <th width="5%">Total</th>
                            <th width="20%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->stok }}</td>
                            @if ( $data->barang->jml_rusak == null)
                            <td>0</td>
                            @else
                            <td>{{ $data->barang->jml_rusak }}</td>
                            @endif
                            <td>{{ $data->stok + $data->barang->jml_rusak }}</td>
                            @if ($data->keterangan == null)
                            <td>-</td>
                            @else
                            <td>{{$data->keterangan}}</td>
                            @endif
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
