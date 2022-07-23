@extends('frontend.layouts.app')
@section('title', 'Daftar Peminjaman Selesai')

@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Detail Peminjaman</h2>
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{route('daftar.pinjaman')}}">Peminjaman Saya</a></li>
                    <li>Detail Peminjaman</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="card shadow mx-4 mb-4 p-4 border-0">
            <div class="text-center">
                <a class="btn btn-danger float-left" href="{{route('daftar.pinjaman')}}"><i
                        class="fas fa-angle-double-left"></i> kembali</a>
                <a class="btn btn-success btn-cetak float-right" href="#" data-toggle="modal" data-target="#cetak"><i
                        class="fas fa-print"></i> Unduh Surat</a>
            </div>
            <div class="card-body p-3">
                @if ($peminjaman->isNotEmpty())
                <div class="detail">
                    <div class="title">
                        <center>
                            <h3 class="font-weight-bold">Peminjaman Barang<br>Kode : <span style="text-transform: uppercase"><u>{{$detail->kode_peminjaman}}</u></span></h3>
                        </center>
                    </div>
                    <table width="500">
                        <tr>
                            <td class="font-weight-bold">Keperluan</td>
                            <td>: {{$detail->alasan}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Kode Peminjaman</td>
                            <td class="font-weight-bold" style="text-transform: uppercase">: {{$detail->kode_peminjaman}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Waktu Pengajuan</td>
                            <td>: {{$detail->created_at->format('d M Y')}}
                                <strong>({{$detail->created_at->format('H:i:s A')}})</strong></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Peminjaman</td>
                            <td>: {{Carbon\Carbon::parse($detail->tgl_start)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Pengembalian</td>
                            <td>: {{Carbon\Carbon::parse($detail->tgl_end)->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive pt-3">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Gambar</th>
                                <th width="15%">Nama Barang</th>
                                <th width="15%">Kategori Laboratorium</th>
                                <th class="text-center" width="10%">Status</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $data)
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
                                    <span class="badge badge-info">Sistem Tertanam dan Robotika</span>
                                    @elseif ($data->kategori_lab == 2)
                                    <span class="badge badge-info">Rekayasa Perangkat Lunak</span>
                                    @elseif($data->kategori_lab == 3)
                                    <span class="badge badge-info">Jaringan dan Keamanan Komputer</span>
                                    @elseif($data->kategori_lab == 4)
                                    <span class="badge badge-info">Multimedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($data->status == 0)
                                    <span class="badge badge-secondary">Proses</span>
                                    @elseif ($data->status == 1)
                                    <span class="badge badge-danger">Ditolak</span>
                                    @elseif($data->status == 2)
                                    <span class="badge badge-success">Disetujui</span>
                                    @elseif($data->status == 3)
                                    <span class="badge badge-warning">Pengembalian</span>
                                    @elseif($data->status == 4)
                                    <span class="badge badge-info">Dikembalikan</span>
                                    @endif
                                </td>
                                @if($data->barang->satuan_id > 0)
                                {{-- <td>{{$data->jumlah}} {{$data->barang->satuan->nama_satuan}}</td> --}}
                                <td style="text-center">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-link px-2" @if ($data->status != 0) disabled @endif id="minus"
                                            @if ($data->status == 0) value="{{$data->id}}" @endif>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input id="jumlah" min="0" name="quantity" value="{{$data->jumlah}}"
                                            type="number" readonly class="form-control form-control-sm" />
                                        <button type="button" class="btn btn-link px-2" @if ($data->status != 0) disabled @endif id="plus" @if ($data->status == 0) value="{{$data->id}}" @endif>
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                @endif
                                <td class="text-center">
                                    <button class="btn btn-danger @if ($data->status <= 1) delete-btn @endif"
                                        title="Delete" value="{{$data->id}}" @if ($data->status > 1)
                                        disabled @endif>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <input type="hidden" value="{{$detail->kategori_lab}}" name="kategori_lab" id="kategori_lab">
                                    {{-- Data Unduh Surat --}}
                                    <input type="hidden" value="{{$data->created_at}}" name="date_id" id="date_id">
                                    <input type="hidden" value="{{$data->kode_peminjaman}}" name="kode_id" id="kode_id">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $peminjaman->links() }}

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
                                    action="{{ route('peminjaman.destroy', ['id' => 1]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="delete_id" id="delete_id">
                                    <input type="hidden" name="lab" id="lab">
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
                                <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body border-0">Surat peminjaman hanya berisi barang yang sudah disetujui.</div>
                            <div class="modal-footer border-0">
                                <button class="btn btn-danger close-mdl" type="button"
                                    data-dismiss="modal">Batal</button>
                                <form action="{{route('print')}}" method="get">
                                    <button class="btn btn-success" type="submit">Unduh</button>
                                    <input type="hidden" name="id_peminjaman" id="id_peminjaman">
                                </form>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js" type="text/javascript">
</script>
<script>
    $('#dataTable').DataTable({
        "bInfo": false,
        "paging": false,
        responsive: true,
        autoWidth: false,
    });

    if (document.getElementById('notif')) {
            setTimeout(function () {
            document.getElementById('notif').click();
        }, 4000);
        }

    $(document).on('click', '.delete-btn', function () {
        var sid = $(this).val();
        var kid = $('#kategori_lab').val();
        $('#deleteModal').modal('show')
        $('#delete_id').val(sid)
        $('#lab').val(kid)
    });
    $(document).on('click', '.btn-cetak', function () {
        $('#cetak').modal('show')
        var did = $('#date_id').val();
        var kid = $('#kode_id').val();
        $('#id_peminjaman').val(kid)
        $('#id_date').val(did)
    });
    $(document).on('click', '.close-mdl', function () {
        $('#deleteModal').modal('hide')
        $('#kembaliModal').modal('hide')
        $('#cetak').modal('hide')
    });

    $(document).on('click', '#minus', function () {
        var id = $(this).val();
        $.ajax({
            url: "{{ route('keranjang.dec', 1) }}",
            type: "GET",
            data: {
                id: id
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    $(document).on('click', '#plus', function () {
        var id = $(this).val();
        $.ajax({
            url: "{{ route('keranjang.inc',1) }}",
            type: "GET",
            data: {
                id: id
            },
            success: function (data) {
                location.reload();
            }
        });
    });

</script>
@endsection
