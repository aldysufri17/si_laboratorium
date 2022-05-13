@extends('frontend.layouts.app')
@section('title', 'Daftar Peminjaman Selesai')

@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Detail Pengajuan</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li><a href="{{route('daftar.pinjaman')}}">Peminjaman Saya</a></li>
                    <li>Detail Pengajuan</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow mx-4 mb-4 p-4 border-0">
            <div class="card-body p-3">
                @if ($proses->isNotEmpty())
                <div class="text-center">
                    <a class="btn btn-danger float-left" href="{{route('daftar.pinjaman')}}"><i
                            class="fas fa-angle-double-left"></i> kembali</a>
                </div>
                <center>
                    <h3 class="mt-5">Pengajuan Pada {{Request::route('date')}}</h3>
                </center>
                <div class="detail">
                    <table width="500">
                        <tr>
                            <td class="font-weight-bold">Keperluan</td>
                            <td>: {{$detail->alasan}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Peminjaman</td>
                            <td>: {{$detail->tgl_start}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Pengembalian</td>
                            <td>: {{$detail->tgl_end}}</td>
                        </tr>
                    </table>
                    <a class="btn btn-success mt-2" href="#" data-toggle="modal" data-target="#cetak"><i
                            class="fas fa-print"></i> Unduh Surat</a>
                </div>
                <div class="table-responsive pt-3">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Gambar</th>
                                <th width="15%">Nama Barang</th>
                                <th width="15%">Kategori Lab</th>
                                <th width="10%">Status</th>
                                <th width="10%">Jumlah</th>
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
                                @if($data->barang->satuan_id > 0)
                                {{-- <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td> --}}
                                <td style="text-center">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-link px-2" id="minus"
                                            value="{{$data->id}}">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <input id="jumlah" min="0" name="quantity" value="{{$data->jumlah}}"
                                            type="number" readonly class="form-control form-control-sm" />

                                        <button type="button" class="btn btn-link px-2" id="plus" value="{{$data->id}}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $proses->links() }}

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
                                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
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
                                <a class="btn btn-success" href="{{route('print')}}">Unduh</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
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
