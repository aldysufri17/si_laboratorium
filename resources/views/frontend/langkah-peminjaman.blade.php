@extends('frontend.layouts.app')
@section('title', 'Langkah Peminjaman')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Langkah Penggunaan Sistem</h2>
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li>Langkah Penggunaan Sistem</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    <div class="container-fluid" style="margin: 0; padding:0">
        {{-- Alert Messages --}}
        @include('sweetalert::alert')
        <div class="d-sm-flex tab">
            <button class="tablinks btn btn-sm" id="clickButton" onclick="openCity(event, 'London')">Langkah Peminjaman
                Barang</button>
            <button class="tablinks btn btn-sm" onclick="openCity(event, 'Paris')">Langkah Pembuatan Surat Bebas
                Lab</button>
        </div>
        <div id="London" class="tabcontent">
            <div class="d-flex justify-content-center align-items-center my-2">
                <div class="d-flex flex-row align-items-center">
                    <h5 class="font-weight-bold">LANGKAH PEMINJAMAN BARANG</h5>
                    <hr>
                </div>
            </div>
            <div class=" d-flex justify-content-between flex-wrap">
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/login.png')}}"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 1</strong></h5>
                        <p class="card-text text-justify">Login terlebih dahulu, yaitu dengan memasukan email dan
                            kata
                            sandi, untuk halaman login bisa di akses <a href="{{route('login')}}">disini</a> </p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/home.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 2</strong></h5>
                        <p class="card-text text-justify">Setelah berhasil login, maka akan menuju halaman utama
                            pengguna,
                            Kemudian pilih button <strong> Cari Barang</strong>, untuk melihat data barang.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/cari.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 3</strong></h5>
                        <p class="card-text text-justify">Gambar diatas adalah halaman daftar barang, Cari barang
                            yang anda
                            inginkan berdasarkan kategori laboratorium yang diinginkan.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/detail.png')}}"
                        height="230px" alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 4</strong></h5>
                        <p class="card-text text-justify">Setelah memilih barang yang diinginkan, maka akan menuju
                            halaman detail, pada halaman ini berisi detail dari barang yang dipilih, untuk menambahkan barang ke keranjang pilih tombol tambah.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/cart.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 5</strong></h5>
                        <p class="card-text text-justify">Barang akan ditambahkan kedalam keranjang pengajuan, checkout untuk melakukan pengajuan</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/form.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 6</strong></h5>
                        <p class="card-text text-justify">Anda diharuskan mengisi formulir penggunaan barang untuk melakukan pengajuan, Setelah mengisi formulir pilih tombol simpan</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/pengajuan.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 7</strong></h5>
                        <p class="card-text text-justify">Setelah anda mengisi formulir penggunaan, barang yang anda pilih akan ditambahkan pada daftar pengajuan dengan status dalam proses, tunggu hingga status pengajuan disetujui operator terkait.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/setujui.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 8</strong></h5>
                        <p class="card-text text-justify">Setelah pengajuan anda disetujui, anda bisa melakukan cetak surat peminjaman pada halaman detail peminjaman.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <center><img class="card-img-top p-2" src="{{asset('frontend/img/langkah/surat.png')}}"
                            height="230px" style="width: 250px" alt="Card image cap"></center>
                    <div class="card-body">
                        <h5><strong>Surat Peminjaman</strong></h5>
                        <p class="card-text text-justify">Surat peminjaman dapat digunakan ketika melakukan pengembalian barang.</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/aktif.png')}}"
                            height="230px" alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 9</strong></h5>
                        <p class="card-text text-justify">Setelah peminjaman selesai, akan tersedia tombol pengajuan pengembalian barang, yang dapat anda gunakan untuk melakukan pengembalian barang.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="Paris" class="tabcontent">
            <div class="d-flex justify-content-center align-items-center my-2">
                <div class="d-flex flex-row align-items-center">
                    <h5 class="font-weight-bold">LANGKAH PEMBUATAN SURAT BEBAS LAB</h5>
                    <hr>
                </div>
            </div>
            <div class=" d-flex justify-content-between flex-wrap">
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/login.png')}}"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 1</strong></h5>
                        <p class="card-text text-justify">Login terlebih dahulu, yaitu dengan memasukan email dan
                            kata
                            sandi, untuk halaman login bisa di akses <a href="{{route('login')}}">disini</a> </p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/1.png')}}" alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 2</strong></h5>
                        <p class="card-text text-justify">Setelah berhasil login, maka akan menuju halaman utama
                            pengguna,
                            Kemudian pilih button dropdown foto profil kemudian pilih surat bebas lab .</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/2.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 3</strong></h5>
                        <p class="card-text text-justify">Gambar diatas merupakan halaman pengajuan surat bebas lab,
                            untuk melakukan pengajuan klik button Buat surat</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/3.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 4</strong></h5>
                        <p class="card-text text-justify">Setelah melakukan pengajuan, pada tracking surat akan
                            menampilkan status surat saat ini</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <img class="card-img-top p-2" src="{{asset('frontend/img/langkah/4.png')}}" height="230px"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5><strong>Langkah 5</strong></h5>
                        <p class="card-text text-justify">Setelah tracking surat berhasil disetujui, anda bisa
                            melakukan unduh surat bebas lab</p>
                    </div>
                </div>
                <div class="card mt-3" style="width: 25rem;">
                    <center><img class="card-img-top p-2" src="{{asset('frontend/img/langkah/5.png')}}"
                        height="230px" style="width: 250px" alt="Card image cap"></center>
                        <div class="card-body">
                            <h5><strong>Langkah 6</strong></h5>
                            <p class="card-text text-justify">Gambar diatas merupakan surat bebas lab yang berhasil
                                di setujui oleh admin</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
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

</script>
@endsection
