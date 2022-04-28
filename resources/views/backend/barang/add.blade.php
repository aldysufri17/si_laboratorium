@extends('backend.layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/barang')}}">Daftar Barang</a></li>
            <li class="breadcrumb-item">Tambah Barang</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('barang.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body ">
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
                            autocomplete="off" id="exampleNama" placeholder="Nama Barang" name="nama"
                            value="{{ old('nama') }}">

                        @error('nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tipe --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tipe</label>
                        <input type="text" class="form-control  form-control-user @error('tipe') is-invalid @enderror"
                            autocomplete="off" id="exampleTipe" autocomplete="off" placeholder="Tipe Barang" name="tipe"
                            value="{{ old('tipe') }}">

                        @error('tipe')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kategori</label>
                        <select class="form-control form-control-user @error('kategori_id') is-invalid @enderror"
                            name="kategori_id">
                            <option selected disabled>Pilih Kategori</option>
                            @foreach ($kategori as $data)
                            <option value="{{$data->id}}">{{ $data->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="row col-sm-6 mb-3 mt-3 pl-3 mr-2 mb-sm-0">
                        {{-- Jumlah --}}
                        <div class="col-sm-7">
                            <span style="color:red;">*</span>Jumlah</label>
                            <input type="number"
                                class="form-control form-control-user @error('stock') is-invalid @enderror"
                                autocomplete="off" id="examplestock" placeholder="Jumlah Barang" name="stock" min="1"
                                value="{{ old('stock') }}">

                            @error('stock')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- Satuan --}}
                        <div class="col-sm-5">
                            <span style="color:red;">*</span>Satuan</label>
                            <select class="form-control form-control-user @error('satuan_id') is-invalid @enderror"
                                name="satuan_id">
                                <option selected disabled>Pilih Satuan</option>
                                @foreach ($satuan as $data)
                                <option value="{{$data->id}}">{{ $data->nama_satuan }}</option>
                                @endforeach
                            </select>
                            @error('satuan_id')
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
                            value="{{ date('Y-m-d')}}">
                        @error('tgl_masuk')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lokasi Barang --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lokasi Barang</label>
                        <select class="form-control form-control-user  @error('lokasi') is-invalid @enderror"
                            name="lokasi" aria-label="Default select example">
                            <option selected disabled>Pilih Lokasi</option>
                            <option value="Laboratorium Sistem Tertanam dan
                                Robotika" @if (auth()->user()->role_id == 3) selected @endif >Laboratorium Sistem Tertanam dan Robotika</option>
                            <option value="Laboratorium Rekayasa Perangkat Lunak" @if (auth()->user()->role_id == 4) selected @endif>Laboratorium Rekayasa Perangkat Lunak
                            </option>
                            <option value="Laboratorium Jaringan dan Keamanan Komputer" @if (auth()->user()->role_id == 5) selected @endif>Laboratorium Jaringan dan
                                Keamanan Komputer</option>
                            <option value="Laboratorium Multimedia" @if (auth()->user()->role_id == 6) selected @endif>Laboratorium Multimedia</option>
                        </select>
                        @error('lokasi')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- keterangan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Pengadaan</label>
                        <select class="form-control form-control-user @error('pengadaan_id') is-invalid @enderror"
                            name="pengadaan_id">
                            <option selected disabled>Pilih Jenis Pengadaan</option>
                            @foreach ($pengadaan as $data)
                            <option value="{{$data->id}}">{{$data->nama_pengadaan}}</option>
                            @endforeach
                        </select>
                        @error('pengadaan_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tampil --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tampilkan</label>
                        <select class="form-control form-control-user @error('show') is-invalid @enderror" name="show">
                            <option selected disabled>Pilih Status</option>
                            <option value="1" selected>Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                        @error('show')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Informasi Tambahan</label>
                            <textarea class="form-control @error('info') is-invalid @enderror"
                                id="exampleFormControlTextarea1" name="info" rows="3"></textarea>
                        </div>
                        @error('info')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Gambar Barang --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
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
