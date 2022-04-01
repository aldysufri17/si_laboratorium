@extends('frontend.layouts.app')
@section('content')
<main id="main">
    @if ($message = Session::get('eror'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Detail Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="portfolio.html">Daftar Barang</a></li>
                    <li>Detail Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->

    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-4 mb-4 bg-white rounded">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <a href="{{ asset($barang->gambar ? 'storage/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                            data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mb-3">
                            <img src="{{ asset($barang->gambar ? 'storage/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                                class="img-fluid" alt=""></a>
                            <span class="font-weight-bold">{{$barang->nama}} - {{$barang->tipe}}</span><span class="text-black-50">Stock :
                            {{$barang->stock}}</span><span>{{$barang->lokasi}}</span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <div class="d-flex flex-row align-items-center">
                                <h5>Form Penggunaan Barang</h5>
                                <hr>
                            </div>
                        </div>
                        <form action="{{route('peminjaman.store', $barang->id)}}" method="post">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <span>Jumlah</span>
                                    <input type="number"
                                        class="form-control mt-2 mb-3 @error('jumlah') is-invalid @enderror"
                                        placeholder="Jumlah" name="jumlah" min="1">
                                    @error('jumlah')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <span>Keperluan</span>
                                    <input type="text"
                                        class="form-control mt-2 mb-3 @error('alasan') is-invalid @enderror"
                                        placeholder="Keperluan" name="alasan">
                                    @error('alasan')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <span>Tanggal Penggunaan</span>
                                    <input type="date" class="form-control mt-2 mb-3" name="tgl_start">
                                </div>
                                <div class="col-md-6">
                                    <span>Tanggal Pengembalian</span>
                                    <input type="date" class="form-control mt-2 mb-3" name="tgl_end">
                                </div>
                            </div>

                            <div class="card-footer mt-5 border-0" style="background-color: rgba(0, 255, 255, 0)">
                                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('search') }}">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection
