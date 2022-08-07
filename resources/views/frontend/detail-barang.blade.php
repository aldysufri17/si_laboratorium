@extends('frontend.layouts.app')
@section('content')
@section('title', 'Detail Barang')

<main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Detail Barang</h2>
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{route('search')}}">Daftar Barang</a></li>
                    <li>Detail Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @if ($message = Session::get('stock'))
    <div class="alert alert-danger alert-dismissible shake" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    @if ($message = Session::get('max'))
    <div class="alert alert-danger alert-dismissible shake" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif

    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-5 bg-white rounded">
            <div class="d-sm-flex justify-content-between mb-2 p-2">
                <button type="button" onclick="javascript:history.back()"
                    class="btn btn-danger btn-user float-right mb-3"> <i class="fas fa-angle-double-left"></i>
                    Kembali</button>
                {{-- <form action="{{route('cart.store', ['id' => $barang->id])}}">
                <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                        class="fas fa-cart-plus"></i> Tambah</button>
                </form> --}}
                @if (Auth::check())
                <button type="button" id="jumlah" class="btn btn-success btn-user float-right mb-3">
                    <i class="fas fa-cart-plus"></i> Tambah</button>
                @endif
            </div>
            <div class="card-body px-4">
                <div class="d-flex flex-column align-items-center mb-3 text-center">
                    <h5 class="font-weight-bold">DETAIL BARANG</h5>
                    <a href="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                        data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mb-3">
                        @if (file_exists(public_path('/images/barang/' . $barang->gambar)))
                        <div class="img-hover-zoom">
                            <img width="300px"
                                src="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
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
                                <td class="">{{$barang->laboratorium->nama}}</td>
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
                                <th scope="row">Jenis Pengadaan</th>
                                <td>{{$barang->pengadaan->nama_pengadaan}}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<div class="modal fade" id="jumlahModal" tabindex="-1" role="dialog" aria-labelledby="jumlahModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-light" id="jumlahModalExample">Masukkan Jumlah Barang</h5>
                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('cart.store', ['id' => $barang->id])}}">
                <div class="modal-body border-0 text-dark">
                    <div class="col-md-12">
                        <span>Jumlah</span>
                        <input type="number" min="1" class="form-control mt-2 mb-3" name="jumlah" id="inp" value="1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" id="off" class="btn btn-success">Oke</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    $(document).on('click', '#jumlah', function () {
        $('#jumlahModal').modal('show')
        // alert('heho');
    });
    $(document).on('click', '.close-mdl', function () {
        $('#jumlahModal').modal('hide')

    });

    document.getElementById("inp").addEventListener("change", function() {
        let v = parseInt(this.value);
        if (v < 1) this.value = 1;
    });

</script>
@endsection
