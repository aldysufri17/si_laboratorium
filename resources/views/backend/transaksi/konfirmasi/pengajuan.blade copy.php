@extends('backend.layouts.app')

@section('title', 'Filter Pengajuan')

@section('content')

@if ($peminjaman->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Filter Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Filter Pengajuan</li>
        </ol>
    </div>

    {{-- Alert Messages --}}
    {{-- @include('backend.common.alert') --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">Tanggal Masuk</th>
                            <th width="15%" class="text-center">Jumlah</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                        <tr>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center">{{ $item->total }}</td>
                            <td class="d-sm-flex justify-content-center">
                                <button class="btn btn-primary detail-btn" title="Show">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-danger tolak-btn mx-2" title="Tolak" value="{{$item->created_at}}">
                                    <i class="fa fa-ban"></i>
                                </button>
                                <a href="" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Accept">
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
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalExample" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="detailModalExample">Pengajuan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">
                <div class="detail mb-2">
                    <table width="300">
                        <tr>
                            <td class="font-weight-bold">Keperluan</td>
                            <td>: Helll</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Peminjaman</td>
                            <td>: dsdd</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Pengembalian</td>
                            <td>: sdsd</td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr style="color: white">
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $datetime = new \Carbon\Carbon('2022-05-12 11:58:37');
                            $data = App\Models\Peminjaman::where('user_id',
                            auth()->user()->id)->where('status', 2)->first();
                            $data = App\Models\Peminjaman::where('user_id',
                            auth()->user()->id)->where('status', 2)->get();
                            @endphp
                            {{print_r($data)}}
                            {{-- @foreach ($data as $item)
                            <tr style="color: white">
                                <td>{{$item->kode_barang}}</td>
                            <td>{{$item->nama_barang}}</td>
                            <td>fdf</td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
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
        <h1 class="h5 mb-0 text-light">Filter Pengajuan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Filter Pengajuan</li>
        </ol>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": false,
            "searching": false,
            "bInfo": false,
        });
    });
    $(document).on('click', '.detail-btn', function() {
        var sid = $(this).val();
        $('#detailModal').modal('show')
        $('#peminjaman_id').val(sid)
    });
</script>
@endsection