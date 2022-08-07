@extends('backend.layouts.app')

@section('title', 'Tambah Role')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Role</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Tambah Role</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('roles.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body ">

                <div class="row">
                    {{-- kode --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" placeholder="Nama Role" name="name">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Name --}}
                        <input name="guard_name" value="web">
                </div>
                <div class="card-footer bgdark border-0">
                    <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                    <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('roles.index') }}">Batal</a>
                </div>
        </form>
    </div>
</div>
@endsection
