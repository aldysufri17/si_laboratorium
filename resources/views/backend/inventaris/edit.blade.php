@extends('backend.layouts.app')

@section('title', 'Edit Inventaris')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Edit Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/inventaris')}}">Catatan Inventaris</a></li>
            <li class="breadcrumb-item">Edit Inventaris</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('inventaris.update', $inventaris->id)}}">
            @csrf
            @method('PUT')
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Inventaris</label>
                        <input type="text" name="kode_inventaris" class="form-control form-control-user @error('kode_inventaris') is-invalid @enderror" value="{{$inventaris->kode_inventaris}}">
                        @error('kode_inventaris')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                id="exampleFormControlTextarea1" name="keterangan" rows="3">{{$inventaris->keterangan}}</textarea>
                        </div>
                        @error('keterangan')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('inventaris.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>


@endsection
