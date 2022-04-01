@extends('backend.layouts.app')

@section('title', 'Daftar User')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-file-export"></i> Export
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
                    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
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
                    @endrole
                    @role('admin')
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Kategori</th>
                            <th width="10%" class="text-center">Jumlah</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $result => $data)
                        <tr>
                            <td class="text-center">
                                @if ($data->kategori == 1)
                                Laboratorium Sistem Tertanam dan Robotika
                                @elseif ($data->kategori == 2)
                                Laboratorium Rekayasa Perangkat Lunak
                                @elseif($data->kategori == 3)
                                Laboratorium Jaringan dan Keamanan Komputer
                                @elseif($data->kategori == 4)
                                Laboratorium Multimedia
                                @endif</td>
                            <td class="text-center">{{ $data->total }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.peminjaman', $data->kategori)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
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
            <li class="breadcrumb-item">Daftar User</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-file-export"></i> Export
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
