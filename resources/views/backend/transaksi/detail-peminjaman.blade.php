@extends('backend.layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:history.back()">Daftar Keranjang</a></li>
            <li class="breadcrumb-item">Detail Pengajuan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="javascript:history.back()" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h4 class="text-center font-weight-bold text-light">DETAIL PEMINJAMAN<br>Kode : <span
                    style="text-transform: uppercase"><u>{{$detail->kode_peminjaman}}</u></span></h4>
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
                            <th width="10%">Gambar</th>
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
                            <td><img width="100px"
                                    src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                    class="img-fluid rounded-3"></td>
                            <td>{{ $data->barang->kode_barang }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->jumlah }} {{ $data->barang->satuan->nama_satuan }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        <h1 class="h5 mb-0 text-light">Detail Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:history.back()">Daftar Keranjang</a></li>
            <li class="breadcrumb-item">Detail Pengajuan</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="javascript:history.back()" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
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
