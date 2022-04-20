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
        <form method="POST" action="{{route('inventaris.update', $inventaris->kode_inventaris)}}">
            @csrf
            @method('PUT')
            <input type="text" hidden name="stock" value="{{$inventaris->barang->stock}}">
            <input type="text" hidden name="jml_rusak" value="{{$inventaris->barang->jml_rusak}}">
            <input type="text" hidden name="id_brg" value="{{$inventaris->barang->id}}">
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Inventaris</label>
                        <input type="text" readonly name="kode_inventaris" class="form-control form-control-user" value="{{$inventaris->kode_inventaris}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <input type="text" disabled class="form-control form-control-user" value="{{$inventaris->barang->nama}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Stok Barang Sekarang</label>
                        <input type="text" disabled class="form-control form-control-user" value="{{$inventaris->barang->stock}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Rusak Sekarang</label>
                        <input type="text" disabled class="form-control form-control-user" value="{{$inventaris->barang->jml_rusak ? $inventaris->barang->jml_rusak : 0}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status Barang</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror"
                            name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="1">Tambah Stok</option>
                            <option value="2">Barang Rusak</option>
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
