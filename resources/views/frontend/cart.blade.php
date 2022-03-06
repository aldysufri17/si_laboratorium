@extends('frontend.layouts.app')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Keranjang Peminjaman Barang</h2>
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>peminjaman</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">
            @if ($peminjaman->isNotEmpty())
            <div class="card shadow-sm p-4 mb-4 bg-white rounded">
                <center>
                    <h1>Daftar Peminjaman</h1>
                    <p>Total: {{$peminjaman->count()}} Barang</p>
                </center>
                <div class="card-block">
                    <table class="table">
                        <thead>
                            <tr >
                                <th width="15%">Nama Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="15%">Penggunaan</th>
                                <th width="15%">Pengembalian</th>
                                <th width="10%">Kondisi</th>
                                <th width="10%">Status</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $data)
                            <tr>
                                <td>
                                    <div class="col">
                                        <div class="row">{{$data->barang->nama}}</div>
                                        <div class="row text-muted">{{$data->barang->tipe}}</div>
                                    </div>
                                </td>
                                <td>{{$data->jumlah}}</td>
                                <td>{{$data->tgl_start}}</td>
                                <td>{{$data->tgl_end}}</td>
                                <td><span class="badge badge-success">Baik</span></td>
                                <td>
                                    @if ($data->status == 0)
                                    <span class="badge badge-secondary">Proses</span>
                                    @elseif ($data->status == 1)
                                    <span class="badge badge-danger">Reject</span>
                                    @elseif($data->status == 2)
                                    <span class="badge badge-success">Accept</span>
                                    @endif
                                </td>
                                <td style="display: flex">
                                    <a href="{{route('peminjaman.edit', $data->id)}}" class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{route('print')}}"><i class="fas fa-print"></i> Cetak Surat Peminjaman</a>
                </div>
            </div>
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