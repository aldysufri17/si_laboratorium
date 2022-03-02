@extends('backend.layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Pengembalian</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.pengembalian')}}">Pengembalian</a></li>
            <li class="breadcrumb-item">Scan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.pengembalian') }}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="text-center">
                <h1 class="text-light">Scan Pengembalian</h1>
                <p class="text-warning">== Scan Pada Qr Code Surat Peminjaman ==</p>
                <video width="520" height="340" id="preview"></video>
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
        const lower = content.toLowerCase();
        var url = '{{ route("scan", ":lower") }}';
        url = url.replace(':lower', lower);
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
