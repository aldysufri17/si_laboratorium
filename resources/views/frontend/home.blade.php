@extends('frontend.layouts.app')
@section('title', 'Beranda')
@section('content')
{{-- Notifikasi --}}
@auth
{{-- Pengajuan Disetujui --}}
@foreach ($peminjaman as $data)
<a href="{{route('cart')}}">
    @if ($message = Session::get('in'))
    <div class="alert alert-success alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Pengajuan barang {{$data->barang->nama}} {{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
</a>
@endforeach
{{-- end diseujui --}}

{{-- Pengajuan ditolak --}}
@foreach ($tolak as $data)
<a href="{{route('cart')}}">
    @if ($message = Session::get('tolak'))
    <div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Pengajuan barang {{$data->barang->nama}} {{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
</a>
@endforeach
{{-- end ditolak--}}

{{-- Aktif --}}
@foreach ($aktif as $data)
<a href="{{route('daftar.pinjaman')}}">
    @if ($message = Session::get('aktif'))
    <div class="alert alert-info alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Pengajuan barang {{$data->barang->nama}} {{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
</a>
@endforeach
{{-- Aktif--}}

@foreach ($telat as $data)
@if ($data->tgl_end < date('Y-m-d')) @php $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
    $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
    $late = $start->diffInDays($now);
    @endphp
    <a href="{{route('cart')}}">
        @if ($message = Session::get('telat'))
        <div class="alert alert-warning alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
            <button id="notif" type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Pengembalian Barang {{$data->barang->nama}} {{ $message }} {{ $late }} Hari!!!</strong>
            {{ session('error') }}
        </div>
        @endif
    </a>
    @endif
    @endforeach
    @endauth
    {{-- EndNotifikasi --}}

    <!-- ======= hero Section ======= -->
    <section id="hero" style="height: 85vh;">
        @include('sweetalert::alert')
        <div class="hero-content" data-aos="fade-up">

            <h2>Sistem Peminjaman Barang <br> <span class="animate text-secondary typed-cursor"></span></h2>
            <div>
                <a href="{{ route('search') }}" class="btn-get-started scrollto">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Barang
                </a>
            </div>
        </div>
        <div class="hero-slider swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"
                    style="background-image: url('{{asset('frontend/img/hero-carousel/1.jpg')}}');">
                </div>
                <div class="swiper-slide"
                    style="background-image: url('{{asset('frontend/img/hero-carousel/2.jpg')}}');">
                </div>
                <div class="swiper-slide"
                    style="background-image: url('{{asset('frontend/img/hero-carousel/3.jpg')}}');">
                </div>
                <div class="swiper-slide"
                    style="background-image: url('{{asset('frontend/img/hero-carousel/4.jpg')}}');">
                </div>
                <div class="swiper-slide"
                    style="background-image: url('{{asset('frontend/img/hero-carousel/5.jpg')}}');">
                </div>
            </div>
        </div>

    </section><!-- End Hero Section -->

    <main id="main">
        <!-- ======= About Section ======= -->
        <section id="about">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-4 about-img">
                        <img src="{{asset('frontend/img/about.png')}}" alt="">
                    </div>

                    <div class="col-lg-7 ml-5 content">
                        <h2>Laboratorium</h2>
                        <h3>Departemen Teknik Komputer - Universitas Diponegoro</h3>
                        <p>Laboratorium sebagai Sarana Prasarana yang dapat digunakan oleh Mahasiswa / i Teknik Komputer
                            Undip dalam Proses Pembelajaran serta Dosen-Dosen Teknik Komputer Undip dalam melakukan
                            Riset /
                            Penelitian.</p>
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->

        <!-- ======= Clients Section ======= -->
        <section id="clients">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Kategori Laboratorium</h2>
                    <p>Departemen Teknik Komputer memiliki empat laboratorium, yaitu Laboratorium Sistem Tertanam dan
                        Robotika, Laboratorium Keamanan dan Jaringan Komputer, Laboratorium Rekayasa Perangkat Lunak,
                        dan Laboratorium Multimedia</p>
                </div>

                <div class="clients-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="{{asset('frontend/img/clients/embedded.png')}}"
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{asset('frontend/img/clients/rpl.png')}}" class="img-fluid"
                                alt=""></div>
                        <div class="swiper-slide"><img src="{{asset('frontend/img/clients/jarkom.png')}}"
                                class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{asset('frontend/img/clients/mulmed.png')}}"
                                class="img-fluid" alt=""></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section><!-- End Clients Section -->

        <!-- ======= Call To Action Section ======= -->
        <section id="call-to-action">
            <div class="container" data-aos="zoom-out">
                <div class="row">
                    <div class="col-lg-9 text-center text-lg-start">
                        <h3 class="cta-title">Perlu Bantuan?</h3>
                        <p class="cta-text"> Jika anda perlu bantuan kami, hubungi kami sekarang... </p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle"
                            href="https://api.whatsapp.com/send?phone=089XXXXXXXX&text=Hello+Admin%2C+Saya+mau+bertanya"><i
                                class="fab fa-whatsapp"></i> Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </section><!-- End Call To Action Section -->

        <!-- ======= Galeri Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Galeri</h2>
                    <p>Foto dokumentasi aktivitas yang dilakukan club riset laboratorium Departemen Teknik Komputer,
                    </p>
                </div>
                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <a href="https://embedded.undip.ac.id/img/landing/pengabdian-masyarakat-di-smk-nu-ungaran.JPG"
                            data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mt-4"
                            title="Pengabdian Masyarakat di SMK NU Ungaran"><img
                                src="https://embedded.undip.ac.id/img/landing/pengabdian-masyarakat-di-smk-nu-ungaran.JPG"
                                class="img-fluid" alt=""></a>
                        <div class="portfolio-info">
                            <h4>Pengabdian Masyarakat di SMK NU Ungaran</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <a href="https://embedded.undip.ac.id/img/landing/pengabdian-masyarakat-di-smk-n-4-semarang.jpg"
                            data-gallery="portfolioGallery" class="portfolio-lightbox preview-link mt-4"
                            title="Pengabdian Masyarakat di SMK N 4 Semarang"><img style="height: 237px; width:360px"
                                src="https://embedded.undip.ac.id/img/landing/pengabdian-masyarakat-di-smk-n-4-semarang.jpg"
                                class="img-fluid" alt=""></a>
                        <div class="portfolio-info">
                            <h4>Pengabdian Masyarakat di SMK N 4 Semarang</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <a href="{{asset('frontend/img/hero-carousel/5.jpg')}}" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link mt-4"
                            title="EMBRIO CLASS CERC di TEKNIK KOMPUTER ANGKATAN 2018"><img
                                style="height: 237px; width:360px" src="{{asset('frontend/img/hero-carousel/5.jpg')}}"
                                class="img-fluid" alt=""></a>
                        <div class="portfolio-info">
                            <h4>EMBRIO Class CERC di Teknik Komputer Angkatan 2018</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Galeri Section -->

        <!-- ======= Kegiatan Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Kegiatan</h2>
                    <p>Daftar kegiatan laboratorium sebagai penunjang praktikum Mahasiswa Teknik Komputer</p>
                </div>
                <div class="portfolio-item filter-web">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Laboratorium Sistem Tertanam dan Robotika</th>
                                <th width="15%">Laboratorium Rekayasa Perangkat Lunak</th>
                                <th width="15%">Laboratorium Jaringan dan Keamanan Komputer</th>
                                <th width="15%">Laboratorium Multimedia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Praktikum Sistem Digital</td>
                                <td>Praktikum Dasar Komputer</td>
                                <td>Praktikum Jaringan Komputer I</td>
                                <td>Praktikum Multimedia</td>
                            </tr>
                            <tr>
                                <td>Praktikum Mikroprosesor dan Preipheral</td>
                                <td>Praktikum Sistem Basis Data</td>
                                <td>Praktikum Jaringan Komputer II</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Praktikum Sistem Digital Lanjut</td>
                                <td>Praktikum Rekayasa Perangkat Lunak</td>
                                <td>Praktikum Jaringan Komputer Lanjut</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Praktikum Robotika</td>
                                <td>Praktikum Pemrograman Perangkat Bergerak</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Praktikum Rekayasa Perangkat Lunak Berbasis Komponen</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section><!-- End kegiatan Section -->
    </main><!-- End #main -->
    @endsection

    @section('script')
    <script>
        var typed = new Typed('.animate', {
            strings: ["Laboratorium", "Departemen", "Teknik Komputer"],
            startDelay: 10,
            // shuffle: true,
            typeSpeed: 200,
            loop: true,
            loopCount: Infinity,
            showCursor: true,
            cursorChar: '|',
            autoInsertCss: true
        });

        setInterval(function () {
            document.getElementById('notif').click();
        }, 4000);

    </script>
    @endsection
