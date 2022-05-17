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
    <div class="d-sm-flex mb-4">
        <a href="{{ route('persuratan.create') }}" class="btn btn-sm btn-success mr-3">
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
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="25%">Kode</th>
                            <th width="20%">Nama</th>
                            <th width="15%">NIM</th>
                            <th width="15%">Alamat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat as $data)
                        <tr>
                            <td>
                                <div class="col">
                                    <div class="row">{{$data->created_at->format('d M Y')}}</div>
                                    <div class="row text-muted">
                                        <strong>({{$data->created_at->format('H:i:s A')}})</strong></div>
                                </div>
                            </td>
                            <td>{{ $data->kode }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->nim }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>
                                <a href="{{route('surat.show', ['surat' => $data->kode])}}"
                                    class="btn btn-info" title="Unduh Surat">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </td>
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
