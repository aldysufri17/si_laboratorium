@extends('backend.layouts.app')

@section('title', 'Data Barang Rusak')

@section('content')
@if ($barang->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/barang')}}">Daftar Barang</a></li>
            <li class="breadcrumb-item">Barang Rusak</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th width="25%">Kode Barang</th>
                            <th width="20%">Kategori Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="20%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td>{{ $data->updated_at }}</td>
                            <td>{{ $data->kode_barang }}</td>
                            <td>{{ $data->kategori->nama_kategori }}</td>
                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                            <td>{{ $data->jml_rusak }} - {{$data->satuan->nama_satuan}}</td>
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
        <h1 class="h5 mb-0 text-light">Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Barang Rusak</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center mb-4">
        @role('admin')
        <a href="{{ url('damaged/barang') }}" class="btn btn-sm btn-danger mr-3">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
        @endrole
    </div>
    @include('sweetalert::alert')
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Barang Rusak</p>
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
            "order": [[ 0, "desc" ]]
        });
    });

</script>
@endsection
