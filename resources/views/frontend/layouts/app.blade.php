<!DOCTYPE html>
<html lang="en">
@include('frontend.common.head')

<body>
    <!-- ======= Top&Header ======= -->
    @include('frontend.common.header')
    <!-- End Header -->
        @yield('content')
    @include('frontend.common.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('frontend/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('frontend/js/main.js')}}"></script>
    @yield('script')
</body>
