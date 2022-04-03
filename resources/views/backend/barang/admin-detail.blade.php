@extends('backend.layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Barang</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{ route('barang.index') }}"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('qrcode', Request::route('data')) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-qrcode"></i> Cetak Semua QR-Code
        </a>
    </div>
    {{-- Alert Messages --}}
    @include('sweetalert::alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Barang</h6>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Nama</th>
                            <th width="15%">Tipe</th>
                            <th width="15%">Stock</th>
                            <th width="10%">Status</th>
                            <th width="15%">Lokasi Barang</th>
                            <th width="15%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->tipe }}</td>
                            <td>{{ $data->stock }} {{ $data->satuan }}</td>
                            <td>@if ($data->show == 0)
                                <span class="badge badge-danger">Hidden</span>
                                @elseif ($data->show == 1)
                                <span class="badge badge-success">Show</span>
                                @endif</td>
                            <td>{{ $data->lokasi }}</td>
                            <td><a class="btn btn-info m-2" href="{{ route('barang.show', $data->id) }}" title="Show">
                                <i class="fas fa-eye"></i>
                            </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $barang->links() }}
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
            "order": [[ 0, "desc" ]]
        });
    });

</script>
@endsection
