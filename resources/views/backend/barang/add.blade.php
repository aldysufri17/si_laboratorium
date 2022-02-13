@extends('backend.layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang</h1>
        <a href="{{route('barang.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
    </div>

    {{-- Alert Messages --}}
    @include('backend.common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Barang Baru</h6>
        </div>
        <form method="POST" action="{{route('barang.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('name') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Nama" 
                            name="name" 
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input 
                            type="number" min="0" max="10000"
                            class="form-control form-control-user @error('jumlah') is-invalid @enderror" 
                            id="exampleJumlah"
                            placeholder="Jumlah" 
                            name="jumlah" 
                            value="{{ old('jumlah') }}">

                        @error('jumlah')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Satuan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Satuan</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('satuan') is-invalid @enderror" 
                            id="exampleSatuan"
                            placeholder="Satuan" 
                            name="satuan" 
                            value="{{ old('satuan') }}">

                        @error('satuan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tgl Masuk --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tgl.Masuk</label>
                        <input 
                            type="date" 
                            class="form-control form-control-user @error('tgl_masuk') is-invalid @enderror" 
                            id="exampleTglMasuk"
                            placeholder="Tgl.Masuk" 
                            name="tgl_masuk" 
                            value="{{ old('tgl_masuk') }}">

                        @error('tgl_masuk')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('barang.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>


@endsection