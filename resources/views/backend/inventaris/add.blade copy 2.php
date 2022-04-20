@extends('backend.layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/inventaris')}}">Catatan Inventaris</a></li>
            <li class="breadcrumb-item">Tambah Inventaris</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('inventaris.store')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <select class="form-control form-control-user @error('barang') is-invalid @enderror"
                            name="barang">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $data)
                            <option value="{{$data->id}}">{{ $data->nama }} - {{ $data->tipe }}</option>
                            @endforeach
                        </select>
                        @error('barang')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status Barang</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror"
                            name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="1">Masuk</option>
                            <option value="0">Keluar</option>
                            <option value="2">Rusak</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input type="number"
                            class="form-control  form-control-user @error('jumlah') is-invalid @enderror"
                            autocomplete="off" id="examplejumlah" autocomplete="off" placeholder="Jumlah" name="jumlah" min="1"
                            value="{{ old('jumlah') }}">

                        @error('jumlah')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="exampleFormControlTextarea1" name="deskripsi" rows="3"></textarea>
                        </div>

                        @error('deskripsi')
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
