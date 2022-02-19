@extends('frontend.layouts.app')   
@section('title', 'Beranda')
@section('content')
   <!-- ======= hero Section ======= -->
   <section id="hero" style="height: 85vh;">
    @include('sweetalert::alert')
    <div class="hero-content" data-aos="fade-up">
        <h2>Sistem Peminjaman Barang <br> <span class="animate text-secondary typed-cursor"></span></h2>
        <div>
            <a href="{{ route('cari') }}" class="btn-get-started scrollto">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Barang
            </a>
        </div>
        {{-- <div class="ad">
            <input type="search" class="scrollto" placeholder="Cari Barang">
            <i class="fa fa-search"></i>
        </div> --}}
    </div>
    <div class="hero-slider swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"
                style="background-image: url('{{asset('frontend/img/hero-carousel/1.jpg')}}');"></div>
            <div class="swiper-slide"
                style="background-image: url('{{asset('frontend/img/hero-carousel/2.jpg')}}');"></div>
            <div class="swiper-slide"
                style="background-image: url('{{asset('frontend/img/hero-carousel/3.jpg')}}');"></div>
            <div class="swiper-slide"
                style="background-image: url('{{asset('frontend/img/hero-carousel/4.jpg')}}');"></div>
            <div class="swiper-slide"
                style="background-image: url('{{asset('frontend/img/hero-carousel/5.jpg')}}');"></div>
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
                    <h2>Laboratorium Sistem Tertanam dan Robotika</h2>
                    <h3>Departemen Teknik Komputer - Universitas Diponegoro</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo optio nihil dolore veritatis, delectus quisquam ab, architecto obcaecati molestiae, rem numquam! Fuga voluptatum officia fugit?</p>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->
</main><!-- End #main -->    
@endsection

@section('script')
        <script>
        var typed = new Typed('.animate', {
            strings: ["Laboratorium", "Sistem Tertanam", "dan Robotika", "Teknik Komputer"],
            startDelay: 10,
            // shuffle: true,
            typeSpeed: 200,
            loop: true,
            loopCount: Infinity,
            showCursor: true,
  cursorChar: '|',
  autoInsertCss: true
        });
    </script>
@endsection