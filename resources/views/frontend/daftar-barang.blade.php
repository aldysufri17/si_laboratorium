@extends('frontend.layouts.app')
@section('title', 'Pencarian Barang')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Pencarian Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Pencarian Barang</li>
                </ol>
            </div>
        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        {{-- <livewire:barang-search/> --}}
        @php
            $test = "hello";
        @endphp
        <livewire:barang-search></livewire:barang-search>
    </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
@endsection
