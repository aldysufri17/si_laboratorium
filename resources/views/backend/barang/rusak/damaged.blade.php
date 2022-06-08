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

    <div class="d-sm-flex align-items-center mb-4">
        @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
        <a href="{{ route('damaged.create') }}" class="btn btn-sm btn-success mr-3">
            <i class="fas fa-plus"></i> Tambah Barang Rusak
        </a>
        <a href="{{ route('damaged.export', 0) }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('damaged.pdf',0) }}" class="btn btn-sm btn-danger ml-3">
            <i class="fa-solid fa-file-export"></i> Export PDF
        </a>
        @endrole
    </div>
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
                            <th width="15%">Date</th>
                            <th width="15%">Kode Barang</th>
                            <th width="20%">Nama Barang</th>
                            <th width="15%">Jumlah</th>
                            <th width="25%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td>{{ $data->updated_at }}</td>
                            <td>{{ $data->kode_barang }}</td>
                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                            <td>{{ $data->jml_rusak }} - {{$data->satuan->nama_satuan}}</td>
                            <td>{{$data->keterangan_rusak}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endhasanyrole
                </table>

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
    <div class="d-sm-flex align-items-center mb-4">
        @role('operator embedded|operator rpl|operator jarkom|operator mulmed')
        <a href="{{ route('damaged.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Barang Rusak
        </a>
        @endrole
    </div>
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
            responsive: true,
            autoWidth: false,
            "order": [[ 0, "desc" ]]
        });
    });

</script>
@endsection
