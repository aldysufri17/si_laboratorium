@extends('frontend.layouts.app')
@section('title', 'Keranjang Pengajuan')
@section('content')


<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Keranjang Pengajuan</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Keranjang Pengajuan</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    @include('sweetalert::alert')

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">

        @if ($cart->isNotEmpty())
        <div class="card shadow mx-5 py-3 mb-4 border-0">
            {{-- <div class="d-sm-flex mx-4 mt-4 justify-content-end">
                <a class="btn btn-info" href="{{route('daftar.riwayat')}}">
            Lihat Barang Pinjaman Saya <i class="fas fa-angle-double-right"></i>
            </a>
        </div> --}}
        <div class="card-body mx-5">
            <center>
                <h3>Keranjang Pengajuan Barang</h3>
            </center>
            <div class="container h-100 py-3">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    @foreach ($cart as $data)
                    <div class="card rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-1 col-lg-1 col-xl-1 text-center">
                                    <input type="checkbox" name="" id="">
                                </div>
                                <div class="col-md-2 col-lg-2 col-xl-2">
                                    <img src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                        class="img-fluid rounded-3">
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <p class="lead fw-normal mb-2">{{$data->barang->nama}} - {{$data->barang->tipe}}</p>
                                    <p><span class="text-muted">Kategori Lab:<br> </span>
                                        @if ($data->barang->kategori_lab == 1)
                                        Laboratorium Sistem Tertanam dan Robotika
                                        @elseif ($data->barang->kategori_lab == 2)
                                        Laboratorium Rekayasa Perangkat Lunak
                                        @elseif($data->barang->kategori_lab == 3)
                                        Laboratorium Jaringan dan Keamanan Komputer
                                        @elseif($data->barang->kategori_lab == 4)
                                        Laboratorium Multimedia
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                    <button id="minus" class="btn btn-link px-2">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <input id="form1" min="0" name="quantity" value="" type="number"
                                        class="form-control form-control-sm" />

                                    <button id="plus" class="btn btn-link px-2">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                    <a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-warning btn-block btn-lg">Proceed to Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bgdark shadow-2-strong ">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-light" id="deleteModalExample">Anda yakin ingin Menghapus?
                        </h5>
                        <button class="close close-mdl" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body border-0 text-dark">Jika anda yakin ingin manghapus, Tekan Oke !!
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-danger close-mdl" type="button" data-dismiss="modal">Batal</button>
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
        @else
        <div class="mx-4 mb-3 d-sm-flex justify-content-between">
            <a class="btn btn-success" href="{{url('/search')}}">
                <i class="fa-solid fa-magnifying-glass"></i> Pencarian Barang
            </a>
            <a class="btn btn-info" href="{{route('daftar.riwayat')}}">
                Peminjaman Saya <i class="fas fa-angle-double-right"></i>
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
        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });
        $(document).on('click', '.close-mdl', function () {
            $('#deleteModal').modal('hide')
        });
    });
    setTimeout(function () {
        document.getElementById('notif').click();
    }, 4000);






    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var incre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(incre_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value < 10) {
            value++;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }

    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var decre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(decre_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }
    });

    let a = 1;
    $('#plus').click(function (e) {
        a++;
        document.getElementById('num').value = a
    });

</script>
@endsection
