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
    {{-- Pengajuan Disetujui --}}
    @foreach ($setujui as $data)
    @if ($message = Session::get('in'))
    <div class="alert alert-success alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Pengajuan barang {{$data->barang->nama}}-{{$data->barang->tipe}} {{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    @endforeach
    {{-- end diseujui --}}

    {{-- Pengajuan ditolak --}}
    @foreach ($tolak as $data)
    @if ($message = Session::get('tolak'))
    <div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
        <button id="notif" type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Pengajuan {{$data->barang->nama}}-{{$data->barang->tipe}} {{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    @endforeach
    {{-- end ditolak--}}

    @foreach ($telat as $data)
    @if ($data->tgl_end < date('Y-m-d')) @php $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
        $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $late = $start->diffInDays($now);
        @endphp
        @if ($message = Session::get('telat'))
        <div class="alert alert-warning alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
            <button id="notif" type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Pengembalian Barang {{$data->barang->nama}}-{{$data->barang->tipe}} {{ $message }} {{ $late }} Hari!!!</strong>
            {{ session('error') }}
        </div>
        @endif
        @endif
        @endforeach

        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="card shadow mx-4 mb-4 border-0">
                <div class="d-sm-flex tab" style="margin: 0; padding:0">
                    <button class="tablinks btn btn-sm" id="clickButton" onclick="openCity(event, 'Proses')">Pengajuan
                        Peminjaman</button>
                    <button class="tablinks btn btn-sm mx-2" id="clickButton"
                        onclick="openCity(event, 'Aktif')">Peminjaman
                        Aktif</button>
                    <button class="tablinks btn btn-sm" onclick="openCity(event, 'Selesai')">Peminjaman Selesai</button>
                </div>

                <div class="card-body tabcontent p-3" id="Proses">
                    @if ($proses->isNotEmpty())
                    <center>
                        <h3>Daftar Pengajuan</h3>
                    </center>
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(109, 109, 109)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan dalam Proses </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 0)->count() }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(0, 255, 76)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan disetujui</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 2)->count() }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(255, 0, 0)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan ditolak</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 1)->count() }}
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
                                    <th width="15%">Gambar</th>
                                    <th width="15%">Nama Barang</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Kategori Lab</th>
                                    <th width="10%">Penggunaan</th>
                                    <th width="10%">Pengembalian</th>
                                    <th width="10%">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proses as $data)
                                <tr>
                                    <td><img width="90px"
                                            src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                            class="img-fluid rounded-3"></td>
                                    <td>
                                        <div class="col">
                                            <div class="row">{{$data->barang->nama}}</div>
                                            <div class="row text-muted">{{$data->barang->tipe}}</div>
                                        </div>
                                    </td>
                                    @if($data->barang->satuan_id > 0)
                                    <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td>
                                    @endif
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
                                    <td>{{$data->tgl_start}}</td>
                                    <td>{{$data->tgl_end}}</td>
                                    <td>
                                        @if ($data->status == 0)
                                        <span class="badge badge-secondary">Proses</span>
                                        @elseif ($data->status == 1)
                                        <span class="badge badge-danger">Ditolak</span>
                                        @elseif($data->status == 2)
                                        <span class="badge badge-success">Disetujui</span>
                                        @elseif($data->status == 3)
                                        <span class="badge badge-info">Aktif</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        @if ($data->status == 0)
                                        <a href="{{route('peminjaman.edit', $data->id)}}" class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @elseif ($data->status == 2)
                                        <button class="btn btn-primary delete-btn m-2" disabled title="Delete">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button class="btn btn-danger delete-btn" disabled title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @elseif($data->status == 1)
                                        <button class="btn btn-primary delete-btn m-2" disabled title="Delete">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button class="btn btn-danger delete-btn" title="Delete" value="{{$data->id}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $proses->links() }}
                        <a class="btn btn-primary float-right mr-3 mb-3" href="#" data-toggle="modal"
                            data-target="#cetak"><i class="fas fa-print"></i> Unduh Surat Pengajuan</a>
                        <a class="btn btn-success" href="{{url('/search')}}">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </a>
                    </div>

                    {{-- Modal Delete --}}
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalExample" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content bgdark shadow-2-strong ">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin
                                        Menghapus?
                                    </h5>
                                    <button class="close close-mdl" type="button" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!
                                </div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-danger close-mdl" type="button"
                                        data-dismiss="modal">Batal</button>
                                    <a class="btn btn-primary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Oke
                                    </a>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('peminjaman.destroy', ['id' => $data->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="delete_id" id="delete_id">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Cetak Surat --}}
                    <div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="cetakExample"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content bgdark shadow-2-strong ">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-light" id="cetakExample"><strong>Perhatian..!!!</strong>
                                    </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body border-0">Surat peminjaman digunakan untuk aktivasi peminjaman
                                    barang
                                    pada laboratorium terkait</div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                                    <a class="btn btn-primary" href="{{route('print')}}">Unduh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card shadow-sm p-3 mb-4 bg-white rounded"
                        style="border-left: solid 4px rgb(0, 54, 233);">
                        <div class="card-block">
                            <span class="">Oops!</span><br>
                            <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Pengajuan Peminjaman
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-body tabcontent p-3" id="Aktif">
                    @if ($aktif->isNotEmpty())
                    <center>
                        <h3>Daftar Peminjaman Aktif</h3>
                    </center>
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(4, 0, 255)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Peminjaman Aktif </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                {{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 2)->count() }}
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
                                    <th width="10%">Gambar</th>
                                    <th width="15%">Barang</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Kategori Lab</th>
                                    <th width="10%">Penggunaan</th>
                                    <th width="10%">Pengembalian</th>
                                    <th width="10%">Telat</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aktif as $data)
                                @if ($data->status == 3)
                                <tr style="background-color: rgb(204, 204, 204)">
                                    <td><img width="90px"
                                            src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                            class="img-fluid rounded-3"></td>
                                    <td>
                                        <div class="col">
                                            <div class="row text-dark">{{$data->barang->nama}}</div>
                                            <div class="row text-dark">{{$data->barang->tipe}}</div>
                                        </div>
                                    </td>
                                    <td class="text-dark">{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td>
                                    <td class="text-dark">
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
                                    <td colspan="4">
                                        <p class="font-weight-bold text-center text-danger mt-3">== MENUNGGU PERSETUJUAN OPERATOR ==<br>
                                            @if ($data->tgl_end < date('Y-m-d')) @php
                                                $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                                                $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                                $late = $start->diffInDays($now);
                                                @endphp
                                                <strong class="text-danger">ANDA TELAT MENGEMBALIKAN
                                                    {{ $late.' '.'Hari' }}</strong></p>
                                        @else
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @else
                                <tr>
                                    <td><img width="90px"
                                            src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                            class="img-fluid rounded-3"></td>
                                    <td>
                                        <div class="col">
                                            <div class="row">{{$data->barang->nama}}</div>
                                            <div class="row text-muted">{{$data->barang->tipe}}</div>
                                        </div>
                                    </td>
                                    <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td>
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
                                    <td>{{$data->tgl_start}}</td>
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
                                            <button class="btn btn-warning kembali-btn mb-2" title="Delete"
                                                value="{{$data->id}}" style="width:100%;">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </button>
                                        </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            {{ $aktif->links() }}
                        </table>
                    </div>

                    {{-- Modal Kembalikan --}}
                    <div class="modal fade" id="kembaliModal" tabindex="-1" role="dialog"
                        aria-labelledby="kembaliModalExample" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content bgdark shadow-2-strong ">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-light font-weight-bold" id="kembaliModalExample">Anda
                                        yakin ingin mengubah status peminjaman?
                                    </h5>
                                    <button class="close close-mdl" type="button" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body border-0 text-dark">Jika anda yakin ingin mengubah, Tekan
                                    Oke !!
                                </div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-danger close-mdl" type="button"
                                        data-dismiss="modal">Batal</button>
                                    <a class="btn btn-primary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-kembali-form').submit();">
                                        Oke
                                    </a>
                                    <form id="user-kembali-form" method="get" action="{{ route('kembalikan') }}">
                                        @csrf
                                        <input type="hidden" name="pem_id" id="pem_id">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card shadow-sm p-3 mb-4 bg-white rounded"
                        style="border-left: solid 4px rgb(0, 54, 233);">
                        <div class="card-block">
                            <span class="">Oops!</span><br>
                            <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Peminjaman Aktif</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div id="Selesai" class="card-body tabcontent p-3">
                    @if($selesai->isNotEmpty())
                    <center>
                        <h3>Daftar Peminjaman Selesai</h3>
                    </center>
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(0, 200, 250)">
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
                                    <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin
                                        Menghapus?
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
                    <div class="card shadow-sm p-3 mb-4 bg-white rounded"
                        style="border-left: solid 4px rgb(0, 54, 233);">
                        <div class="card-block">
                            <span class="">Oops!</span><br>
                            <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Peminjaman Selesai
                            </p>
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

    setInterval(function () {
        document.getElementById('notif').click();
    }, 4000);

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

    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });
        $(document).on('click', '.kembali-btn', function () {
            var sid = $(this).val();
            $('#kembaliModal').modal('show')
            $('#pem_id').val(sid)
        });
        $(document).on('click', '.close-mdl', function () {
            $('#deleteModal').modal('hide')
            $('#kembaliModal').modal('hide')
        });
    });

</script>
@endsection
