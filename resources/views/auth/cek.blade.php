@extends('auth.layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
            <div class="card o-hidden border-0 shadow-lg mt-5">
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
</div>
@endsection
