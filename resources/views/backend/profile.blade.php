@extends('backend.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Profil</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Profile</li>
        </ol>
    </div>

    {{-- Alert Messages --}}
    @include('sweetalert::alert')

    <div class="card shadow mb-4 border-0 bgdark">
        <div class="card-body">
            {{-- Page Content --}}
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px"
                            src="{{ asset('admin/img/undraw_profile.svg') }}">
                        <span class="font-weight-bold">{{ auth()->user()->name }}</span>
                        <span class="text-light"><i>Role:
                                {{ auth()->user()->roles
                                ? auth()->user()->roles->pluck('name')->first()
                                : 'N/A' }}</i></span>
                        <span class="text-light">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <div class="col-md-9">
                    {{-- Profile --}}
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile</h4>
                        </div>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">Nama</label>
                                    <input autocomplete="off"  type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Nama"
                                        value="{{ old('name') ? old('name') : auth()->user()->name }}">

                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Jenis Kelamin</label>
                                    <select class="form-control form-control-user @error('jk') is-invalid @enderror" name="jk">
                                        <option selected disabled>Select Jenis Kelamin</option>
                                        <option value="L" {{old('jk') ? ((old('jk') == "L") ? 'selected' : '') : ((auth()->user()->jk == "L") ? 'selected' : '')}}>Laki-Laki</option>
                                        <option value="P" {{old('jk') ? ((old('jk') == "P") ? 'selected' : '') : ((auth()->user()->jk == "P") ? 'selected' : '')}}>Perempuan</option>
                                    </select>

                                    @error('jk')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Nomor Telepon</label>
                                    <input autocomplete="off"  type="text" class="form-control @error('mobile_number') is-invalid @enderror"
                                        name="mobile_number"
                                        value="{{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}"
                                        placeholder="Nomor Telepon">
                                    @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="submit">Simpan Profile</button>
                            </div>
                        </form>
                    </div>

                    <hr>
                    {{-- Change Password --}}
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Ubah Password</h4>
                        </div>

                        <form action="{{ route('profile.change-password') }}" method="POST">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">Password Lama</label>
                                    <input autocomplete="off"  type="password" name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        placeholder="Password Lama" required>
                                    @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Password Baru</label>
                                    <input autocomplete="off"  type="password" name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror" required
                                        placeholder="Password Baru">
                                    @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Konfirmasi Password Baru</label>
                                    <input autocomplete="off"  type="password" name="new_confirm_password"
                                        class="form-control @error('new_confirm_password') is-invalid @enderror"
                                        required placeholder="Konfirmasi Password Baru">
                                    @error('new_confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-success profile-button" type="submit">Simpan Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
