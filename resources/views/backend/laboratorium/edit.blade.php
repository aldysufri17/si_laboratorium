@extends('backend.layouts.app')

@section('title', 'Edit Laboratorium')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Edit Laboratorium</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Form Edit Laboratorium</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 bgdark border-0">
        <form method="POST" action="{{route('lab.update', $lab->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-light">Edit Laboratorium</h6>
                <div class="row">
                    {{-- kode --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode</label>
                        <input type="text" class="form-control form-control-user @error('kode') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" placeholder="Kode Laboratorium" value="{{$lab->kode}}" name="kode">
                        @error('kode')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" value="{{$lab->nama}}" placeholder="Nama Laboratorium" name="nama">
                        @error('nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('lab.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
