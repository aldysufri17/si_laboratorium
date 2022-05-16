@extends('backend.layouts.app')

@section('title', 'Daftar Pengajuan')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('konfirmasi-pengajuan')}}">Filter Pengajuan</a></li>
            <li class="breadcrumb-item">Daftar Pengajuan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="javascript:history.back()" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    {{-- Alert Messages --}}
    {{-- @include('backend.common.alert') --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h4 class="text-center font-weight-bold text-light">DETAIL PEMINJAMAN</h4>
            <div class="detail mb-4">
                <table class="table table-borderless" cellspacing="0" width="100%">
                    <tr>
                        <td width="25%" class="font-weight-bold">NIM Peminjam</td>
                        <td>: {{$detail->user->nim}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nama Peminjam</td>
                        <td>: {{$detail->user->name}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Keperluan</td>
                        <td>: {{$detail->alasan}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Tanggal Peminjaman</td>
                        <td>: {{$detail->tgl_start}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Tanggal Pengembalian</td>
                        <td>: {{$detail->tgl_end}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Waktu Masuk Pengajuan</td>
                        <td>: {{$detail->created_at}}</td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th width="10%">Kode Barang</th>
                            <th width="10%">Barang</th>
                            <th width="5%">Jumlah</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $data->barang->kode_barang }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->jumlah }} {{ $data->barang->satuan->nama_satuan }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                {{-- <a href="{{ route('konfirmasi.peminjaman.status', ['id_peminjaman' => $data->id, 'status' => 2,'barang_id' => $data->barang_id, 'jumlah' => $data->jumlah, 'user_id' => $data->user_id]) }}"
                                class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Accept">
                                <i class="fa fa-check"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin
                    Menghapus?
                </h5>
                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-white">Jika anda yakin ingin manghapus, Tekan Oke !!
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                    Oke
                </a>
                <form id="user-delete-form" method="POST" action="{{ route('peminjaman.destroy', ['id' => 1]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_id" id="delete_id">
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">konfirmasi-pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('konfirmasi-pengajuan')}}">Filter Pengajuan</a></li>
            <li class="breadcrumb-item">Daftar Pengajuan</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{route('konfirmasi.pengajuan')}}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Pengajuan</p>
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
        });
    });
    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
    });

</script>
@endsection
