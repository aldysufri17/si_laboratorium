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
                    <button class="tablinks btn btn-sm" id="clickButton"
                        onclick="openCity(event, 'Proses')">Peminjaman</button>
                    <button class="tablinks btn btn-sm" onclick="openCity(event, 'Selesai')">Riwayat Peminjaman</button>
                </div>
                <div class="card-body tabcontent p-3" id="Proses">
                    @if ($peminjaman->isNotEmpty())
                    <center>
                        <h3 class="font-weight-bold">Daftar Keranjang Peminjaman</h3>
                    </center>
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(109, 109, 109)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Barang Proses </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                @php
                                                $kategori = Request::route('kategori');
                                                $data_proses = App\Models\Peminjaman::where('user_id',
                                                auth()->user()->id)->where('status', 0)->count();
                                                @endphp
                                                {{ $data_proses }}
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
                                            Total Barang disetujui</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                @php
                                                $kategori = Request::route('kategori');
                                                $data_terima = App\Models\Peminjaman::where('user_id',
                                                auth()->user()->id)->where('status', 2)->count();
                                                @endphp
                                                {{ $data_terima }}
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
                                            Total Barang ditolak</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">
                                                @php
                                                $kategori = Request::route('kategori');
                                                $data_tolak = App\Models\Peminjaman::where('user_id',
                                                auth()->user()->id)->where('status', 1)->count();
                                                @endphp
                                                {{ $data_tolak }}
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
                                    <th width="15%" class="text-center">Nama Keranjang</th>
                                    <th width="15%" class="text-center">Total Barang</th>
                                    <th width="15%" class="text-center">Telat Pengembalian</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjaman as $data)
                                <tr>
                                    <td class="text-center" style="text-transform: uppercase">{{$data->nama_keranjang}}
                                    </td>
                                    <td class="text-center">{{$data->total}}</td>
                                    @php
                                    $data = App\Models\Peminjaman::where('user_id',
                                    auth()->user()->id)->where('kode_peminjaman', $data->kode_peminjaman)->first();
                                    $status = $data->status;
                                    @endphp
                                    <td class="text-center">
                                        @if ($data->tgl_end < date('Y-m-d')) @php
                                            $start=\Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_end);
                                            $now = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                            $late = $start->diffInDays($now);
                                            @endphp
                                            @if ($status > 1)
                                            <span class="badge badge-danger">Telat {{ $late.' '.'Hari' }}</span>
                                            @else
                                            <span>-</span>
                                            @endif
                                            @else
                                            <span>-</span>
                                            @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($status == 3)
                                        <p class="font-weight-bold text-center text-danger">MENUNGGU KONFIRMASI
                                            PENGEMBALIAN</p>
                                        @else
                                        @php
                                        $count = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status',
                                        0)->where('kode_peminjaman',$data->kode_peminjaman)->get()
                                        @endphp
                                        <span class="badge badge-secondary">{{ $count->count() }} Proses</span>
                                        {{-- @elseif ($status == 1) --}}
                                        @php
                                        $kategori = Request::route('kategori');
                                        $count = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status',
                                        1)->where('kode_peminjaman',$data->kode_peminjaman)->get()
                                        @endphp
                                        <span class="badge badge-danger">{{ $count->count() }} Ditolak</span>
                                        {{-- @elseif($status == 2) --}}
                                        @php
                                        $kategori = Request::route('kategori');
                                        $count = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status',
                                        2)->where('kode_peminjaman',$data->kode_peminjaman)->get()
                                        @endphp
                                        <span class="badge badge-success">{{ $count->count() }} Disetujui</span>
                                        @endif
                                    </td>
                                    <td class="d-sm-flex justify-content-center">
                                        <a href="{{route('keranjang.detail', $data->kode_peminjaman)}}"
                                            class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                            title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        {{-- Edit Button --}}
                                        @php
                                        $edit = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status', '>' , 0)->where('kode_peminjaman',
                                        $data->kode_peminjaman)->get();
                                        @endphp
                                        @if ($edit->isNotEmpty())
                                        <button class="btn btn-secondary mx-2" disabled title="Edit">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        @else
                                        <a href="{{route('peminjaman.edit', $data->kode_peminjaman)}}"
                                            class="btn btn-info mx-2" title="Edit">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        @endif

                                        {{-- Delete Button --}}
                                        @php
                                        $kategori = Request::route('kategori');
                                        $edit = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status', '>' , 1)->where('kode_peminjaman',
                                        $data->kode_peminjaman)->get();
                                        @endphp
                                        @if ($edit->isNotEmpty())
                                        <button class="btn btn-secondary" disabled title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-danger delete-btn" title="Delete"
                                            value="{{$data->kode_peminjaman}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif

                                        {{-- Terima Button --}}
                                        @php
                                        $kategori = Request::route('kategori');
                                        $hapus = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->whereNotBetween('status', [1,2])->where('kode_peminjaman',
                                        $data->kode_peminjaman)->get();
                                        $hapus_cld = App\Models\Peminjaman::where('user_id',
                                        auth()->user()->id)->where('status', '!=', 1)->where('kode_peminjaman',
                                        $data->kode_peminjaman)->get();
                                        @endphp
                                        @if ($hapus->isEmpty())
                                        @if ($hapus_cld->isNotEmpty())
                                        <button class="btn btn-warning kembali-btn ml-2" title="Kembalikan"
                                            value="{{$data->kode_peminjaman}}">
                                            <i class="fa-solid fa-backward-step"></i>
                                        </button>
                                        @else
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $peminjaman->links() }}
                        <a class="btn btn-success" href="{{url('/cart')}}">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                    </div>
                    {{-- Modal Kembalikan --}}
                    <div class="modal fade" id="kembaliModal" tabindex="-1" role="dialog"
                        aria-labelledby="kembaliModalExample" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content bgdark shadow-2-strong ">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-light font-weight-bold" id="kembaliModalExample">
                                        Pengembalian Barang
                                    </h5>
                                    <button class="close close-mdl" type="button" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body border-0 text-dark">Tekan Oke untuk mengembalikan barang !!
                                </div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-danger close-mdl" type="button"
                                        data-dismiss="modal">Batal</button>
                                    <a class="btn btn-warning" href="{{ route('logout') }}"
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
                                        action="{{ route('peminjaman.destroy', ['id' => 0]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="delete_id" id="delete_id">
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
                            <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Pengajuan Peminjaman
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body tabcontent p-3" id="Selesai">
                    @if ($riwayat->isNotEmpty())
                    <center>
                        <h3 class="font-weight-bold">Daftar Riwayat Peminjaman</h3>
                    </center>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">Waktu Pengajuan Peminjaman</th>
                                    <th width="15%" class="text-center">Waktu Barang Dikembalikan</th>
                                    <th width="10%" class="text-center">Nama Keranjang</th>
                                    <th width="10%" class="text-center">Jumlah Barang</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $data)
                                <tr>
                                    <td class="">
                                        <div class="col">
                                            <div class="row">{{$data->created_at->format('d M Y')}}</div>
                                            <div class="row text-muted">
                                                <strong>({{$data->created_at->format('H:i:s A')}})</strong></div>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="col">
                                            <div class="row">{{$data->updated_at->format('d M Y')}}</div>
                                            <div class="row text-muted">
                                                <strong>({{$data->updated_at->format('H:i:s A')}})</strong></div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="text-transform: uppercase">{{ $data->nama_keranjang }}</td>
                                    <td class="text-center">{{ $data->total }}</td>
                                    <td class="d-sm-flex justify-content-center">
                                        <button class="btn btn-primary detail-btn" title="Show"
                                            value="{{$data->kode_peminjaman}}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $riwayat->links() }}
                    </div>
                    {{-- Detail Modal --}}
                    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title text-light font-weight-bold" id="detailModalExample">
                                        Tampilkan</h5>
                                    <button class="close close-mdl" type="button" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h6 class="font-weight-bold mb-0">Daftar Riwayat Barang Pinjaman</h6>
                                        <div class="mt-3 mb-0">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Barang</th>
                                                        <th>Nama</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="barang">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-danger close-mdl" type="button"
                                        data-dismiss="modal">Close</button>
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

            </div>
        </section>
</main>
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
            $('#detailModal').modal('hide')

        });
    });

    $(".detail-btn").click(function () {
        $('#detailModal').modal('show')
        var did = $(this).val();
        $.ajax({
            url: "{{ route('riwayat.detail') }}",
            type: "GET",
            data: {
                kode: did
            },
            success: function (data) {
                $('#barang').html(data);
            }
        });
    });

</script>
@endsection
