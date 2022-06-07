@extends('backend.layouts.app')

@section('title', 'Scan Pengembalian')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Pengembalian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.peminjaman')}}">Daftar Peminjaman</a></li>
            <li class="breadcrumb-item">Scan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    @include('sweetalert::alert')
    @if (Session::has('clear'))
    <div class="alert alert-danger alert-dismissible shake" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Peminjaman Selesai!.</strong> {{ session('error') }}
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="text-center">
                <h2 class="text-light">Scan Pengembalian</h2>
                <p class="text-warning">== Scan Pada Qrcode Surat Peminjaman ==</p>
                <center><div id="qr-reader" style="width: 400px"></div></center>
                <video width="320" height="240" id="preview"></video>
                <audio hidden id="audio">
                    <source src="{{asset('admin/barcode.wav')}}" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    let scanner = new Instascan.Scanner({
        video: document.getElementById("preview"),
    });
    scanner.addListener("scan", function(content) {
        const data = content;

        const getid = data.substring(data.indexOf('_') + 1);
        const lower = parseInt(getid);
        var url = '{{ route("scan.store", ":lower") }}';
        url = url.replace(':lower', lower);
        document.getElementById('audio').play();
        window.location.href=url;
    });
    Instascan.Camera.getCameras()
        .then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error("No cameras found.");
            }
        })
        .catch(function(e) {
            console.error(e);
        });
</script>
@endsection
