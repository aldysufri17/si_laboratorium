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
    <div class="d-sm-flex align-items-center mb-4">
        <a class="btn btn-sm btn-danger" href="javascript:history.back()"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('export.peminjaman', Request::route('data')) }}" class="btn btn-sm btn-warning mx-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <div class="my-2">
                    <form action="{{route('admin.peminjaman', Request::route('data'))}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Date</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th width="15%">Kode Pinjam</th>
                            <th width="10%">Nama/Nim</th>
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
                            <td>{{$data->kode_peminjaman}}</td>
                            <td>{{ $data->user->nim }}/<br>{{ $data->user->name }}</td>
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
                </table>
            </div>
        </div>
    </div>
</div>
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
