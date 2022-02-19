@extends('backend.layouts.app')

@section('title', 'Daftar Role')

@section('content')
<div class="container-fluid">

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