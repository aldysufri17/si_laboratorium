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
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">NIM</th>
                            <th width="15%">Nama</th>
                            <th width="10%">Barang</th>
                            <th width="5%">Jumlah</th>
                            <th width="10%">Peminjaman</th>
                            <th width="10%">Pengembalian</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $result => $data)
                        <tr>
                            <td>{{ $data->user->nim }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->jumlah }} {{ $data->barang->satuan->nama_satuan }}</td>
                            <td>{{ $data->tgl_start }}</td>
                            <td>{{ $data->tgl_end }}</td>
                            <td style="display: flex">
                                <a class="btn btn-info" href="{{ route('konfirmasi.peminjaman.show', $data->id) }}" title="Show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-danger tolak-btn" title="Tolak" value="{{$data->id}}">
                                    <i class="fa fa-ban"></i>
                                </button>
                                {{-- <a href="{{ route('konfirmasi.peminjaman.status', ['id_peminjaman' => $data->id, 'status' => 1, 'barang_id' => $data->barang_id, 'jumlah' => $data->jumlah, 'user_id' => $data->user_id]) }}"
                                    class="btn btn-danger mx-" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="fa fa-ban"></i>
                                </a> --}}
                                <a href="{{ route('konfirmasi.peminjaman.status', ['id_peminjaman' => $data->id, 'status' => 2,'barang_id' => $data->barang_id, 'jumlah' => $data->jumlah, 'user_id' => $data->user_id]) }}"
                                    class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tolakModal" tabindex="-1" role="dialog" aria-labelledby="tolakModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="tolakModalExample">Berikan Alasan Penolakan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">
                <form id="user-delete-form" method="GET" action="{{ route('peminjaman.tolak') }}">
                    @csrf
                    <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                    <textarea type="text" class="form-control form-control-user" placeholder="Pesan" name="pesan"></textarea>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                    Oke
                </a>
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
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
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
            "bInfo": false,
            "paging": false,
            responsive: true,
            autoWidth: false,
        });
    });
    $(document).on('click', '.tolak-btn',function () {
            var sid = $(this).val();
            $('#tolakModal').modal('show')
            $('#peminjaman_id').val(sid)
        });
</script>
@endsection
