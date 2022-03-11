@extends('frontend.layouts.app')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Riwayat Peminjaman</h2>
                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li>Riwayat</li>
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
                    <h1>Riwayat Peminjaman</h1>
                    <p>Total: {{$peminjaman->count()}} Barang</p>
                </center>
                <div class="card-block">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="15%">Nama Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="15%">Penggunaan</th>
                                <th width="15%">Pengembalian</th>
                                <th width="10%">Kondisi</th>
                                <th width="10%">Status</th>
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
                                    @if ($data->status == 3)
                                    <span class="badge badge-success">Active</span>
                                    @elseif ($data->status == 4)
                                    <span class="badge badge-primary">Clear</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bgdark shadow-2-strong ">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!</div>
                        <div class="modal-footer border-0">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                            <a class="btn btn-primary" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                Oke
                            </a>
                            <form id="user-delete-form" method="POST"
                                action="{{ route('peminjaman.destroy', ['id' => $data->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
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
