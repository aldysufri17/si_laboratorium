@extends('backend.layouts.app')

@section('title', 'Filter Peminjaman')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Filter Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Filter Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('scan', 'pengembalian') }}" class="btn btn-sm btn-info">
            <i class="fas fa-barcode"></i> Scan Barcode Pengembalian
        </a>
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
                            <th width="10%" class="text-center">Tanggal Masuk</th>
                            <th width="15%" class="text-center">Jumlah</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                        <tr>
                        <td class="text-center">{{ $item->date }}</td>
                        <td class="text-center">{{ $item->total }}</td>
                        <td class="d-sm-flex justify-content-center">
                            <a href="{{route('konfirmasi.peminjaman.detail', $item->date)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Show">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Filter Peminjaman</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('scan', 'pengembalian') }}" class="btn btn-sm btn-info">
            <i class="fas fa-barcode"></i> Scan Barcode Pengembalian
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Peminjaman</p>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false
        });
    });

</script>
@endsection
