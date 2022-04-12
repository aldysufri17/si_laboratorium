@extends('backend.layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')

@if ($users->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Pengguna</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Pengguna</li>
        </ol>
    </div>
    @role('admin')
    <div class="d-sm-flex align-items-center mx-3 mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
        <a class="btn btn-sm btn-secondary mx-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import .csv</a>
        <a href="{{ route('users.export') }}" class="btn btn-sm btn-warning">
            <i class="fa-solid fa-file-csv"></i> Export .csv
        </a>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Pengguna</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="15%">NIM</th>
                            <th width="25%">Email</th>
                            <th width="15%">Status</th>
                            <th width="10%">Detail</th>
                            @role('admin')
                            <th width="10%">Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->status == 0)
                                <span class="badge badge-danger">Inactive</span>
                                @elseif ($user->status == 1)
                                <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td><a class="btn btn-info" href="{{ route('users.show', ['user' => $user->id]) }}"
                                    title="Show">
                                    <i class="fas fa-eye"></i>
                                </a></td>
                            @role('admin')
                            <td style="display: flex">
                                @if ($user->status == 0)
                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 1]) }}"
                                    title="Inactive" class="btn btn-success">
                                    <i class="fa fa-check"></i>
                                </a>
                                @elseif ($user->status == 1)
                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 0]) }}"
                                    title="Active" class="btn btn-danger">
                                    <i class="fa fa-ban"></i>
                                </a>
                                @endif
                                <a class="btn btn-warning ml-2" data-toggle="modal" data-target="#reset"
                                    title="Reset Password"><i class="fa-solid fa-clock-rotate-left"></i></a>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary mx-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@include('backend.users.user-modal')
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Pengguna</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Pengguna</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    @role('admin')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
        <a class="btn btn-sm btn-secondary mx-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import .csv</a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Pengguna</p>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <strong><h5 class="modal-title text-light" id="importModalExample">IMPORT PENGGUNA</h5></strong>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">
                <center>
                    <h5>Format Import Data</h5>
                    <h6 style="color: rgb(255, 82, 82)">Pastikan data tidak ada yang sama..!!!</h6>
                    <img src="https://i.ibb.co/FBbJxxD/user.png" width="390px" class="mb-3" alt="user" border="1">
                </center>
                <form action="{{route('users.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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
