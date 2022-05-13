@extends('backend.layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('konfirmasi-peminjaman')}}">Filter Peminjaman</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
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
                                <th width="10%">Nama</th>
                                <th width="15%">Barang</th>
                                <th width="5%">Jumlah</th>
                                <th width="10%">Peminjaman</th>
                                <th width="10%">Pengembalian</th>
                                <th width="10%">Telat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $result => $data)
                            <tr>
                                <td>{{ $data->user->name }}</td>
                                <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                                <td>{{ $data->jumlah }} {{$data->barang->satuan->nama_satuan}}</td>
                                <td>{{ $data->tgl_start }}</td>
                                <td>{{ $data->tgl_end }}</td>
                                @if ($data->tgl_end < date('Y-m-d')) @php
                                    $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                                    $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                    $late = $start->diffInDays($now);
                                    @endphp
                                    <td><span class="badge badge-danger">{{ $late.' '.'Hari' }}</span></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                <td style="display: flex">
                                    <a class="btn btn-info" href="{{ route('konfirmasi.peminjaman.show', $data->id) }}"
                                        title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <input type="text" hidden value="{{$data->jumlah}}" id="jumlah">
                                    <input type="text" hidden value="{{$data->barang->stock}}" id="stok">
                                    @if ($data->status == 3)
                                    <a href="{{ route('konfirmasi.peminjaman.status', ['id_peminjaman' => $data->id, 'status' => 4,'barang_id' => $data->barang_id, 'jumlah' => $data->jumlah, 'user_id' => $data->user_id]) }}"
                                        class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                        title="Barang diterima">
                                        <i class="fas fa-dolly-flatbed"></i>
                                    </a>
                                    @else
                                    <a href="#"
                                        class="btn btn-secondary" data-toggle="tooltip" data-placement="top"
                                        title="Barang diterima">
                                        <i class="fas fa-dolly-flatbed"></i>
                                    </a>
                                    @endif
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
                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">Jika anda yakin ingin manghapus, Tekan Oke !!</div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                    Oke
                </a>
                <form id="user-delete-form" method="POST" action="{{ route('peminjaman.destroy',$data->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_id" id="delete_id">
                    <input type="hidden" name="brg_jml" id="brg_jml">
                    <input type="hidden" name="brg_stok" id="brg_stok">
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar User</li>
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
    $(document).on('click', '.delete-btn',function () {
            var sid = $(this).val();
            var jml = $('#jumlah').val();
            var stk = $('#stok').val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
            $('#brg_jml').val(jml)
            $('#brg_stok').val(stk)
        });
</script>
@endsection
