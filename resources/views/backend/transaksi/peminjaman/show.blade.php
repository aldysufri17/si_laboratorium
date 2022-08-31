@extends('backend.layouts.app')

@section('title', 'Daftar Keranjang')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.peminjaman')}}">Daftar Peminjam</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">Kode Peminjaman</th>
                            <th width="10%" class="text-center">Jumlah Barang</th>
                            <th width="15%" class="text-center">Pengembalian Telat</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                        <tr>
                            <td class="text-center">{{ $item->kode_peminjaman }}</td>
                            {{-- <td class="text-center">{{ $item->nama_keranjang }}</td> --}}
                            <td class="text-center">{{ $item->total }}</td>
                            @php
                            $datetime = new \Carbon\Carbon($item->created_at);
                            $data = App\Models\Peminjaman::where('user_id',
                            $id)->where('kode_peminjaman',$item->kode_peminjaman)->first();
                            $start= \Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                            $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $late = $start->diffInDays($now);
                            @endphp
                            @if ($data->tgl_end < date('Y-m-d')) <td class="text-center"><span
                                    class="badge badge-danger">{{ $late.' '.'Hari' }}</span></td>
                                @else
                                <td class="text-center">-</td>
                                @endif
                                <td class="d-sm-flex justify-content-center">
                                    <a class="btn btn-primary mr-3"
                                        href="{{route('peminjaman.admin.detail', ['id'=>$id,'kode'=>encrypt($item->kode_peminjaman)])}}"
                                        title="Show">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{-- <button class="btn btn-danger delete-btn mx-2" title="Delete"
                                        value="{{$item->kode_peminjaman}}">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}
                                    <input type="text" id="id_user" hidden value="{{$id}}">
                                    @if ($data->status >= 3)
                                    <button class="btn btn-warning terima-btn" title="Barang diterima"
                                        value="{{$item->kode_peminjaman}}">
                                        <i class="fas fa-dolly-flatbed"></i>
                                    </button>
                                    @else
                                    <a href="#" class="btn btn-secondary" data-toggle="tooltip" data-placement="top"
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

{{-- Delete Modal --}}
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
                <form id="user-delete-form" method="POST" action="{{ route('peminjaman.destroy', ['id' => 0]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="deletekode" id="deletekode">
                    <input type="hidden" name="deleteuser_id" id="deleteuser_id">
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Terima Modal --}}
<div class="modal fade" id="terimaModal" tabindex="-1" role="dialog" aria-labelledby="terimaModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-light" id="terimaModalExample">Konfirmasi Pengembalian
                </h5>
                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-white">Tekan Oke untuk konfirmasi terima barang !!
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Batal</button>
                <form method="GET"
                    action="{{route('konfirmasi.status',['id'=> $id, 'kode' => encrypt($item->kode_peminjaman), 'status' => 4])}}">
                    @csrf
                    <input type="hidden" name="terimakode" id="terimakode">
                    <input type="hidden" name="terimauser_id" id="terimauser_id">
                    <input type="hidden" name="terimakategori_lab" id="terimakategori_lab">
                    <button class="btn btn-warning" type="submit">Oke</button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Keranjang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.peminjaman')}}">Daftar Peminjam</a></li>
            <li class="breadcrumb-item">Daftar Keranjang</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>
    @include('sweetalert::alert')
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
            responsive: true,
            autoWidth: false,
        });
    });

    $(document).on('click', '.delete-btn', function () {
        $('#deleteModal').modal('show')
        var sid = $(this).val();
        var uid = $('#id_user').val();
        $('#deletekode').val(sid)
        $('#deleteuser_id').val(uid)
    });
    
    $(document).on('click', '.terima-btn', function () {
        $('#terimaModal').modal('show')
        var sid = $(this).val();
        var uid = $('#id_user').val();
        var kid = $('#lab_kategori').val();
        $('#terimakode').val(sid)
        $('#terimauser_id').val(uid)
        $('#terimakategori_lab').val(kid)
    });

</script>
@endsection
