@extends('backend.layouts.app')

@section('title', 'Edit Barang')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Edit Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart')}}">Keranjang Pengajuan</a></li>
            <li class="breadcrumb-item">Form Edit Barang</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 bgdark border-0">
        <form method="POST" action="{{route('barang.update', $barang->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-light">Edit Barang</h6>

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

                    <div class="row col-sm-6 mb-3 mt-3 pl-3 mr-2 mb-sm-0">
                        {{-- Jumlah --}}
                        <div class="col-sm-7">
                            <span style="color:red;">*</span>Stock</label>
                            <input readonly="true" type="number"
                                class="form-control form-control-user @error('stock') is-invalid @enderror"
                                autocomplete="off" id="examplestock" placeholder="Stock Barang" name="stock" min="1"
                                value="{{ old('stock') ? old('stock') : $barang->stock }}">

                            @error('stock')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        {{-- Satuan --}}
                        <div class="col-sm-5">
                            <span style="color:red;">*</span>Satuan</label>
                            <input type="text"
                                class="form-control form-control-user @error('satuan') is-invalid @enderror"
                                autocomplete="off" id="examplesatuan" placeholder="Satuan Barang" name="satuan"
                                value="{{ old('satuan') ? old('satuan') : $barang->satuan }}">

                            @error('satuan')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
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
                            <option value="1" @if($barang->show == 1) selected @endif>ya</option>
                            <option value="0" @if($barang->show == 0) selected @endif >Tidak</option>
                        </select>
                        @error('show')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    {{-- info --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Informasi Tambahan</label>
                            <textarea class="form-control @error('info') is-invalid @enderror"
                                id="exampleFormControlTextarea1" name="info" rows="3">{{$barang->info}}</textarea>
                        </div>
                        @error('info')
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
