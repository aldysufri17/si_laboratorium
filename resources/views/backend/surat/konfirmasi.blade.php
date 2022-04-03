@extends('backend.layouts.app')

@section('title', 'Konfirmasi Persuratan')

@section('content')

@if ($surat->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Konfirmasi Persuratan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Konfirmasi Persuratan</li>
        </ol>
    </div>

    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Konfirmasi Persuratan</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="15%">Tgl Masuk</th>
                            <th width="20%">Nama</th>
                            <th width="15%">NIM</th>
                            <th width="20%">Email</th>
                            <th width="15%">No Telepon</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat as $data)
                        <tr>
                            <td>{{$data->created_at}}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->user->nim }}</td>
                            <td>{{ $data->user->email }}</td>
                            <td>{{ $data->user->mobile_number }}</td>
                            <td>
                                <a href="{{ route('persuratan.status', ['id' => $data->id, 'status' => 1]) }}" title="Reject"
                                    class="btn btn-danger">
                                    <i class="fa fa-ban"></i>
                                </a>
                                <a href="{{ route('persuratan.status', ['id' => $data->id, 'status' => 2]) }}" title="Accept"
                                    class="btn btn-success">
                                    <i class="fa fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $surat->links() }}
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Konfirmasi Persuratan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Konfirmasi Persuratan</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Surat</p>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false
        });
    });

</script>
@endsection
