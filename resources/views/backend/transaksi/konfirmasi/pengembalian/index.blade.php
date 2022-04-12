@extends('backend.layouts.app')

@section('title', 'Pengembalian')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Pengembalian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengembalian</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('scan', 'pengembalian') }}" class="btn btn-sm btn-info">
            <i class="fas fa-barcode"></i> Scan Barcode
        </a>
    </div>

    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <form action="{{route('status.update')}}" method="post">
                @csrf
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <button type="submit" class="btn btn-sm btn-success">
                        Accept All
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" id="checkAll"></th>
                                <th width="10%">NIM</th>
                                <th width="15%">Nama</th>
                                <th width="15%">Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="15%">Peminjaman</th>
                                <th width="15%">Pengembalian</th>
                                <th width="10%">Telat</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $result => $data)
                            <tr>
                                <td><input type="checkbox" name="ckd_chld[]" value="{{$data->id}}" id=""></td>
                                <td>{{ $data->user->nim }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                                <td>{{ $data->jumlah }} {{ $data->barang->satuan->nama }}</td>
                                <td>{{ $data->tgl_start }}</td>
                                <td>{{ $data->tgl_end }}</td>
                                @if ($data->tgl_end < date('Y-m-d')) @php
                                    $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                                    $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                    $late = $start->diffInDays($now);
                                    @endphp
                                    <td>{{ $late.' '.'Hari' }}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('konfirmasi.peminjaman.status', ['user_id' => $data->id, 'status' => 4,'barang_id' => $data->barang_id, 'jumlah' => $data->jumlah]) }}"
                                            class="btn btn-success mx-2" data-toggle="tooltip" data-placement="top"
                                            title="Clear">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $peminjaman->links() }}
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Pengembalian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengembalian</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('scan', 'pengembalian') }}" class="btn btn-sm btn-info">
            <i class="fas fa-barcode"></i> Scan Barcode
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

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

</script>
@endsection
