@extends('backend.layouts.app')

@section('title', 'Riwayat Persuratan')

@section('content')

@if ($surat->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Riwayat Persuratan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Riwayat Persuratan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('persuratan.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Buat Surat
        </a>
        <a href="{{ route('export.surat') }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('surat.pdf') }}" class="btn btn-sm btn-danger ml-3">
            <i class="fa-solid fa-file-export"></i> Export PDF
        </a>
    </div>

    {{-- Alert Messages --}}
    {{-- @include('backend.common.alert') --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Riwayat Persuratan</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="20%">Nama</th>
                            <th width="15%">NIM</th>
                            <th width="25%">Email</th>
                            <th width="15%">No Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat as $data)
                        <tr>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->user->nim }}</td>
                            <td>{{ $data->user->email }}</td>
                            <td>{{ $data->user->mobile_number }}</td>
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
        <h1 class="h5 mb-0 text-light">Riwayat Persuratan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Riwayat Persuratan</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('persuratan.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Buat Surat
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Surat</p>
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
