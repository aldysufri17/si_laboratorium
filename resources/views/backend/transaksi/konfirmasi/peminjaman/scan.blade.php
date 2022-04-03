@extends('backend.layouts.app')

@section('title', 'Scan Peminjaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Peminjaman</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konfirmasi.peminjaman')}}">Filter Peminjaman</a></li>
            <li class="breadcrumb-item">Scan</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('konfirmasi.peminjaman') }}" class="btn btn-sm btn-danger">
            <i class="fas fa-angle-double-left"></i> Kembali
        </a>
    </div>

    @include('sweetalert::alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            <div class="text-center">
                <h2 class="text-light">Scan Persetujuan Peminjaman</h2>
                <p class="text-warning">== Scan Pada Barcode Surat Peminjaman ==</p>
                <center><div id="qr-reader" style="width: 400px"></div></center>
                <input type="text" id="in" hidden>
                <audio hidden id="audio">
                    <source src="{{asset('admin/barcode.wav')}}" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
<script type="text/javascript">
function onScanSuccess(id) {
    document.getElementById("in").value = id;
    document.getElementById('audio').play();
    var url = '{{ route("scan.store", [":id", 1]) }}';
        url = url.replace(':id', document.getElementById("in").value);
        window.location.href=url;
}
var html5QrcodeScanner = new Html5QrcodeScanner(
	"qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection
