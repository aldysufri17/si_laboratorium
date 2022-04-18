@extends('frontend.layouts.app')
@section('title', 'Daftar Peminjaman Selesai')

@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Peminjaman Saya</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Peminjaman Saya</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow mx-4 mb-4 border-0">
            <div class="d-sm-flex tab" style="margin: 0; padding:0">
                <button class="tablinks btn btn-sm" id="clickButton" onclick="openCity(event, 'London')">Peminjaman
                    Aktif</button>
                <button class="tablinks btn btn-sm" onclick="openCity(event, 'Paris')">Peminjaman Selesai</button>
            </div>
            <div class="card-body tabcontent p-3" id="London">
                @if ($aktif->isNotEmpty())
                <center>
                    <h3>Daftar Peminjaman Aktif</h3>
                </center>
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-xl-3 col-md-3">
                        <div class="card shadow p-0" style="border-left: 5px solid rgb(179, 255, 0)">
                            <div class="d-flex align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Peminjaman Aktif </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <h3 style="font-weight: bold" class="mx-2 mt-3">
                                            {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 3)->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Kategori Lab</th>
                                <th width="15%">Nama Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="15%">Penggunaan</th>
                                <th width="15%">Pengembalian</th>
                                <th width="15%">Telat</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aktif as $data)
                            <tr>
                                <td>
                                    @if ($data->kategori_lab == 1)
                                    Laboratorium Sistem Tertanam dan Robotika
                                    @elseif ($data->kategori_lab == 2)
                                    Laboratorium Rekayasa Perangkat Lunak
                                    @elseif($data->kategori_lab == 3)
                                    Laboratorium Jaringan dan Keamanan Komputer
                                    @elseif($data->kategori_lab == 4)
                                    Laboratorium Multimedia
                                    @endif
                                </td>
                                <td>
                                    <div class="col">
                                        <div class="row">{{$data->barang->nama}}</div>
                                        <div class="row text-muted">{{$data->barang->tipe}}</div>
                                    </div>
                                </td>
                                <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td>
                                <td>{{$data->tgl_start}} <br><span style="font-weight: bold">-Sampai-</span><br> {{$data->tgl_end}} </td>
                                <td>{{$data->tgl_end}}</td>
                                @if ($data->tgl_end < date('Y-m-d')) @php
                                    $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                                    $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                    $late = $start->diffInDays($now);
                                    @endphp
                                    <td class="text-danger"><strong>{{ $late.' '.'Hari' }}</strong></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                <td>
                                    <span class="badge badge-info">Aktif</span>
                                </td>
                                <td>
                                    <a href="{{route('peminjaman.edit', $data->id)}}" class="btn btn-warning m-2">
                                        <i class="fa-solid fa-arrow-rotate-left"></i> Kembalikan
                                    </a>
                                    <a href="{{route('peminjaman.edit', $data->id)}}" class="btn btn-warning m-2">
                                        <i class="fa-regular fa-plus"></i> Tambah Durasi
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{ $aktif->links() }}
                    </table>
                </div>
                {{-- Modal Delete --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalExample" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content bgdark shadow-2-strong ">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!
                            </div>
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
                        <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Peminjaman Aktif</p>
                    </div>
                </div>
                @endif
            </div>

            <div id="Paris" class="card-body tabcontent p-3">
                @if($selesai->isNotEmpty())
                <center>
                    <h3>Daftar Peminjaman Selesai</h3>
                </center>
                <div class="row d-flex justify-content-center my-4">
                    <div class="col-xl-3 col-md-3">
                        <div class="card shadow p-0" style="border-left: 5px solid rgb(179, 255, 0)">
                            <div class="d-flex align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Peminjaman Selesai </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center">
                                        <h3 style="font-weight: bold" class="mx-2 mt-3">
                                            {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 4)->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Nama Barang</th>
                                <th width="15%">Kategori Laboratorium</th>
                                <th width="10%">Jumlah</th>
                                <th width="15%">Penggunaan</th>
                                <th width="15%">Pengembalian</th>
                                <th width="10%">Kondisi</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selesai as $data)
                            <tr>
                                <td>
                                    <div class="col">
                                        <div class="row">{{$data->barang->nama}}</div>
                                        <div class="row text-muted">{{$data->barang->tipe}}</div>
                                    </div>
                                </td>
                                <td>
                                    @if ($data->kategori_lab == 1)
                                    Laboratorium Sistem Tertanam dan Robotika
                                    @elseif ($data->kategori_lab == 2)
                                    Laboratorium Rekayasa Perangkat Lunak
                                    @elseif($data->kategori_lab == 3)
                                    Laboratorium Jaringan dan Keamanan Komputer
                                    @elseif($data->kategori_lab == 4)
                                    Laboratorium Multimedia
                                    @endif
                                </td>
                                <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td>
                                <td>{{$data->tgl_start}}</td>
                                <td>{{$data->tgl_end}}</td>
                                <td><span class="badge badge-success">Baik</span></td>
                                <td>
                                    <span class="badge badge-primary">Clear</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{ $selesai->links() }}
                    </table>
                </div>
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalExample" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content bgdark shadow-2-strong ">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!
                            </div>
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
                        <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Peminjaman Selesai</p>
                    </div>
                </div>
                @endif
            </div>
            {{-- Modal Delete --}}

        </div>
    </section><!-- End Portfolio Details Section -->
</main><!-- End #main -->
@endsection

@section('script')
<script>
    $('#dataTable').DataTable({
        "bInfo": false,
        "paging": false,
        responsive: true,
        autoWidth: false,
    });


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
