@extends('backend.layouts.app')

@section('title', 'Daftar Pengurus')

@section('content')
@if ($users->isNotEmpty())
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Daftar Pengurus</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Pengurus</li>
        </ol>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('operator.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Pengurus
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-light">Daftar Semua Pengurus</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="25%">Email</th>
                            <th width="15%">Role</th>
                            <th width="15%">Status</th>
                            <th width="15%">Detail</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</td>
                            <td>
                                @if ($user->status == 0)
                                <span class="badge badge-danger">Inactive</span>
                                @elseif ($user->status == 1)
                                <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td><a class="btn btn-info" href="{{ route('operator.show', ['operator' => $user->id]) }}"
                                    title="Show">
                                    <i class="fas fa-eye"></i>
                                </a></td>
                            <td style="display: flex">
                                @if ($user->status == 0)
                                <a href="{{ route('sts', ['user_id' => $user->id, 'status' => 1]) }}"
                                    class="btn btn-success mx-2" title="Inactive">
                                    <i class="fa fa-check"></i>
                                </a>
                                @elseif ($user->status == 1)
                                <a href="{{ route('sts', ['user_id' => $user->id, 'status' => 0]) }}"
                                    class="btn btn-danger mx-2" title="Active">
                                    <i class="fa fa-ban"></i>
                                </a>
                                @endif
                                <a class="btn btn-warning mx-2" data-toggle="modal" data-target="#reset"
                                    title="Reset Password"><i class="fa-solid fa-clock-rotate-left"></i></a>
                                <a href="{{ route('operator.edit', ['operator' => $user->id]) }}"
                                    class="btn btn-primary mx-2" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger mx-2" href="#" data-toggle="modal" data-target="#deleteModal"
                                    title="Delete">
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
    <div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="resetExample" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bgdark shadow-2-strong ">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light" id="resetExample">Anda yakin ingin reset password
                        {{$user->name}}?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body border-0 text-light">Jika anda yakin ingin Reset, Tekan Oke !!</div>
                <div class="modal-footer border-0">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('user-reset-form').submit();">
                        Oke
                    </a>
                    <form id="user-reset-form" method="POST"
                        action="{{ route('users.reset', ['user' => $user->id, 'name' => $user->name]) }}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="resetExample" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bgdark shadow-2-strong ">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light" id="resetExample">Anda yakin ingin reset password
                        {{$user->name}}?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body border-0 text-light">Jika anda yakin ingin Reset, Tekan Oke !!</div>
                <div class="modal-footer border-0">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('user-reset-form').submit();">
                        Oke
                    </a>
                    <form id="user-reset-form" method="POST"
                        action="{{ route('users.reset', ['user' => $user->id, 'name' => $user->name]) }}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('backend.operator.delete-modal')
    @else
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h5 mb-0 text-light">Pengurus</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Pengurus</li>
            </ol>
        </div>
        @include('sweetalert::alert')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Pengurus
            </a>
        </div>
        <div class="align-items-center bg-light p-3 border-left-success rounded">
            <span class="">Oops!</span><br>
            <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Pengurus</p>
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
