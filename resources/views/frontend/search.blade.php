@extends('frontend.layouts.app')
@section('title', 'Beranda')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Pencarian Barang</h2>
                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li>Search</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            <form action="{{route('search')}}" method="get">
                <div class="input-group mb-5">
                    <div class="input-group-prepend">
                        <select class="form-select" name="kategori" aria-label="Default select example">
                            <option @if (Request::get('kategori') == 1) selected @endif value="1">Sistem Tertanam dan
                                Robotika</option>
                            <option @if (Request::get('kategori') == 2) selected @endif value="2">Rekayasa Perangkat Lunak</option>
                            <option @if (Request::get('kategori') == 3) selected @endif  value="3">Jaringan dan Keamanan Komputer</option>
                            <option @if (Request::get('kategori') == 4) selected @endif  value="4">Multimedia</option>
                        </select>
                    </div>
                    <input type="text" class="form-control" name="search" placeholder="Search..."
                        value="{{Request::get('search')}}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            @if ($barang->isNotEmpty())
            @foreach ($barang as $data)
            <a href="{{route('detail.barang', $data->id)}}">
                <div class="card items shadow-sm p-4 mb-4 bg-white rounded">
                    <div class="card-block">
                        <h4 class="card-title text-dark">{{$data->nama}} - {{$data->tipe}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Stock : {{$data->stock}} {{$data->satuan}}</h6>
                        <span class="badge badge-info">{{$data->lokasi}}</span>
                        <span class="badge badge-success">Baik</span>
                    </div>
                </div>
            </a>
            @endforeach
            {{ $barang->links() }}
            @else
            <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
                <div class="card-block">
                    <span class="">Oops!</span><br>
                    <p><i class="fa-solid fa-circle-info text-primary"></i> Data tidak ditemukan</p>
                </div>
            </div>
            @endif
        </div>
    </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
@endsection
