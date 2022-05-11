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
    </section>
    <!-- Breadcrumbs Section -->
    @include('sweetalert::alert')
    @if ($message = Session::get('max'))
    <div class="alert alert-warning alert-dismissible shake" role="alert">
        <button type="button" id="notif" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif

    @if ($message = Session::get('form'))
    <div class="alert alert-warning alert-dismissible shake" role="alert">
        <button type="button" id="notif" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>{{ $message }}</strong> {{ session('error') }}
    </div>
    @endif
    <section id="portfolio-details" class="portfolio-details">

        @if ($cart->isNotEmpty())
        <div class="card shadow mx-5 py-3 mb-4 border-0">
            <div class="d-sm-flex justify-content-between mb-2 p-2">
                <a href="{{url('/search')}}" class="btn btn-success btn-user float-right mb-3"> <i
                        class="fas fa-plus"></i>
                    Tambah Barang</a>
                <a href="{{route('daftar.pinjaman')}}" class="btn btn-info btn-user float-right mb-3">Lihat Barang
                    Pinjaman
                    Saya <i class="fas fa-clipboard-list"></i></a>
            </div>
            <div class="card-body mx-5">
                <center>
                    <h3>Keranjang Pengajuan Barang</h3>
                </center>
                <div class="container h-100 py-3">
                    <form action="{{route('checkout', auth()->user()->id)}}" method="post">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0"
                                    width="100%">
                                    <thead >
                                        <tr >
                                            <th style="border:none" width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $data)
                                        <tr>
                                            <td>
                                                <div class="card rounded-3 mb-4">
                                                    <div class="card-body p-4">
                                                        <div
                                                            class="row d-flex justify-content-between align-items-center">
                                                            <div class="col-md-1 col-lg-1 col-xl-1">
                                                                <input style="border: 1px solid black"
                                                                    class="form-check-input checkbox" type="checkbox"
                                                                    id="" name="ckd_chld[]" value="{{$data->id}}">
                                                            </div>
                                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                                <img src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                                                    class="img-fluid rounded-3">
                                                            </div>
                                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                                <p class="lead font-weight-bold mb-2">
                                                                    {{$data->barang->nama}} -
                                                                    {{$data->barang->tipe}}
                                                                </p>
                                                                <p> <span
                                                                        class="badge badge-secondary">{{$data->barang->kategori->nama_kategori}}</span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-2 col-lg-2 col-xl-2 text-center">
                                                                <p><span class="text-muted">Kategori Lab:<br> </span>
                                                                    @if ($data->barang->kategori_lab == 1)
                                                                    Sistem Tertanam dan Robotika
                                                                    @elseif ($data->barang->kategori_lab == 2)
                                                                    Rekayasa Perangkat Lunak
                                                                    @elseif($data->barang->kategori_lab == 3)
                                                                    Jaringan dan Keamanan Komputer
                                                                    @elseif($data->barang->kategori_lab == 4)
                                                                    Multimedia
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                                {{-- <button type="button" class="btn btn-link px-2"
                                                                    id="minus" value="{{$data->id}}">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>

                                                                <input id="jumlah" min="0" name="quantity"
                                                                    value="{{$data->jumlah}}" type="number" readonly
                                                                    class="form-control form-control-sm" />

                                                                <button type="button" class="btn btn-link px-2"
                                                                    id="plus" value="{{$data->id}}">
                                                                    <i class="fas fa-plus"></i>
                                                                </button> --}}
                                                                <p><span class="text-muted">Jumlah:<br> </span>
                                                                    {{$data->jumlah}}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                                {{-- <a class="btn" title="Form"
                                                        href="{{route('form.pengajuan', $data->barang->id)}}">
                                                                <i class="fas fa-edit text-primary"></i>
                                                                </a> --}}
                                                                <button type="button" class="btn delete-btn"
                                                                    title="Delete" value="{{$data->id}}">
                                                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        {{-- @if ($data->tgl_start == null || $data->tgl_end == null || $data->jumlah == null ||
                                            $data->kategori_lab == null || $data->alasan == null)
                                            <div class="text-center font-weight-bold text-danger shake">== Form Penggunaan Belum diisi
                                                ==</div>
                                            @endif --}}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <button type="button" id="off"
                                            class="btn btn-warning btn-block btn-lg">Checkout</button>
                                    </div>
                                </div>
                            </div>
                            {{-- {{ $cart->links() }} --}}
                        </div>
                        {{-- Modal Checkout --}}
                        <div class="modal fade" id="ckdModal" tabindex="-1" role="dialog"
                            aria-labelledby="ckdModalExample" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bgdark shadow-2-strong ">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-light" id="ckdModalExample">Anda yakin ingin
                                            Checkout?
                                        </h5>
                                        <button class="close close-mdl" type="button" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body border-0 text-dark">Jika anda yakin, Tekan
                                        Oke !!
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button class="btn btn-danger close-mdl" type="button"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" id="off" class="btn btn-warning">Oke</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                action="{{ route('cart.destroy', ['id' => $data->id]) }}">
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
                <a class="btn btn-info" href="{{route('daftar.pinjaman')}}">
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
    </section>
</main>
@endsection

@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js" type="text/javascript">
</script>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
            "ordering": false
        });

        $(document).on('click', '.delete-btn', function () {
            var sid = $(this).val();
            $('#deleteModal').modal('show')
            $('#delete_id').val(sid)
        });
        $(document).on('click', '.close-mdl', function () {
            $('#deleteModal').modal('hide')
            $('#ckdModal').modal('hide')

        });

        $(document).on('click', '#off', function () {
            $('#ckdModal').modal('show')
            // alert('heho');
        });

        setTimeout(function () {
            document.getElementById('notif').click();
        }, 4000);

        $("#off").attr("disabled", true);

        $(function () {
            $('.checkbox').click(function () {
                if ($('.checkbox:checked').length > 0) {
                    $('#off').removeAttr('disabled');
                } else {
                    $('#off').attr('disabled', 'disabled');
                }
            });
        });

        $(document).on('click', '#minus', function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('keranjang.dec') }}",
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
                url: "{{ route('keranjang.inc') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function (data) {
                    location.reload();
                }
            });
        });
    });

</script>
@endsection
