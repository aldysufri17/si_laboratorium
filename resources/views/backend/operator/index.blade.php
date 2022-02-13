@extends('backend.layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Operator Master</h1>
        <a href="{{ route('operator.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Baru
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('backend.common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Master</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="25%">Email</th>
                            <th width="15%">No.Telp</th>
                            <th width="15%">Role</th>
                            <th width="15%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile_number }}</td>
                            <td>{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</td>
                            <td>
                                @if ($user->status == 0)
                                <span class="badge badge-danger">Inactive</span>
                                @elseif ($user->status == 1)
                                <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td style="display: flex">
                                @if ($user->status == 0)
                                <a href="{{ route('sts', ['user_id' => $user->id, 'status' => 1]) }}"
                                    class="btn btn-success m-2">
                                    <i class="fa fa-check"></i>
                                </a>
                                @elseif ($user->status == 1)
                                <a href="{{ route('sts', ['user_id' => $user->id, 'status' => 0]) }}"
                                    class="btn btn-danger m-2">
                                    <i class="fa fa-ban"></i>
                                </a>
                                @endif
                                <a href="{{ route('operator.edit', ['operator' => $user->id]) }}"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
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

@include('backend.operator.delete-modal')

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
