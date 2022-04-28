@extends('frontend.layouts.app')
@section('content')
@section('title', 'Detail Barang')

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
                <h2 class="font-weight-bold">Detail Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li><a href="{{route('search')}}">Daftar Barang</a></li>
                    <li>Detail Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->

    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-5 bg-white rounded">
            <div class="d-sm-flex justify-content-between mb-2 p-2">
                <button type="button" onclick="javascript:history.back()" class="btn btn-danger btn-user float-right mb-3"> <i class="fas fa-angle-double-left"></i> Kembali</button>
                <form action="{{route('cart.store', ['id' => $barang->id])}}">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i class="fas fa-cart-plus"></i> Tambah</button>
                </form>
            </div>
            <div class="card-body px-4">
                <div class="d-flex flex-column align-items-center mb-3 text-center">
                    <h5 class="font-weight-bold">DETAIL BARANG</h5>
                    <a href="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                        data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mb-3">
                        @if (file_exists(public_path('/images/barang/' . $barang->gambar)))
                        <div class="img-hover-zoom">
                            <img width="300px" src="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                                class="img-fluid" alt="">
                        </div>
                    </a>
                    @else
                    <img src="{{ asset('images/empty.jpg') }}" class="img-fluid" alt=""></a>
                    @endif
                    <span class="font-weight-bold">{{$barang->nama}} - {{$barang->tipe}}</span>
                    <div class="d-flex mt-2">
                        @if($barang->kategori_id != 0)
                        <span class="badge badge-primary">{{$barang->kategori->nama_kategori}}</span>
                        @endif
                        <span class="badge badge-success mx-3">Baik</span>
                    </div>
                </div>
                <div class="d-flex justify-content-around flex-wrap">
                    <table class="table mx-5 table-striped table-light table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Kategori Laboratorium</th>
                                <td class="">
                                    @if ($barang->kategori_lab == 1)
                                    Laboratorium Sistem Tertanam dan Robotika
                                    @elseif ($barang->kategori_lab == 2)
                                    Laboratorium Rekayasa Perangkat Lunak
                                    @elseif($barang->kategori_lab == 3)
                                    Laboratorium Jaringan dan Keamanan Komputer
                                    @elseif($barang->kategori_lab == 4)
                                    Laboratorium Multimedia
                                    @endif</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $barang->nama }} - {{$barang->tipe}}</td>
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
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection

@section('script')
<script>
    $('#dataTable').DataTable({
        "bInfo": false,
        "paging": false,
        responsive: true,
        autoWidth: false,
        "order": [
            [0, "desc"]
        ]
    });

</script>
@endsection
