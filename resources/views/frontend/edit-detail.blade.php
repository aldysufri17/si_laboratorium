@extends('frontend.layouts.app')
@section('content')
@section('title', 'Edit Barang')

<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Edit Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li><a href="{{route('cart')}}">Keranjang Peminjaman</a></li>
                    <li>Edit Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->

    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-4 mb-4 bg-white rounded">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="d-flex flex-row align-items-center">
                        <h5>Form Edit Penggunaan Barang</h5>
                        <hr>
                    </div>
                </div>
                <form action="{{route('peminjaman.update', $datetime)}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <span>Tanggal Penggunaan</span>
                            <input type="date" class="form-control mt-2 mb-3" name="tgl_start"
                                value="{{old('tgl_start') ?? $peminjaman->tgl_start}}">
                        </div>
                        <div class="col-md-6">
                            <span>Tanggal Pengembalian</span>
                            <input type="date" class="form-control mt-2 mb-3" name="tgl_end"
                                value="{{old('tgl_end') ?? $peminjaman->tgl_end}}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <span>Keperluan</span>
                            <select class="form-control mt-2 mb-3 form-control-user" name="alasan">
                                <option disabled>Pilih Keperluan</option>
                                <option value="Praktikum" @if ($peminjaman->alasan == "Praktikum")selected
                                    @endif>Praktikum</option>
                                <option value="Penelitian" @if ($peminjaman->alasan == "Penelitian")selected
                                    @endif>Penelitian</option>
                                <option value="Lainnya" @if ($peminjaman->alasan == "Lainnya")selected @endif>Lainnya
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer mt-5 border-0" style="background-color: rgba(0, 255, 255, 0)">
                        <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                        <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('daftar.pinjaman') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection
