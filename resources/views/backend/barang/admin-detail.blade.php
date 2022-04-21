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
    <div class="d-sm-flex align-items-center mb-4">
        <a class="btn btn-sm btn-danger" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('qrcode', Request::route('data')) }}" class="btn btn-sm btn-primary mx-3">
            <i class="fas fa-qrcode"></i> Cetak Semua QR-Code
        </a>
        <a href="{{ route('export.barang', Request::route('data')) }}" class="btn btn-sm btn-warning mr-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('barang.pdf',Request::route('data')) }}" class="btn btn-sm btn-info">
            <i class="fa-solid fa-file-export"></i> Export PDF
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
                            <th width="15%">Kategori</th>
                            <th width="15%">Nama</th>
                            <th width="15%">Stock</th>
                            <th width="10%">Tampilkan</th>
                            <th width="15%">Lokasi Barang</th>
                            <th width="15%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            @if($data->kategori_id == 0)
                            <td>Default</td>
                            @else
                            <td>{{ $data->kategori->nama_kategori }}</td>
                            @endif
                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                            @if($data->satuan_id == 0)
                            <td>{{ $data->stock }} - Default</td>
                            @else
                            <td>{{ $data->stock }} - {{ $data->satuan->nama_satuan }}</td>
                            @endif
                            <td>@if ($data->show == 0)
                                <span class="badge badge-danger">Tidak</span>
                                @elseif ($data->show == 1)
                                <span class="badge badge-success">Tampil</span>
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
