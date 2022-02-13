@extends('backend.layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang</h1>
        <a href="{{ route('barang.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('backend.common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Barang</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="15%">Jumlah</th>
                            <th width="25%">Satuan</th>
                            <th width="15%">Tgl.Masuk</th>
                            <th width="15%">Kondisi</th>
                            <th width="15%">Tampilkan</th>
                            <th width="15%">Foto</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->jumlah }}</td>
                            <td>{{ $data->satuan }}</td>
                            <td>{{ $data->tgl_masuk }}</td>
                            <td>{{ $data->kondisi }}</td>
                            <td>{{ $data->show }}</td>
                            <td>{{ $data->foto }}</td>
                            <td style="display: flex">
                                <a href="{{ route('barang.edit', ['barang' => $data->id_barang]) }}" class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $barang->links() }}
            </div>
        </div>
    </div>

</div>

@include('backend.barang.delete-modal')

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
