@extends('backend.layouts.app')

@section('title', 'Daftar Pengajuan')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Pengajuan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- <a href="{{ route('pengajuan.all',2) }}" class="btn btn-sm btn-success">
            <i class="fas fa-check"></i> Setujui Semua Pengajuan
        </a>
        <a href="{{ route('pengajuan.all',1) }}" class="btn btn-sm btn-danger">
            <i class="fas fa-ban"></i> Tolak Semua Pengajuan
        </a> --}}
        {{-- <a href="https://aldysufri17.github.io/scan.github.io/" class="btn btn-sm btn-info">
            <i class="fas fa-qrcode"></i> Scan Pengembalian
        </a> --}}
    </div>
    {{-- Alert Messages --}}
    {{-- @include('backend.common.alert') --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">NIM</th>
                            <th width="10%" class="text-center">Nama</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                        <tr>
                            @php
                            $id = $item->user_id;
                            $nim = App\Models\user::where('id', $id)->value('nim');
                            @endphp
                            <td class="text-center">{{ $nim }}</td>
                            <td class="text-center">{{ $item->user->name }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('show.pengajuan', ['id' => encrypt($item->user_id)])}}" class="btn btn-primary"
                                    data-toggle="tooltip" data-placement="top" title="Show">
                                    <i class="fa fa-eye"></i>
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
        <h1 class="h5 mb-0 text-light">Daftar Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Pengajuan</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Pengajuan</p>
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
            "bInfo": false,
        });
    });

</script>
@endsection
