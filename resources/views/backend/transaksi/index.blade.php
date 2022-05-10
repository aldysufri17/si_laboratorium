@extends('backend.layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center mb-4">
        <a href="{{ route('export.peminjaman', 0) }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                <div class="my-2">
                    <form action="{{route('daftar.peminjaman')}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Tanggal</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
                @endrole
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                    <thead>
                        <tr>
                            <th width="15%">Tanggal</th>
                            <th width="10%">NIM</th>
                            <th width="15%">Nama</th>
                            <th width="15%">Barang</th>
                            <th width="15%">Jumlah</th>
                            <th width="15%">Peminjaman</th>
                            <th width="15%">Pengembalian</th>
                            <th width="10%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $result => $data)
                        <tr>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->user->nim }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->jumlah }} {{ $data->barang->satuan->nama_satuan }}</td>
                            <td>{{ $data->tgl_start }}</td>
                            <td>{{ $data->tgl_end }}</td>
                            <td>
                                @if ($data->status == 2)
                                <span class="badge badge-success">Pinjam</span>
                                @elseif($data->status == 4)
                                <span class="badge badge-primary">Selesai</span>
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
                                @if ($data->kategori_lab == 1)
                                Laboratorium Sistem Tertanam dan Robotika
                                @elseif ($data->kategori_lab == 2)
                                Laboratorium Rekayasa Perangkat Lunak
                                @elseif($data->kategori_lab == 3)
                                Laboratorium Jaringan dan Keamanan Komputer
                                @elseif($data->kategori_lab == 4)
                                Laboratorium Multimedia
                                @endif</td>
                            <td class="text-center">{{ $data->total }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.peminjaman', $data->kategori_lab)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
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
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    @include('sweetalert::alert')
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
