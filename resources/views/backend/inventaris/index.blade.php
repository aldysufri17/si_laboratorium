@extends('backend.layouts.app')

@section('title', 'Catatan Inventaris')

@section('content')
@if ($inventaris->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Catatan Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Catatan Inventaris</li>
        </ol>
    </div>
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
       
        <a href="{{ route('inventaris.add', auth()->user()->role_id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Inventaris
        </a>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Catatan Inventaris</h6>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                    <thead>
                        <tr>
                            <th width="20%">ID Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="25%">ID Inventaris</th>
                            <th width="25%">Penambahan</th>
                            <th width="25%">Pengurangan</th>
                            <th width="25%">Sisa</th>
                            <th width="25%">Status</th>
                            <th width="25%">Deskripsi</th>
                            <th width="25%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->masuk }}</td>
                            <td>{{ $data->keluar }}</td>
                            <td>{{ $data->total }}</td>
                            <td>@if ($data->status == 1)
                                <span class="badge badge-success">Masuk</span>
                                @else
                                <span class="badge badge-danger">Keluar</span>
                                @endif</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>{{ $data->created_at }}</td>
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
                        @foreach ($inventaris as $data)
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
                                <a href="{{route('admin.inventaris', $data->kategori_lab)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                </table>
                {{ $inventaris->links() }}
            </div>
        </div>
    </div>

</div>

@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Catatan Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Catatan Inventaris</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('inventaris.add', auth()->user()->role_id)}}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Inventaris
        </a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Inventaris</p>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false,
            responsive: true,
            autoWidth: false,
            "order": [
                [0, "desc"]
            ]
        });
    });

</script>
@endsection
