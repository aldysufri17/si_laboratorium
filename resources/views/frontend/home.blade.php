@extends('frontend.layouts.app')
@section('title', 'Beranda')
@section('content')
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
            <div class="swiper-slide" style="background-image: url('{{asset('frontend/img/hero-carousel/1.jpg')}}');">
            </div>
            <div class="swiper-slide" style="background-image: url('{{asset('frontend/img/hero-carousel/2.jpg')}}');">
            </div>
            <div class="swiper-slide" style="background-image: url('{{asset('frontend/img/hero-carousel/3.jpg')}}');">
            </div>
            <div class="swiper-slide" style="background-image: url('{{asset('frontend/img/hero-carousel/4.jpg')}}');">
            </div>
            <div class="swiper-slide" style="background-image: url('{{asset('frontend/img/hero-carousel/5.jpg')}}');">
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
                    <h2>Laboratorium Sistem Tertanam dan Robotika</h2>
                    <h3>Departemen Teknik Komputer - Universitas Diponegoro</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo optio nihil dolore veritatis,
                        delectus quisquam ab, architecto obcaecati molestiae, rem numquam! Fuga voluptatum officia
                        fugit?</p>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->
    <!-- ======= Services Section ======= -->
    <section id="services">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Layanan</h2>
                <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam
                    enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum
                    velit export irure minim illum fore</p>
            </div>

            <div class="row gy-4">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="box">
                        <div class="icon"><i class="bi bi-briefcase"></i></div>
                        <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                            excepturi sint occaecati cupiditate non provident etiro rabeta lingo.</p>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="box">
                        <div class="icon"><i class="bi bi-card-checklist"></i></div>
                        <h4 class="title"><a href="">Dolor Sitema</a></h4>
                        <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat tarad limino ata nodera clas.</p>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="box">
                        <div class="icon"><i class="bi bi-bar-chart"></i></div>
                        <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
                        <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                            dolore eu fugiat nulla pariatur trinige zareta lobur trade.</p>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="box">
                        <div class="icon"><i class="bi bi-binoculars"></i></div>
                        <h4 class="title"><a href="">Magni Dolores</a></h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum rideta zanox satirente madera</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Call To Action Section ======= -->
    <section id="call-to-action">
        <div class="container" data-aos="zoom-out">
          <div class="row">
            <div class="col-lg-9 text-center text-lg-start">
              <h3 class="cta-title">Perlu Bantuan?</h3>
              <p class="cta-text"> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-lg-3 cta-btn-container text-center">
              <a class="cta-btn align-middle" href="#"><i class="fab fa-whatsapp"></i> Hubungi Kami</a>
            </div>
          </div>
        </div>
      </section><!-- End Call To Action Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Galeri</h2>
                <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam
                    enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum
                    velit export irure minim illum fore</p>
            </div>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="{{asset('frontend/img/portfolio/portfolio-7.jpg')}}" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Card 1</h4>
                        <p>Card</p>
                        <a href="{{asset('frontend/img/portfolio/portfolio-7.jpg')}}" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="{{asset('frontend/img/portfolio/portfolio-8.jpg')}}" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Card 3</h4>
                        <p>Card</p>
                        <a href="{{asset('frontend/img/portfolio/portfolio-8.jpg')}}" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="{{asset('frontend/img/portfolio/portfolio-9.jpg')}}" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Web 3</h4>
                        <p>Web</p>
                        <a href="{{asset('frontend/img/portfolio/portfolio-9.jpg')}}" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                class="bx bx-link"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Portfolio Section -->
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
