@extends('frontend.layouts.app')
@section('title', 'Langkah Peminjaman')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Langkah Peminjaman Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
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
                    <p class="card-text text-justify">Login terlebih dahulu, yaitu dengan memasukan nim sebagai username dan kata sandi, untuk halaman login bisa di akses <a href="{{route('login')}}">disini</a> </p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/home.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 2</strong></h5>
                    <p class="card-text text-justify">Setelah berhasil login, maka akan menuju halaman utama pengguna, Kemudian pilih button cari barang, untuk mencari barang yang akan dipinjam.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/cari.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 3</strong></h5>
                    <p class="card-text text-justify">Gambar diatas adalah halaman daftar barang, yang mana terdapat puluhan barang yang tersedia berdasarkan laboratorium yang dipilih.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/form pengajuan.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 4</strong></h5>
                    <p class="card-text text-justify">Setelah memilih barang yang diinginkan, maka akan menuju halaman detail, pada halaman ini anda diwajibkan mengisi informasi seperti jumlah alat, keperluaan alat, tanggal pinjam dan tanggal kembali.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/cart logo.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 5</strong></h5>
                    <p class="card-text text-justify">Setelah mengisi informasi peminjaman, pilih icon keranjang untuk melihat daftar barang yang dipilih.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/keranjang.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 6</strong></h5>
                    <p class="card-text text-justify">Gambar diatas adalah halaman keranjang, yang mana terdapat daftar barang yang dipilih, tunggu hingga proses pengajuan diterima.</p>
                </div>
            </div>
            <div class="card mt-3" style="width: 25rem;">
                <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/print.png')}}" height="230px" alt="Card image cap">
                <div class="card-body">
                    <h5><strong>Langkah 7</strong></h5>
                    <p class="card-text text-justify">Setelah status peminjaman disetujui, maka peminjam harus melakukan cetak surat pemngajuan untuk melakukan peminjaman barang.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
