@extends('backend.layouts.app')

@section('title', 'Edit Barang Rusak')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Edit Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('barang.damaged')}}">Catatan Barang Rusak</a></li>
            <li class="breadcrumb-item">Edit Barang Rusak</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('damaged.update')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <input type="text" readonly class="form-control form-control-user"
                            value="{{$barang->nama}}">
                        @error('barang')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    @php
                    $id = App\Models\Inventaris::where('barang_id', $barang->id)->where('status', 2)->value('id');
                    @endphp
                    <input type="text" hidden id="id_inventaris" name="id_inventaris" value="{{$id}}">
                    <input type="text" hidden id="id_barang" name="id_barang" value="{{$barang->id}}">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Stok Barang Sekarang</label>
                        <input type="text" readonly class="form-control form-control-user" name="total_stok"
                            value="{{$barang->stock}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Rusak Sekarang</label>
                        <input type="text" id="rusak" readonly class="form-control form-control-user" name="total_rusak"
                            value="{{$barang->jml_rusak}}">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kategori</label>
                        <select id="select"
                            class="form-control selectpicker form-control-user @error('kategori') is-invalid @enderror"
                            name="kategori">
                            <option selected disabled>Pilih Barang</option>
                            <option value="1">Tambah Barang Rusak</option>
                            <option value="2">Kurangi Barang Rusak</option>
                            <option value="3">Kurangi Barang Rusak (Reparasi)</option>
                        </select>
                        @error('kategori')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input type="number"
                            class="form-control  form-control-user @error('jumlah') is-invalid @enderror"
                            autocomplete="off" id="inp" autocomplete="off" placeholder="Jumlah" name="jumlah" min="1"
                            value="{{ old('jumlah') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                        @error('jumlah')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                id="exampleFormControlTextarea1" name="keterangan" rows="3">{{$barang->keterangan_rusak}}</textarea>
                        </div>
                        @error('keterangan')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('barang.damaged') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
