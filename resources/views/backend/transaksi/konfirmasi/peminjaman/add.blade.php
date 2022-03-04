@extends('backend.layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/konfirmasi-peminjaman')}}">Peminjaman</a></li>
            <li class="breadcrumb-item">Tambah Peminjaman</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('peminjaman.store')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    {{-- User --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Peminjam Terdaftar</label>
                        <select class="form-control form-control-user @error('user') is-invalid @enderror"
                            name="user">
                            <option selected disabled>Pilih Peminjam</option>
                            @foreach ($user as $data)
                            <option value="{{$data->id}}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                        @error('user')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Barang --}}
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

                    {{-- Tgl_start --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tanggal Mulai</label>
                        <input type="date"
                            class="form-control form-control-user @error('tgl_start') is-invalid @enderror"
                            autocomplete="off" id="exampleTgl_start" placeholder="Tanggal Mulai" name="tgl_start"
                            value="{{ old('tgl_start') }}">

                        @error('tgl_start')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tgl_end --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tanggal Selesai</label>
                        <input type="date"
                            class="form-control form-control-user @error('tgl_end') is-invalid @enderror"
                            autocomplete="off" id="exampleTgl_end" placeholder="Tanggal end" name="tgl_end"
                            value="{{ old('tgl_end') }}">

                        @error('tgl_end')
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
                    
                    {{-- Alasan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Alasan</label>
                            <textarea class="form-control @error('alasan') is-invalid @enderror" id="exampleFormControlTextarea1" name="alasan" rows="3"></textarea>
                        </div>

                        @error('alasan')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ url('/konfirmasi-peminjaman') }}">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection
