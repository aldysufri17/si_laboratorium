@extends('backend.layouts.app')

@section('title', 'Daftar Barang')

@section('content')
@if ($message = Session::get('active'))
<div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>{{ $message }}</strong> {{ session('error') }}
</div>
@endif
@if ($barang->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Barang</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center mb-4">
        @role('operator')
        <a href="{{ route('barang.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
        <a href="{{ route('qrcode', 0) }}" class="btn btn-sm btn-primary mx-3">
            <i class="fas fa-qrcode"></i> Cetak Semua QR-Code
        </a>
        <a class="btn btn-sm btn-info mr-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import Exel</a>
        <a href="{{ route('export.barang', 0) }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('barang.pdf',0) }}" class="btn btn-sm btn-danger ml-3">
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
                    @role('operator')
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode Barang</th>
                            <th width="15%">Nama</th>
                            <th width="15%">Stok</th>
                            <th width="15%">Pengadaan</th>
                            <th width="10%">Tampilkan</th>
                            @role('operator')
                            <th width="25%">Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $key=>$data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->kode_barang}}</td>

                            <td>{{ $data->nama }} - {{ $data->tipe }}</td>

                            @if($data->satuan_id == 0)
                            <td>{{ $data->stock }} - Default</td>
                            @else
                            <td>{{ $data->stock }} - {{ $data->satuan->nama_satuan }}</td>
                            @endif
                            <td>{{$data->pengadaan->nama_pengadaan}}</td>

                            <td>@if ($data->show == 0)
                                <span class="badge badge-danger">Tidak</span>
                                @elseif ($data->show == 1)
                                <span class="badge badge-success">Tampil</span>
                                @endif</td>
                            <td style="display: flex">
                                <a class="btn btn-info" href="{{ route('barang.show', encrypt($data->id)) }}" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @role('operator')
                                <a href="{{ route('barang.edit', encrypt($data->id)) }}" class="btn btn-primary mx-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endrole
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                    @role('admin')
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Kategori</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td class="text-center">{{$data->nama}}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.barang', encrypt($data->id))}}" class="btn btn-primary"
                                    data-toggle="tooltip" data-placement="top" title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                </table>
                {{-- {{ $barang->links() }} --}}
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
    @role('operator')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('barang.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
        <a class="btn btn-sm btn-info ml-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import Exel</a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Barang</p>
    </div>
</div>
@endif
@include('backend.barang.barang-modal')
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });
    });

</script>
@endsection
