@extends('backend.layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('daftar.peminjaman')}}">Filter Peminjaman</a></li>
            <li class="breadcrumb-item">Daftar Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center mb-4">
        <a class="btn btn-sm btn-danger" href="{{route('daftar.peminjaman')}}"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('export.peminjaman', Request::route('data')) }}" class="btn btn-sm btn-warning mx-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <div class="my-2">
                    <form action="{{route('admin.peminjaman', Request::route('data'))}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Tanggal Selesai Peminjaman</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            @if (Request::get('start_date') != "" || Request::get('end_date') != "")
                            <a class="btn btn-warning" href="{{route('daftar.peminjaman')}}">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Tanggal Selesai</th>
                            <th width="10%" class="text-center">Nim</th>
                            <th width="10%" class="text-center">Kode Peminjaman</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $result => $data)
                        <tr>
                            <td class="text-center">{{$data->updated_at->format('d M Y')}}
                                <strong class="text-muted">({{$data->updated_at->format('H:i:s A')}})</strong></td>
                            <td class="text-center">{{$data->user->nim}}</td>
                            <td class="text-center">{{$data->kode_peminjaman}}</td>
                            <td class="d-sm-flex justify-content-center">
                                <button class="btn btn-primary detail-btn" title="Show"
                                    value="{{$data->kode_peminjaman}}">
                                    <i class="fa fa-eye"></i>
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

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-light font-weight-bold" id="detailModalExample">
                    Tampilkan</h5>
                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="font-weight-bold mb-0 text-center">Detail Pinjaman</h6>
                <div class="detail mb-4">
                    <table class="table table-borderless t-user" cellspacing="0" width="100%">
                    </table>
                </div>
                <div class="text-center">
                    <div class="mt-3 mb-0">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="barang">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });
    $(document).ready(function () {
        $(document).on('click', '.close-mdl', function () {
            $('#detailModal').modal('hide')

        });
    });

    $(".detail-btn").click(function () {
        $('#detailModal').modal('show')
        var did = $(this).val();
        $.ajax({
            url: "{{ route('riwayat.detail') }}",
            type: "GET",
            data: {
                kode: did
            },
            success: function (data) {
                $('#barang').html(data.output);
                $('.t-user').html(data.user);
            }
        });
    });
</script>
@endsection
