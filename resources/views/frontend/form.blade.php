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
    @if ($message = Session::get('name'))
    <div class="alert alert-danger alert-dismissible shake" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    @if (session('errorr'))
    <div class="alert alert-error">
        {{ session('errorr') }}
    </div>
    @endif
    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow-sm mx-4 mb-4 bg-white rounded">
            <div class="row">
                <div class="col-md-4 border-right p-5">
                    <div class="text-center">
                        <h5>DAFTAR BARANG TERPILIH</h5>
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
                        <form method="POST" action="{{route('checkout.store')}}">
                            <input type="text" name="cart" id="cart" class="form-control"
                                value="" />
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <span style="color:red;">*</span>Nama Keranjang</label>
                                    <input type="text"
                                        class="form-control form-control-user @error('nama_keranjang') is-invalid @enderror"
                                        autocomplete="off" placeholder="Nama Keranjang" name="nama_keranjang"
                                        value="{{ old('nama_keranjang') }}">

                                    @error('nama_keranjang')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <span>Keperluan</span>
                                    <select class="form-control form-control-user @error('alasan') is-invalid @enderror"
                                        name="alasan">
                                        <option selected disabled>Pilih Keperluan</option>
                                        <option value="Praktikum">Praktikum</option>
                                        <option value="Penelitian">Penelitian</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('alasan')
                                    <span class="text-danger">{{ $message }}</span>
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
                                <button type="submit" id="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                                <a class="btn btn-danger float-right mr-3 mb-3" id="batal" href="/cart">Batal</a>
                            </div>
                        </form>
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

    document.getElementById("inp").addEventListener("click", function () {
        cart = @json($id_cart);
        cart.push(JSON.parse(localStorage.getItem('cart')));
        localStorage.setItem('cart', JSON.stringify(cart));
        dd = localStorage.getItem("cart");
        $('#cart').val(dd);
    });

    document.getElementById("batal").addEventListener("click", function () {
        localStorage.removeItem('cart');
    });
</script>
@endsection
