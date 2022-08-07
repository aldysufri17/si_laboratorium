@extends('backend.layouts.app')

@section('title', 'Daftar Role')

@section('content')
<div class="container-fluid">
@if ($roles->IsNotEmpty())
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-light">Daftar Role</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card bgdark border-0 shadow mb-4">

        <div class="card-body bgdark border-0">
            <h6 class="m-0 font-weight-bold text-primary">Semua Role</h6>
            <div class="table-responsive">
                <table class="table table-borderless table-dark bgdark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40%">ID</th>
                            <th width="40%">Nama</th>
                            <th width="40%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td style="display: flex">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary mx-2"
                                    title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <button class="btn btn-danger delete-btn" href="#" data-toggle="modal" data-target="#deleteModal" 
                                    title="Delete" value="{{$role->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$roles->links()}}
            </div>
        </div>
    </div>
@else
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Role</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Daftar Role</li>
        </ol>
    </div>
    @include('sweetalert::alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Data Satuan</p>
    </div>
</div>
@endif
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });
    });

</script>
@endsection