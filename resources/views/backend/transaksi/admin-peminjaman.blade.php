@extends('backend.layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('daftar.peminjaman')}}">Filter Peminjaman</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{ route('daftar.peminjaman') }}"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-file-export"></i> Export
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
                            <th width="10%">NIM</th>
                            <th width="15%">Nama</th>
                            <th width="15%">Barang</th>
                            <th width="15%">Tipe</th>
                            <th width="15%">Peminjaman</th>
                            <th width="15%">Pengembalian</th>
                            <th width="10%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $result => $data)
                        <tr>
                            <td>{{ $data->user->nim }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->barang->nama }}</td>
                            <td>{{ $data->barang->tipe }}</td>
                            <td>{{ $data->tgl_start }}</td>
                            <td>{{ $data->tgl_end }}</td>
                            <td>
                                @if ($data->status == 3)
                                <span class="badge badge-success">Active</span>
                                @elseif($data->status == 4)
                                <span class="badge badge-primary">Clear</span>
                                @else
                                <span class="badge badge-secondary">Pending</span>
                                @endif
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
