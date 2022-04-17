@extends('frontend.layouts.app')
@section('title', 'Langkah Peminjaman')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Langkah Peminjaman Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Langkah Peminjaman Barang</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    <div class="container-fluid">
        {{-- Alert Messages --}}
        @include('sweetalert::alert')
        <div class="d-flex justify-content-between flex-wrap mx-5 my-4">
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/login.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 1</strong></h5>
                    <p class="card-text text-justify">Login terlebih dahulu, yaitu dengan memasukan email dan kata
                        sandi, untuk halaman login bisa di akses <a href="{{route('login')}}">disini</a> </p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/home.png')}}" height="230px"
                    alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 2</strong></h5>
                    <p class="card-text text-justify">Setelah berhasil login, maka akan menuju halaman utama pengguna,
                        Kemudian pilih button cari barang, untuk mencari barang yang akan dipinjam.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/cari.png')}}" height="230px"
                    alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 3</strong></h5>
                    <p class="card-text text-justify">Gambar diatas adalah halaman daftar barang, Cari barang yang anda
                        inginkan berdasarkan kategori laboratorium yang tersedia.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/form pengajuan.png')}}" height="230px"
                    alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 4</strong></h5>
                    <p class="card-text text-justify">Setelah memilih barang yang diinginkan, maka akan menuju halaman
                        detail, pada halaman ini anda diwajibkan mengisi informasi seperti jumlah alat, keperluaan alat,
                        tanggal pinjam dan tanggal kembali.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/keranjang.png')}}" height="230px"
                    alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 5</strong></h5>
                    <p class="card-text text-justify">Setelah mengisi informasi peminjaman, Peminjam akan diarahkan ke
                        halaman keranjang, Gambar diatas adalah halaman keranjang, yang mana terdapat daftar barang yang
                        dipilih, tunggu hingga status pengajuan disetujui operator laboratorium terkait.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/print.png')}}" height="230px"
                    alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 6</strong></h5>
                    <p class="card-text text-justify">Setelah status peminjaman disetujui, maka peminjam harus melakukan
                        unduh surat peminjaman untuk melakukan aktivasi peminjaman barang ke operator laboratorium
                        terkait.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <center><img class="card-img-top p-2" src="{{asset('frontend/img/langkah/surat.png')}}" height="230px"
                        style="width: 250px" alt="Card image cap">
                    <div class="card-body">
                </center>
                <h5><strong>Langkah 7</strong></h5>
                <p class="card-text text-justify">Setelah melakukan unduh surat peminjaman, peminjam harus menunjukkan surat tersebut kepada operator laboratorium terkait untuk dilakukan aktivasi peminjaman dan pengambilan barang pinjaman</p>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
