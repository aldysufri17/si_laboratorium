@extends('frontend.layouts.app')
@section('title', 'Surat Bebas Laboratorium')
@section('content')
@if ($message = Session::get('gagal_surat'))
<div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>{{ $message }}</strong> {{ session('error') }}
</div>
@endif
@include('sweetalert::alert')

<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Surat Bebas Laboratorium</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Surat Bebas Laboratorium</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    {{-- Pengajuan Disetujui --}}
    @foreach ($setujui as $data)
    <a href="{{route('cart')}}">
        @if ($message = Session::get('in'))
        <div class="alert alert-success alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Pengajuan Surat {{ $message }}</strong> {{ session('error') }}
        </div>
        @endif
    </a>
    @endforeach
    {{-- end diseujui --}}

    {{-- Pengajuan ditolak --}}
    @foreach ($tolak as $data)
    <a href="{{route('cart')}}">
        @if ($message = Session::get('tolak'))
        <div class="alert alert-danger alert-dismissible shake" style="margin-bottom: -6px; margin:0 5px" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Pengajuan Surat {{ $message }}</strong> {{ session('error') }}
        </div>
        @endif
    </a>
    @endforeach
    {{-- end ditolak--}}
    <section id="portfolio-details" class="portfolio-details">
        @if ($surat->isNotEmpty())
        <div class="card shadow mx-5 px-3 mb-4 border-0">
            <div class="ml-4 mt-3 mb-3">
                <a class="btn btn-success" href="#" data-toggle="modal" data-target="#formModal">
                    <i class="fa-solid fa-square-plus"></i> Buat Surat
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="10%">Nama</th>
                                <th width="10%">Nim</th>
                                <th width="15%">Nomor Telepon</th>
                                <th width="15%">Alamat</th>
                                <th width="15%" class="text-center">Tracking</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($surat as $data)
                                <td>{{$data->created_at}}</td>
                                <td>{{$data->user->name}}</td>
                                <td>{{$data->user->nim}}</td>
                                <td>{{$data->user->mobile_number}}</td>
                                <td>{{$data->user->alamat}}</td>
                                <td>
                                    <div class="d-flex">
                                        @if($data->status == 0)
                                        <div class="circle">
                                            <center><span class="dot text-center"
                                                    style="border: 2px solid rgb(0, 185, 40);">
                                                    <p>1</p>
                                                </span></center>
                                            <p class="text-center" style="font-size: 12px; color: rgb(0, 185, 40)">
                                                PENGAJUAN</p>
                                        </div>
                                        <div class="circle mx-2">
                                            <center><span class="dot text-center">2</span></center>
                                            <p class="text-center" style="font-size: 12px">DITOLAK</p>
                                        </div>
                                        <div class="circle">
                                            <center><span class="dot text-center">3</span></center>
                                            <p class="text-center" style="font-size: 12px">DISETUJUI</p>
                                        </div>
                                        {{-- diTolak --}}
                                        @elseif($data->status == 1)
                                        <div class="circle">
                                            <center><span class="dot text-center"
                                                    style="border: 2px solid rgb(0, 185, 40);">
                                                    <p>1</p>
                                                </span></center>
                                            <p class="text-center" style="font-size: 12px; color: rgb(0, 185, 40)">
                                                PENGAJUAN</p>
                                        </div>
                                        <div class="circle mx-2">
                                            <center><span class="dot text-center"
                                                    style="border: 2px solid rgb(214, 0, 0);">
                                                    <p style="color: rgb(214, 0, 0)">2</p>
                                                </span></center>
                                            <p class="text-center" style="font-size: 12px; color: rgb(214, 0, 0)">
                                                DITOLAK</p>
                                        </div>
                                        <div class="circle">
                                            <center><span class="dot text-center">3</span></center>
                                            <p class="text-center" style="font-size: 12px">DISETUJUI</p>
                                        </div>

                                        {{-- diSetujui --}}
                                        @elseif($data->status == 2)
                                        <div class="circle">
                                            <center><span class="dot text-center"
                                                    style="border: 2px solid rgb(0, 185, 40);">
                                                    <p>1</p>
                                                </span></center>
                                            <p class="text-center" style="font-size: 12px; color: rgb(0, 185, 40)">
                                                PENGAJUAN</p>
                                        </div>
                                        <div class="circle mx-2">
                                            <center><span style="border: 2px solid rgb(133, 133, 133); color:rgb(133, 133, 133)" class="dot text-center">2</span></center>
                                            <p class="text-center" style="font-size: 12px; color:rgb(133, 133, 133)">DITOLAK</p>
                                        </div>
                                        <div class="circle">
                                            <center><span class="dot text-center"
                                                    style="border: 2px solid rgb(0, 185, 40);">
                                                    <p>3</p>
                                                </span></center>
                                            <p class="text-center" style="font-size: 12px; color: rgb(0, 185, 40)">
                                                DISETUJUI</p>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($unduh)
                                    <a href="{{route('surat.show', ['surat' => $data->id])}}"
                                        class="btn btn-primary mx-2" title="Unduh">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    @endif
                                    <a class="btn btn-danger" href="#" data-toggle="modal" title="Delete"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    {{ $surat->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bgdark shadow-2-strong ">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-light" id="deleteModalExample"><strong>Anda yakin ingin
                                Menghapus?</strong>
                        </h5>
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
                            action="{{route('surat.destroy', ['surat' => $data->id])}}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="ml-4 mt-3 mb-3">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#formModal">
                <i class="fa-solid fa-square-plus"></i> Buat Surat
            </a>
        </div>
        <div class="card shadow-sm p-3 mx-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
            <div class="card-block">
                <span class="">Oops!</span><br>
                <p><i class="fa-solid fa-circle-info text-primary"></i> Belum Terdapat Surat Bebas Laboratorium</p>
            </div>
        </div>
        @endif
    </section>
</main><!-- End #main -->
{{-- form modal --}}
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="formModalExample"><strong>Form Pengajuan Surat Bebas Lab</strong>
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-dark">
                <p class="text-danger mb-0">* Isi data sesuai profile akun</p>
                <form method="POST" action="{{route('surat.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="row">
                            <div class="col">
                                <span>Nama</span>
                                <input type="text" name="nama" class="form-control mt-2" readonly
                                    value="{{auth()->user()->name}}" placeholder="Name">
                            </div>
                            <div class="col">
                                <span>Nim</span>
                                <input type="text" name="nim" class="form-control mt-2" readonly
                                    value="{{auth()->user()->nim}}" placeholder="NIM">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span>Nomor Telepon</span>
                                <input type="text" name="mobile_number" class="form-control mt-2" readonly
                                    value="{{auth()->user()->mobile_number}}" placeholder="Jenis kelamin">
                            </div>
                            <div class="col">
                                <span>Alamat</span>
                                <input type="text" name="alamat" class="form-control mt-2" readonly placeholder="Alamat"
                                    value="{{auth()->user()->alamat}}">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Buat</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
