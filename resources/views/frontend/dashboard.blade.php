@extends('frontend.layouts.app')   
@section('title', 'Beranda')
@section('content')
   <!-- ======= hero Section ======= -->
   <section id="hero" style="height: 100vh;">

    <div class="hero-content" data-aos="fade-up">
        <h2>Sistem Peminjaman Barang <br> <span class="animate"></span></h2>
        <div>
            <a href="#about" class="btn-get-started scrollto">
                <i class="fa-solid fa-magnifying-glass"></i> Cari Barang
            </a>
        </div>
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
                <div class="col-lg-6 about-img">
                    <img src="{{asset('frontend/img/about-img.jpg')}}" alt="">
                </div>

                <div class="col-lg-6 content">
                    <h2>Lorem ipsum dolor sit amet, consectetur adipiscing</h2>
                    <h3>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.</h3>

                    <ul>
                        <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.</li>
                        <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate
                            velit.</li>
                        <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda
                            mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>

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
        });
    </script>
@endsection