@extends('frontend.layouts.app')
@section('content')
@section('title', 'Form Penggunaan Barang')

<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Form Penggunaan Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li><a href="{{route('search')}}">Daftar Barang</a></li>
                    <li>Form Penggunaan Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @if ($message = Session::get('eror'))
    <div class="alert alert-danger alert-dismissible shake" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-4 mb-4 bg-white rounded">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <a href="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                            data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mb-3">
                            @if (file_exists(public_path('/images/barang/' . $barang->gambar)))
                            <div class="img-hover-zoom">
                                <img src="{{ asset($barang->gambar ? 'images/barang/'. $barang->gambar : 'images/empty.jpg') }}"
                                    class="img-fluid" alt="">
                            </div>
                        </a>
                        @else
                        <img src="{{ asset('images/empty.jpg') }}" class="img-fluid" alt=""></a>
                        @endif
                        <span class="font-weight-bold">{{$barang->nama}} - {{$barang->tipe}}</span><span
                            class="text-black-50">Stok :
                            {{$barang->stock}} {{$barang->satuan->nama_satuan}}</span><span>{{$barang->lokasi}}</span>
                        <div class="d-flex mt-2">
                            @if($barang->kategori_id != 0)
                            <span class="badge badge-secondary">{{$barang->kategori->nama_kategori}}</span>
                            @endif
                            <span class="badge badge-success mx-3">Baik</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" style="padding-left: 0%">
                    <div class="d-sm-flex justify-content-start tab">
                        <button class="tablinks btn btn-sm" id="clickButton" onclick="openCity(event, 'London')">Form
                            Penggunaan
                            Barang</button>
                        <button class="tablinks btn btn-sm" onclick="openCity(event, 'Paris')">Antrian
                            Penggunaan</button>
                    </div>
                    <div id="London" class="tabcontent p-3 py-5">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <div class="d-flex flex-row align-items-center">
                                <h5>Form Penggunaan Barang</h5>
                                <hr>
                            </div>
                        </div>
                        <form action="{{route('keranjang.update', $barang->id)}}" method="post">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <span>Jumlah</span>
                                    <input type="number"
                                        class="form-control mt-2 mb-3 @error('jumlah') is-invalid @enderror"
                                        placeholder="Jumlah" name="jumlah" min="1" value="{{$keranjang->jumlah ? $keranjang->jumlah : ''}}">
                                    @error('jumlah')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <span>Keperluan</span>
                                    <select class="form-control form-control-user @error('alasan') is-invalid @enderror"
                                        name="alasan">
                                        <option selected disabled>Pilih Keperluan</option>
                                        <option value="Praktikum" @if($keranjang->alasan == "Praktikum") selected @endif >Praktikum</option>
                                        <option value="Penelitian" @if($keranjang->alasan == "Penelitian") selected @endif>Penelitian</option>
                                        <option value="Lainnya" @if($keranjang->alasan == "Lainnya") selected @endif>Lainnya</option>
                                    </select>
                                    @error('alasan')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <span>Tanggal Penggunaan</span>
                                    <input type="date" class="form-control mt-2 mb-3" name="tgl_start" value="{{$keranjang->tgl_start ? $keranjang->tgl_start : ''}}">
                                </div>
                                <div class="col-md-6">
                                    <span>Tanggal Pengembalian</span>
                                    <input type="date" class="form-control mt-2 mb-3" name="tgl_end" value="{{$keranjang->tgl_end ? $keranjang->tgl_end : ''}}">
                                </div>
                            </div>

                            <div class="card-footer mt-5 border-0" style="background-color: rgba(0, 255, 255, 0)">
                                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                                <a class="btn btn-danger float-right mr-3 mb-3"
                                    href="javascript:history.back()">Batal</a>
                            </div>
                        </form>
                    </div>
                    <div id="Paris" class="tabcontent p-3 py-5">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <div class="d-flex flex-row align-items-center">
                                <h5>Antrian Penggunaan {{$barang->nama}} - {{$barang->tipe}}</h5>
                                <hr>
                            </div>
                        </div>
                        @if ($peminjaman->IsNotEmpty())
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman as $peminjam)
                                    <tr>
                                        <th>{{$peminjam->user->nim}}</th>
                                        <th>{{$peminjam->user->name}}</th>
                                        <th>{{$peminjam->tgl_start}}</th>
                                        <th>{{$peminjam->tgl_end}}</th>
                                        <th>{{$peminjam->jumlah}} {{$peminjam->barang->satuan->nama_satuan}}</th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="align-items-center bg-light p-3 rounded" style="border-left: 3px solid blue">
                            <span class="">Oops!</span><br>
                            <p><i class="fa-solid fa-circle-info text-info"></i> {{$barang->nama}} - {{$barang->tipe}} Belum Ada yang
                                Pinjam</p>
                        </div>
                        @endif

                    </div>
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


    window.onload = window.onload = function () {
        document.getElementById('clickButton').click();
    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    setInterval(function () {
            document.getElementById('notif').click();
        }, 4000);
</script>
@endsection
