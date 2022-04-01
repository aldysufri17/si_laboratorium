@extends('backend.layouts.app')

@section('title', 'Daftar Barang')

@section('content')
@if ($barang->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Barang</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
        <a href="{{ route('barang.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
        <a href="{{ route('qrcode', 0) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-qrcode"></i> Cetak Semua QR-Code
        </a>
        @endrole
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            @hasanyrole('admin')
            <h6 class="m-0 font-weight-bold text-light">Daftar Laboratorium</h6>
            @else
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Barang</h6>
            @endhasanyrole
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                    <thead>
                        <tr>
                            <th width="15%">Nama</th>
                            <th width="15%">Tipe</th>
                            <th width="15%">Stock</th>
                            <th width="10%">Status</th>
                            <th width="15%">Lokasi Barang</th>
                            <th width="15%">Detail</th>
                            @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                            <th width="25%">Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->tipe }}</td>
                            <td>{{ $data->stock }} {{ $data->satuan }}</td>
                            <td>@if ($data->show == 0)
                                <span class="badge badge-danger">Hidden</span>
                                @elseif ($data->show == 1)
                                <span class="badge badge-success">Show</span>
                                @endif</td>
                            <td>{{ $data->lokasi }}</td>
                            <td><a class="btn btn-info m-2" href="{{ route('barang.show', $data->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a></td>
                            @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
                            <td style="display: flex">
                                <a href="{{ route('barang.edit', $data->id) }}" class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                    @include('backend.barang.delete-modal')
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
                        @foreach ($barang as $data)
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
                                <a href="{{route('admin.barang', $data->kategori)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                </table>

                {{ $barang->links() }}
            </div>
        </div>
    </div>

</div>

@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Barang</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('barang.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Barang</p>
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
