@extends('backend.layouts.app')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#" onclick="history.back()">Filter Pengajuan</a></li>
            <li class="breadcrumb-item">Detail Peminjaman</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="#" onclick="history.back()"><i class="fas fa-angle-double-left"></i>
            Kembali</a>
    </div>
    <div class="card shadow mb-4 pb-4 border-0 bgdark">
        {{-- Page Content --}}
        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <h4 class="text-center font-weight-bold text-light">DETAIL PEMINJAMAN</h4>
            <img class="rounded-circle my-2" width="150px"
                src="{{ asset($peminjaman->user->foto ? 'images/barang/'. $peminjaman->user->foto : 'admin/img/undraw_profile.svg') }}">
            <span class="text-light">Nama : {{ $peminjaman->user->name }}</span>
            <p class="mt-2">Nim : {{ $peminjaman->user->nim }}</p>
        </div>
        <div class="d-flex justify-content-around flex-wrap mb-3">
            <table class="table mx-5 table-striped table-dark table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Nama Barang</th>
                        <td>{{ $peminjaman->barang->nama }} - {{ $peminjaman->barang->tipe }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Stok Barang Sekarang</th>
                        <td>{{ $peminjaman->barang->stock }} {{$peminjaman->barang->satuan->nama_satuan}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Jumlah Barang Pinjam</th>
                        <td>{{ $peminjaman->jumlah }} {{$peminjaman->barang->satuan->nama_satuan}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Peminjaman</th>
                        <td>{{ $peminjaman->tgl_start }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Pengembalian</th>
                        <td>{{ $peminjaman->tgl_end }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Alasan Pinjam</th>
                        <td>{{ $peminjaman->alasan }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-2 text-center">
            <button class="btn btn-info profile-button" data-toggle="modal" data-target="#ktmModal"><i class="fa-solid fa-address-card"></i> Lihat KTM</button>
            <button class="btn btn-primary profile-button" data-toggle="modal" data-target="#barangModal"><i class="fa-solid fa-box"></i> Lihat Barang</button>
        </div>
    </div>
</div>
<div class="modal fade" id="ktmModal" tabindex="-1" role="dialog" aria-labelledby="ktmModalLabel" aria-hidden="true">
    <div class="modal-dialog bgdark" role="document">
        <div class="modal-content bgdark">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="ktmModalLabel">KTM {{$peminjaman->user->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="my-2" width="350px"
                    src="{{ asset($peminjaman->user->ktm ? 'images/user/ktm/'. $peminjaman->user->ktm : 'images/empty.jpg') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog bgdark" role="document">
        <div class="modal-content bgdark">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="barangModalLabel">{{$peminjaman->barang->Nama}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="my-2" width="350px"
                    src="{{ asset($peminjaman->barang->gambar ? 'images/barang/'. $peminjaman->barang->gambar : 'images/empty.jpg') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
