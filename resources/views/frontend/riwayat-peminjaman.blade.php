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
        <div class="card shadow mx-4 mb-4 p-4 border-0">
            <div class="text-center">
                <a class="btn btn-danger float-left" href="{{route('daftar.pinjaman')}}"><i
                        class="fas fa-angle-double-left"></i> kembali</a>
            </div>
            <div class="card-body p-3" id="Proses">
                @if ($riwayat->isNotEmpty())
                <center>
                    <h3 class="font-weight-bold">Riwayat Peminjaman Laboratorium<br>
                        @if (Request::route('kategori') == 1)
                        <span>Sistem Tertanam dan Robotika</span>
                        @elseif (Request::route('kategori') == 2)
                        <span>Rekayasa Perangkat Lunak</span>
                        @elseif(Request::route('kategori') == 3)
                        <span>Jaringan dan Keamanan Komputer</span>
                        @elseif(Request::route('kategori') == 4)
                        <span>Multimedia</span>
                        @endif
                    </h3>
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
                                <td class="text-center">{{ $data->nama_keranjang }}</td>
                                <td class="text-center">{{ $data->total }}</td>
                                <td class="d-sm-flex justify-content-center">
                                    <button class="btn btn-primary detail-btn" title="Show"
                                        value="{{$data->kode_peminjaman}}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <input type="text" id="kategori" hidden value="{{Request::route('kategori')}}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $riwayat->links() }}
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

    setInterval(function () {
        document.getElementById('notif').click();
    }, 4000);

    $(document).on('click', '.close-mdl', function () {
        $('#detailModal').modal('hide')
    });

    $(".detail-btn").click(function () {
        $('#detailModal').modal('show')
        var did = $(this).val();
        var kid = $('#kategori').val();
        console.log(did);
        $.ajax({
            url: "{{ route('riwayat.detail') }}",
            type: "GET",
            data: {
                kode: did,
                kategori: 1
            },
            success: function (data) {
                $('#barang').html(data);
            }
        });
    });

</script>
@endsection
