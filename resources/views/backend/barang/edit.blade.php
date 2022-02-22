@extends('backend.layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Edit Master</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/operator')}}">Master</a></li>
            <li class="breadcrumb-item">Form Edit Master</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 bgdark border-0">
        <form method="POST" action="{{route('barang.update', $barang->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-light">Edit Master</h6>

                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" placeholder="Nama Barang" name="nama"
                            value="{{ old('nama') ?  old('nama') : $barang->nama}}">

                        @error('nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tipe --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tipe</label>
                        <input type="text" class="form-control  form-control-user @error('tipe') is-invalid @enderror"
                            autocomplete="off" id="exampleTipe" autocomplete="off" placeholder="Tipe Barang" name="tipe"
                            value="{{ old('tipe') ? old('tipe') : $barang->tipe }}">

                        @error('tipe')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Berat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Berat</label>
                        <input type="text" class="form-control form-control-user @error('berat') is-invalid @enderror"
                            autocomplete="off" id="exampleBerat" placeholder="Berat Barang" name="berat"
                            value="{{ old('berat') ? old('berat') : $barang->berat }}">

                        @error('berat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tanggal masuk --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tanggal Masuk</label>
                        <input type="date"
                            class="form-control form-control-user @error('tgl_masuk') is-invalid @enderror"
                            autocomplete="off" id="exampleTgl_masuk" placeholder="Tanggal Masuk" name="tgl_masuk"
                            value="{{ old('tgl_masuk') ? old('tgl_masuk') : $barang->tgl_masuk }}">

                        @error('tgl_masuk')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lokasi Barang --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lokasi</label>
                        <input type="text" class="form-control form-control-user @error('lokasi') is-invalid @enderror"
                            autocomplete="off" id="exampleLokasi" placeholder="Lokasi Barang" name="lokasi"
                            value="{{ old('lokasi') ? old('lokasi') : $barang->lokasi }}">

                        @error('lokasi')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kondisi Barang --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kondisi</label>
                        <select class="form-control form-control-user @error('kondisi') is-invalid @enderror"
                            name="kondisi">
                            <option selected disabled>Pilih Kondisi</option>
                            <option value="1" @if($barang->kondisi == 1) selected @endif>Baru</option>
                            <option value="2" @if($barang->kondisi == 2) selected @endif >Bekas</option>
                            <option value="0" @if($barang->kondisi == 0) selected @endif>Rusak</option>
                        </select>
                        @error('kondisi')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Gambar Barang --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Gambar</label>
                        <input type="file" class="form-control"
                            value="{{old('gambar') ? old('gambar') : $barang->lokasi}}" name="gambar" id="gambar">
                    </div>

                    {{-- Tampil --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tampilkan</label>
                        <select class="form-control form-control-user @error('show') is-invalid @enderror" name="show">
                            <option selected disabled>Pilih Status</option>
                            <option value="1" @if($barang->kondisi == 1) selected @endif>ya</option>
                            <option value="0" @if($barang->kondisi == 2) selected @endif >Tidak</option>
                        </select>
                        @error('show')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('barang.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>


@endsection
