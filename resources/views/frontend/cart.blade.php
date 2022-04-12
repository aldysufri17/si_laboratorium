@extends('frontend.layouts.app')
@section('content')
@section('title', 'Keranjang Pengajuan')

<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Keranjang Pengajuan</h2>
                <ol>
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li>Keranjang Pengajuan</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        @if ($peminjaman->isNotEmpty())
        <div class="card shadow mx-4 p-3 mb-4 border-0">
            <div class="card-body">
                <center>
                    <h1>Daftar Barang Pengajuan</h1>
                </center>
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(179, 255, 0)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengajuan Barang </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">{{$peminjaman->count()}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(49, 49, 49)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Barang dalam Proses</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">{{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 0)->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="card shadow p-0" style="border-left: 5px solid rgb(0, 214, 64)">
                                <div class="d-flex align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Peminjaman Aktif</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <h3 style="font-weight: bold" class="mx-2 mt-3">{{ App\Models\Peminjaman::where('user_id', auth()->user()->id)->where('status', 3)->count() }}</h3>
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
                                <th width="15%">Kategori Lab</th>
                                <th width="15%">Lokasi Barang</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%">Penggunaan</th>
                                <th width="10%">Pengembalian</th>
                                <th width="10%">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
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
                                <td>{{$data->barang->lokasi}}</td>
                                <td>{{$data->jumlah}} {{$data->barang->satuan->nama}}</td>
                                <td>{{$data->tgl_start}}</td>
                                <td>{{$data->tgl_end}}</td>
                                <td>
                                    @if ($data->status == 0)
                                    <span class="badge badge-secondary">Proses</span>
                                    @elseif ($data->status == 1)
                                    <span class="badge badge-danger">Reject</span>
                                    @elseif($data->status == 2)
                                    <span class="badge badge-success">Accept</span>
                                    @elseif($data->status == 3)
                                    <span class="badge badge-info">Active</span>
                                    @endif
                                </td>
                                <td style="display: flex">
                                    @if ($data->status == 0)
                                    <a href="{{route('peminjaman.edit', $data->id)}}" class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @elseif ($data->status >= 1)
                                    <a href="#" class="btn btn-secondary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $peminjaman->links() }}
                    <a class="btn btn-primary float-right mr-3 mb-3" href="#" data-toggle="modal"
                        data-target="#cetak"><i class="fas fa-print"></i> Cetak Surat Peminjaman</a>
                    <a class="btn btn-success" href="{{url('/search')}}">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                </div>
            </div>

            {{-- Modal Delete --}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bgdark shadow-2-strong ">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-light" id="deleteModalExample"><strong>Anda yakin ingin
                                    Menghapus?</strong></h5>
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
            {{-- Modal Cetak Surat --}}
            <div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="cetakExample"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bgdark shadow-2-strong ">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-light" id="cetakExample"><strong>Perhatian..!!!</strong></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body border-0 text-danger">Ketika anda melakukan cetak surat, maka barang yang
                            memiliki status proses tidak akan terdaftar dalam surat.</div>
                        <div class="modal-footer border-0">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                            <a class="btn btn-primary" href="{{route('print')}}">Cetak</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="ml-4 mb-3">
                <a class="btn btn-success" href="{{url('/search')}}">
                    <i class="fa-solid fa-magnifying-glass"></i> Pencarian Barang
                </a>
            </div>
            <div class="card shadow-sm p-3 mx-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
                <div class="card-block">
                    <span class="">Oops!</span><br>
                    <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Pengajuan Barang</p>
                </div>
            </div>
            @endif
        </div>
    </section><!-- End Portfolio Details Section -->
</main><!-- End #main -->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false
        });
    });

</script>
@endsection
