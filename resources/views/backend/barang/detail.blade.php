@extends('backend.layouts.app')
@section('title', 'Detail User')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('barang.index')}}">Barang</a></li>
            <li class="breadcrumb-item">Detail</li>
        </ol>
    </div>

    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <img class="rounded-circle my-2" width="150px" src="{{ asset($barang->gambar ? 'storage/barang/'. $barang->gambar : 'images/empty.jpg') }}">
            @if ($barang->show == 0)
            <span class="badge badge-danger">Hidden</span>
            @elseif ($barang->show == 1)
            <span class="badge badge-success">Show</span>
            @endif
        </div>
        <div class="d-flex text-center justify-content-around flex-wrap pt-5">
            <p class="text-light mx-5"><strong>Nama: </strong><br>{{ $barang->nama }}</p>
            <p class="text-light mx-5"><strong>Tipe: </strong><br>{{ $barang->tipe }}</p>
            <p class="text-light mx-5"><strong>Jumlah: </strong><br>{{ $barang->jumlah }} {{$barang->satuan}}</p>
            <p class="text-light mx-5"><strong>Lokasi Barang: </strong><br>{{ $barang->lokasi }}</p>
            <p class="text-light mx-5"><strong>Tanggal Masuk: </strong><br>{{ $barang->tgl_masuk }}</p>
            @if($barang->info)
                <p class="text-light mx-5"><strong>Info Tambahan: </strong><br>{{ $barang->info }}</p>
            @endif
        </div>
        <div class="pb-5 text-center">
            <button class="btn btn-info profile-button" onclick="history.back()">Oke</button>
        </div>
    </div>
</div>
@endsection
