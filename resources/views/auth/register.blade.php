@extends('auth.layouts.app')
@section('title', 'Registrasi')

@section('content')
<div class="container" id="cek">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="card bgdark o-hidden border-0 shadow-lg mt-5">
            <div class="card-body p-10">
                <div class="text-center">
                    <h1>Scan Registrasi</h1>
                    <p style="color: red">== Scan KTM anda, sebagai tanda bukti warga TEKKOM ==</p>
                    <video id="preview"></video>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 h-100" id="formregistrasi" style="display: none">
</div>
@endsection