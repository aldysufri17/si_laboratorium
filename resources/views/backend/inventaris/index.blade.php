@extends('backend.layouts.app')

@section('title', 'Inventaris Barang')

@section('content')
@if ($inventaris->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Inventaris Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Inventaris Barang</li>
        </ol>
    </div>
    @role('operator')
    <div class="d-sm-flex align-items-center mb-4">

        {{-- <a href="{{ route('inventaris.add', auth()->user()->role_id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Inventaris
        </a> --}}
        <a href="{{ route('export.inventaris', 0) }}" class="btn btn-sm btn-warning mx-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('inventaris.pdf',0) }}" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-file-export"></i> Export PDF
        </a>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                @role('operator')
                <div class="my-2">
                    <form action="{{route('inventaris.index')}}" method="GET">
                        @csrf
                        <h6 class="mb-0 my-3 text-warning">* Filter Berdasarkan Tanggal Inventaris</h6>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" value="{{Request::get('start_date')}}" name="start_date">
                            <input type="date" class="form-control" value="{{Request::get('end_date')}}" name="end_date">
                            <button class="btn btn-primary" type="submit">Filter</button>
                            @if (Request::get('start_date') != "" || Request::get('end_date') != "")
                            <a class="btn btn-warning" href="/inventaris">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>
                @endrole
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    @role('operator')
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th width="15%">Kode Inventaris</th>
                            <th width="15%">Nama Barang</th>
                            <th width="5%">Baik</th>
                            <th width="5%">Rusak</th>
                            <th width="5%">Total</th>
                            <th width="20%">Pengadaan</th>
                            {{-- <th width="15%">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td>
                                <div class="col">
                                    <div class="row">{{$data->updated_at->format('d M Y')}}</div>
                                    <div class="row text-muted">
                                        <strong>({{$data->updated_at->format('H:i:s A')}})</strong></div>
                                </div>
                            </td>
                            <td>{{ $data->kode_inventaris }}</td>
                            <td>{{ $data->barang->nama }} - {{ $data->barang->tipe }}</td>
                            <td>{{ $data->total_inventaris }}</td>
                            @if ( $data->barang->jml_rusak == null)
                            <td>0</td>
                            @else
                            <td>{{ $data->barang->jml_rusak }}</td>
                            @endif
                            <td>{{ $data->total_inventaris + $data->barang->jml_rusak }}</td>
                            <td>{{$data->barang->pengadaan->nama_pengadaan}}</td>
                            {{-- <td style="display: flex">
                                @role('operator')
                                <a href="{{ route('inventaris.edit', $data->id) }}" class="btn btn-primary mx-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endrole
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                    @role('admin')
                    <thead>
                        <tr>
                            <th width="20%" class="text-center">Kategori</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventaris as $data)
                        <tr>
                            <td class="text-center">{{$data->nama}}</td>
                            {{-- <td class="text-center">{{ $data->total }}</td> --}}
                            <td class="d-sm-flex justify-content-center">
                                <a href="{{route('admin.inventaris', encrypt($data->id))}}" class="btn btn-primary"
                                    data-toggle="tooltip" data-placement="top" title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endrole
                </table>
                {{-- {{ $inventaris->links() }} --}}
            </div>
        </div>
    </div>
</div>
@role('operator')
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin
                    Menghapus?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">Jika anda yakin ingin manghapus, Tekan Oke
                !!</div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                    Oke
                </a>
                <form id="user-delete-form" method="POST" action="{{ route('inventaris.destroy', $data->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_id" id="delete_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endrole
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Inventaris Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Inventaris Barang</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    @role('operator')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
         @if (app('request')->input('start_date') || app('request')->input('start_date') )
         <a class="btn btn-sm btn-danger" href="{{route('inventaris.index')}}"><i class="fas fa-angle-double-left"></i> Tampilkan Semua Data</a>
         @endif
        <a href="{{ route('inventaris.add', auth()->user()->role_id)}}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Inventaris
        </a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Inventaris</p>
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
            "order": [[ 0, "desc" ]]
        });

    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
    });
});

</script>
@endsection
