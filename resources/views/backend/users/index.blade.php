@extends('backend.layouts.app')

@section('title', 'Daftar User')

@section('content')

@if ($users->isNotEmpty())
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">User</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar User</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>

    {{-- Alert Messages --}}
    {{-- @include('backend.common.alert') --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua User</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="15%">NIM</th>
                            <th width="25%">Email</th>
                            <th width="15%">Status</th>
                            <th width="15%">Detail</th>
                            <th width="10%">Aksi</th>
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
                            <td><a class="btn btn-info" href="{{ route('users.show', ['user' => $user->id]) }}">
                                <i class="fas fa-eye"></i>
                            </a></td>
                            <td style="display: flex">
                                @if ($user->status == 0)
                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 1]) }}"
                                    class="btn btn-success">
                                    <i class="fa fa-check"></i>
                                </a>
                                @elseif ($user->status == 1)
                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 0]) }}"
                                    class="btn btn-danger">
                                    <i class="fa fa-ban"></i>
                                </a>
                                @endif
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary mx-2">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@include('backend.users.delete-modal')
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">User</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar User</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data User</p>
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
