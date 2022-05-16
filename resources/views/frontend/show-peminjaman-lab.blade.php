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
        <strong>Pengajuan barang {{$data->barang->nama}}-{{$data->barang->tipe}} {{ $message }}</strong>
        {{ session('error') }}
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
            <strong>Pengembalian Barang {{$data->barang->nama}}-{{$data->barang->tipe}} {{ $message }} {{ $late }}
                Hari!!!</strong>
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
                    <button class="tablinks btn btn-sm" onclick="openCity(event, 'Selesai')">Peminjaman Selesai</button>
                </div>
                <div class="card-body tabcontent p-3" id="Proses">
                    @if ($peminjaman->isNotEmpty())
                    <center>
                        <h3 class="font-weight-bold">Kategori Laboratorium</h3>
                    </center>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Kategori Laboratorium</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjaman as $data)
                                <tr>
                                    <td class="text-center">
                                        @if ($data->kategori_lab == 1)
                                        <span>Sistem Tertanam dan Robotika</span>
                                        @elseif ($data->kategori_lab == 2)
                                        <span>Rekayasa Perangkat Lunak</span>
                                        @elseif($data->kategori_lab == 3)
                                        <span>Jaringan dan Keamanan Komputer</span>
                                        @elseif($data->kategori_lab == 4)
                                        <span>Multimedia</span>
                                        @endif
                                    </td>
                                    <td class="d-sm-flex justify-content-center">
                                        <a href="{{route('pinjaman.date', $data->kategori_lab)}}"
                                            class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                            title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $peminjaman->links() }}
                        <a class="btn btn-success" href="{{url('/cart')}}">
                            <i class="fas fa-plus"></i> Tambah Pengajuan
                        </a>
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

                <div class="card-body tabcontent p-3" id="Selesai">
                    @if ($riwayat->isNotEmpty())
                    <center>
                        <h3 class="font-weight-bold">Kategori Laboratorium</h3>
                    </center>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Kategori Laboratorium</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $data)
                                <tr>
                                    <td class="text-center">
                                        @if ($data->kategori_lab == 1)
                                        <span>Sistem Tertanam dan Robotika</span>
                                        @elseif ($data->kategori_lab == 2)
                                        <span>Rekayasa Perangkat Lunak</span>
                                        @elseif($data->kategori_lab == 3)
                                        <span>Jaringan dan Keamanan Komputer</span>
                                        @elseif($data->kategori_lab == 4)
                                        <span>Multimedia</span>
                                        @endif
                                    </td>
                                    <td class="d-sm-flex justify-content-center">
                                        <a href="{{route('riwayat.peminjaman', $data->kategori_lab)}}"
                                            class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                            title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $riwayat->links() }} 
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
