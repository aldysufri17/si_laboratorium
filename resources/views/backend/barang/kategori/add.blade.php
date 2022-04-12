@extends('backend.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Kategori</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Tambah Kategori</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('kategori.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body ">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" placeholder="Nama Kategori" name="nama"
                            value="{{ old('nama') }}">
                        @error('nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('kategori.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
