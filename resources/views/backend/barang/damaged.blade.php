@extends('backend.layouts.app')

@section('title', 'Data Barang Rusak')

@section('content')
@if ($barang->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Barang Rusak</li>
        </ol>
    </div>
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('inventaris.add', auth()->user()->role_id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    @endrole
    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    @hasanyrole('admin')
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Kategori</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
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
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.damaged', $data->kategori_lab)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    <thead>
                        <tr>
                            <th width="10%">Status</th>
                            <th width="20%">ID Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="25%">Tipe</th>
                            <th width="25%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td><span class="badge badge-danger">Rusak</span></td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->tipe }}</td>
                            <td>{{ $data->jml_rusak }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endhasanyrole
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
        <h1 class="h5 mb-0 text-light">Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Barang Rusak</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('inventaris.add', auth()->user()->role_id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Barang Rusak</p>
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
        });
    });

</script>
@endsection
