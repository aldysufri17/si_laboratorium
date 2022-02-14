@extends('backend.layouts.app')

@section('title', 'Daftar Role')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Roles</h1>
    </div>

    {{-- Alert Messages --}}
    @include('backend.common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Role</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40%">ID</th>
                            <th width="40%">Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($roles as $role)
                           <tr>
                               <td>{{$role->id}}</td>
                               <td>{{$role->name}}</td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>

                {{$roles->links()}}
            </div>
        </div>
    </div>

</div>


@endsection