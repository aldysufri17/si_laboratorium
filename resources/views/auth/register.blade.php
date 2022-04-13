@extends('auth.layouts.app')
@section('title', 'Registrasi')

@section('content')
<div class="container mt-1 h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
            <div class="card bgdark shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body px-2 p-md-4">
                    <h3 class="mb-4 pb-2 pb-md-0 text-light mb-md-5">Form Registrasi</h3>
                    @if (session('error'))
                    <span class="text-danger"> {{ session('error') }}</span>
                    @endif
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="name">{{ __('Nama') }}</label>
                                <div class="form-outline">
                                    <input autocomplete="off" id="name" type="text"
                                        class="form-control  @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="jk">{{ __('Jenis Kelamin') }}</label>
                                <div class="form-outline">
                                    <select id="jk"
                                        class="form-control form-control-user @error('jk') is-invalid @enderror"
                                        name="jk" value="{{ old('jk') }}" required>
                                        <option selected disabled>Select Jenis Kelamin</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>`
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="nim">{{ __('NIM') }}</label>

                                <div class="form-outline">
                                    <input autocomplete="off" id="nim" type="nim"
                                        class="form-control @error('nim') is-invalid @enderror" name="nim"
                                        value="{{ old('nim') }}" required autocomplete="nim">

                                    @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                                <div class="form-outline">
                                    <input autocomplete="off" id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="form-outline">
                                    <input autocomplete="off" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        value="{{ old('password') }}" required autocomplete="password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                                <div class="form-outline">
                                    <input autocomplete="off" id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="alamat" class="form-label">{{ __('Alamat') }}</label>

                                <div class="form-outline">
                                    <input autocomplete="off" id="alamat" type="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                        value="{{ old('alamat') }}" required autocomplete="alamat">

                                    @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="telp" class="form-label">{{ __('No Telepone') }}</label>

                                <div class="form-outline">
                                    <input autocomplete="off" id="telp" type="telp"
                                        class="form-control @error('telp') is-invalid @enderror" name="telp"
                                        value="{{ old('telp') }}" required autocomplete="telp">

                                    @error('telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            {{ __('Kirim') }}
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Sudah punya akun?<a href="{{url('login')}}"> Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
