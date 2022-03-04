@extends('backend.layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Surat Bebas Laboratoium</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/surat/bebas')}}">Persuratan</a></li>
            <li class="breadcrumb-item">Surat Bebas</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('surat.store')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    {{-- Tgl_start --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text"
                            class="form-control form-control-user @error('nama') is-invalid @enderror"
                            autocomplete="off" id="examplenama" placeholder="Nama" name="nama"
                            value="{{ old('nama') }}">

                        @error('nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tgl_end --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nim</label>
                        <input type="text"
                            class="form-control form-control-user @error('nim') is-invalid @enderror"
                            autocomplete="off" id="examplenim" placeholder="Nim" name="nim"
                            value="{{ old('nim') }}">

                        @error('nim')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jurusan</label>
                        <input type="text"
                            class="form-control  form-control-user @error('jurusan') is-invalid @enderror"
                            autocomplete="off" id="examplejurusan" autocomplete="off" placeholder="jurusan" name="jurusan" min="1"
                            value="{{ old('jurusan') }}">

                        @error('jurusan')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Cetak</button>
            </div>
        </form>
    </div>

</div>
@endsection
