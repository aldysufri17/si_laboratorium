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
        <a class="btn btn-sm btn-info mx-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import Exel</a>
        <a href="{{ route('users.export') }}" class="btn btn-sm btn-warning mr-3">
            <i class="fa-solid fa-file-csv"></i> Export Exel
        </a>
        <a href="{{ route('users.pdf') }}" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-file-export"></i> Export PDF
        </a>
    </div>
    @endrole

    {{-- Alert Messages --}}
    @include('sweetalert::alert')
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
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
                                <button class="btn btn-warning reset-btn ml-2" title="Reset" value="{{$user->id}}">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </button>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary mx-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <button class="btn btn-danger delete-btn" title="Delete" value="{{$user->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
        <a class="btn btn-sm btn-info mx-3" data-toggle="modal" data-target="#importModal">
            <i class="fa-solid fa-file-csv"></i> Import Exel</a>
    </div>
    @endrole
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Pengguna</p>
    </div>
</div>
@endif
@include('backend.users.user-modal')
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
            // alert(sid)
        });

        $(document).on('click', '.reset-btn', function () {
            var rid = $(this).val();
            $('#resetModal').modal('show')
            $('#reset_id').val(rid)
            // alert(sid)
        });
    });

</script>
@endsection
