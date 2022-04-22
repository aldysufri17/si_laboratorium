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
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        @foreach ($cart as $data)
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                        <img src="{{ asset($data->barang->gambar ? 'images/barang/'. $data->barang->gambar : 'images/empty.jpg') }}"
                                            class="img-fluid rounded-3">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                        <p class="lead font-weight-bold mb-2">{{$data->barang->nama}} -
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
                                        <button class="btn btn-link px-2" id="min" value="{{$data->id}}">
                                          <i class="fas fa-minus"></i>
                                        </button>
                        
                                        <input id="jumlah" min="0" name="quantity" value="{{$data->jumlah}}" type="number"
                                          class="form-control form-control-sm" />
                        
                                        <button class="btn btn-link px-2" id="plus" value="{{$data->id}}">
                                          <i class="fas fa-plus"></i>
                                        </button>
                                      </div>
                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                        <a class="btn" title="Form"
                                            href="{{route('form.pengajuan', $data->barang->id)}}">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <button class="btn delete-btn" title="Delete" value="{{$data->id}}">
                                            <i class="fas fa-trash fa-lg text-danger"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $cart->links() }}
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

    $(document).on('click', '#plus', function () {
        var id = $(this).val()
        console.log(id);

        $.ajax({
            url: "{{ route('cart.jumlah') }}",
            type: "GET",
            data: {
                plus: id
            },
            success: function (data) {
                $('#jumlah').val(data);
                location.reload();
            }
        });
    });
    $(document).on('click', '#min', function () {
        var id = $(this).val()
        console.log(id);
        $.ajax({
            url: "{{ route('cart.jumlah') }}",
            type: "GET",
            data: {
                min: id
            },
            success: function (data) {
                $('#jumlah').val(data);
                location.reload();
            }
        });
    });
</script>
@endsection
