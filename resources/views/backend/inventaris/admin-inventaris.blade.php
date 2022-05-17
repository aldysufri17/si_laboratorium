@extends('backend.layouts.app')

@section('title', 'Catatan Inventaris')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Catatan Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Catatan Inventaris</li>
        </ol>
    </div>
    <div class="d-sm-flex mb-4">
        <a class="btn btn-sm btn-danger" href="{{route('inventaris.index')}}"><i class="fas fa-angle-double-left"></i> Kembali</a>
        <a href="{{ route('export.inventaris', Request::route('data')) }}" class="btn btn-sm btn-warning mx-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('inventaris.pdf',Request::route('data')) }}" class="btn btn-sm btn-info">
            <i class="fa-solid fa-file-export"></i> Export PDF
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Catatan Inventaris</h6>
            <div class="table-responsive">
                <div class="my-2">
                    <form action="{{route('admin.inventaris', Request::route('data'))}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Tanggal Mutasi</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th width="15%">Kode Inventaris</th>
                            <th width="15%">Nama Barang</th>
                            <th width="5%">Baik</th>
                            <th width="5%">Rusak</th>
                            <th width="5%">Total</th>
                            <th width="20%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>
                                <div class="col">
                                    <div class="row">{{$data->created_at->format('d M Y')}}</div>
                                    <div class="row text-muted">
                                        <strong>({{$data->created_at->format('H:i:s A')}})</strong></div>
                                </div>
                            </td>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->stok }}</td>
                            @if ( $data->barang->jml_rusak == null)
                            <td>0</td>
                            @else
                            <td>{{ $data->barang->jml_rusak }}</td>
                            @endif
                            <td>{{ $data->stok + $data->barang->jml_rusak }}</td>
                            @if ($data->keterangan == null)
                            <td>-</td>
                            @else
                            <td>{{$data->keterangan}}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

</script>
@endsection
