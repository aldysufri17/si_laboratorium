@extends('backend.layouts.app')

@section('title', 'Tambah Surat')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Surat Bebas Laboratoium</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/surat/bebas')}}">Persuratan</a></li>
            <li class="breadcrumb-item">Buat Surat Bebas</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('persuratan.store')}}">
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

                    {{-- nim --}}
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

                    {{-- Alamat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Alamat</label>
                        <input type="text"
                            class="form-control  form-control-user @error('alamat') is-invalid @enderror"
                            autocomplete="off" id="examplealamat" autocomplete="off" placeholder="Alamat" name="alamat" min="1"
                            value="{{ old('alamat') }}">

                        @error('alamat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- No Telp --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No.Telp</label>
                        <input type="text"
                            class="form-control  form-control-user @error('mobile_number') is-invalid @enderror"
                            autocomplete="off" id="examplemobile_number" autocomplete="off" placeholder="No_telp" name="mobile_number" value="{{ old('mobile_number') }}">

                        @error('mobile_number')
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
