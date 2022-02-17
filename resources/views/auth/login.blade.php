@extends('auth.layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center" style="margin-top: 35px ">

        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card bgdark o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h4 class="text-light" style="margin-bottom: 1px">Selamat Datang</h4>
                                    <a class="small" href="{{route('daftar')}}">Belum Punya akun?</a>
                                </div>

                                @if (session('error'))
                                <span class="text-danger"> {{ session('error') }}</span>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input autocomplete="off" id="email" type="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus placeholder="Email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input autocomplete="off" id="password" type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password"
                                            placeholder="Password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input class="custom-control-input" type="checkbox" name="remember"
                                                id="customCheck" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{route('password.request')}}">Lupa Password?</a><br>                                   
                                    <a class="small" href="{{url('/')}}"><i class="fas fa-fw fa-home"></i> Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
