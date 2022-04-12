@extends('backend.layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
@if ($message = Session::get('active'))
<div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>{{ $message }}</strong> {{ session('error') }}
</div>
@endif
@if ($kategori->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Kategori</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Kategori</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center mb-4">
        <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Kategori</h6>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Nama</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td style="display: flex">
                                <a class="btn btn-info m-2" href="{{ route('kategori.show', $data->id) }}" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori.edit', $data->id) }}" class="btn btn-primary m-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $kategori->links() }}
            </div>
        </div>
    </div>
</div>
@include('backend.barang.kategori.delete-modal')
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Kategori</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Kategori</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Kategori</p>
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
