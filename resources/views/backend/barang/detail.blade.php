@extends('backend.layouts.app')
@section('title', 'Detail Barang')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/barang')}}">Daftar Barang</a></li>
            <li class="breadcrumb-item">Detail Barang</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{route('barang.index')}}"><i class="fas fa-angle-double-left"></i> Kembali</a>
    </div>

    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <h4 class="text-center font-weight-bold text-light">DETAIL BARANG</h4>
            <img class="my-2" width="375px"
                src="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}">
                @if ($barang->show == 1)
                <span class="badge badge-success">Ditampilkan</span>
                @else
                <span class="badge badge-danger">Disembunyikan</span>
                @endif
        </div>
        <div class="d-flex justify-content-around flex-wrap">
            <table class="table mx-5 table-striped table-dark table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Nama</th>
                        <td>{{ $barang->nama }} - {{$barang->tipe}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Kategori</th>
                        <td>{{$barang->kategori->nama_kategori}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Stock</th>
                        <td>{{ $barang->stock }} {{ $barang->satuan->nama_satuan }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Lokasi Barang</th>
                        <td>{{ $barang->lokasi }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Masuk</th>
                        <td>{{ $barang->tgl_masuk }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Keterangan</th>
                        @if($barang->info == 1)
                        <td>Barang Inventaris</td>
                        @elseif($barang->info == 2)
                        <td>Barang Habis Pakai</td>
                        @elseif($barang->info == 3)
                        <td>Barang Hibah</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pb-5 text-center">
            <button class="btn btn-info profile-button" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-qrcode"></i> QrCode</button>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bgdark">
                    <h5 class="modal-title text-light">Qr Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center bgdark">
                    @php
                    $qr = 'Kode = '.$barang->kode_barang . ' - '. 'Nama = '. $barang->nama .' '. $barang->tipe .' - '. 'Lokasi = '. $barang->lokasi
                    @endphp
                    <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(strval($qr), 'QRCODE',5,5)}}" style="background-color: rgb(255, 255, 255); padding:5px; border-radius:1px" alt="barcode" />
                </div>
                <div class="modal-footer bgdark">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
