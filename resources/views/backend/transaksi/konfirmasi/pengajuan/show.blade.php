@extends('backend.layouts.app')

@section('title', 'Daftar Keranjang')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Keranjang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.pengajuan')}}">Daftar Pengajuan</a></li>
            <li class="breadcrumb-item">Daftar Keranjang</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.pengajuan') }}" class="btn btn-sm btn-danger">
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
                            
                            <th width="10%" class="text-center">Waktu Pengajuan</th>
                            <th width="10%" class="text-center">Kode Peminjaman</th>
                            <th width="15%" class="text-center">Jumlah Barang</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                        <tr>
                            <td >
                                <div class="col">
                                    <div class="row">{{$item->created_at->format('d M Y')}}</div>
                                    <div class="row text-muted">
                                        <strong>({{$item->created_at->format('H:i:s A')}})</strong></div>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->kode_peminjaman }}</td>
                            {{-- <td class="text-center" style="text-transform: uppercase">{{ $item->kode_peminjaman }}</td> --}}
                            <td class="text-center">{{ $item->total }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <a class="btn btn-primary"
                                    href="{{route('pengajuan.detail', ['id'=>$id,'kode'=>$item->kode_peminjaman])}}"
                                    title="Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button class="btn btn-danger tolak-btn mx-2" title="Tolak" value="{{$item->kode_peminjaman}}">
                                    <i class="fa fa-ban"></i>
                                </button>
                                <input type="text" id="id_user" hidden value="{{$id}}">
                                <a href="{{route('konfirmasi.status',['id'=> $id, 'kode' => $item->kode_peminjaman, 'status' => 2])}}"
                                    class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Setujui">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Tolak Delete --}}
<div class="modal fade" id="tolakModal" tabindex="-1" role="dialog" aria-labelledby="tolakModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="tolakModalExample">Anda yakin ingin
                    Menghapus?
                </h5>
                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="GET" action="{{ route('peminjaman.tolak') }}">
                @csrf
                <div class="modal-body border-0 text-dark">
                    <input type="text" class="form-control form-control-user" placeholder="Tambahkan alasan penolakan"
                        name="pesan">
                    <input type="hidden" name="kode" id="kode_id">
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Oke</button>
                </div>
            </form>
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
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.pengajuan')}}">Daftar Pengajuan</a></li>
            <li class="breadcrumb-item">Daftar Keranjang</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.pengajuan') }}" class="btn btn-sm btn-danger">
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
    $(document).on('click', '.tolak-btn', function () {
        var sid = $(this).val();
        var uid = $('#id_user').val();
        $('#tolakModal').modal('show')
        $('#kode_id').val(sid)
        $('#user_id').val(uid)
    });

</script>
@endsection
