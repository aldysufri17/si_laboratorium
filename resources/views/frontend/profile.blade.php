@extends('frontend.layouts.app')
@section('title', 'Profile')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Profile</h2>
                <ol>
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li>Profile</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    <div class="container-fluid">
        {{-- Alert Messages --}}
        @include('sweetalert::alert')

        <div class="card shadow mb-4 border-0 bgdark">
            <div class="card-body">
                {{-- Page Content --}}
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <div class="profilepic">
                                @php
                                if (auth()->user()->jk == 'L') {
                                    $foto = 'male.svg';
                                } elseif(auth()->user()->jk == 'P') {
                                    $foto = 'female.svg';
                                }
                                @endphp
                                <img class="rounded-circle my-2 profilepic__image" width="150px"
                                    src="{{ asset(auth()->user()->foto ? 'images/user/'. auth()->user()->foto : 'images/'. $foto) }}">
                                <div class="profilepic__content">
                                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                                        data-target="#exampleModal"><i class="fas fa-camera"></i>
                                    </button>
                                    <span class="profilepic__text">Edit Profile</span>
                                </div>
                            </div>

                            <span class="font-weight-bold">{{ auth()->user()->name }}</span>
                            <span class="text-dark">Nim : {{ auth()->user()->nim }}</span>
                            <span class="text-dark">Email : {{ auth()->user()->email }}</span>
                            <div class="mt-2 text-center">
                                <button class="btn btn-secondary profile-button" data-toggle="modal"
                                    data-target="#ktmModal">Lihat KTM</button>
                            </div>

                        </div>
                    </div>

                    {{-- Modal KTM --}}
                    <div class="modal fade" id="ktmModal" tabindex="-1" role="dialog" aria-labelledby="ktmModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ktmModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img class="my-2" width="450px"
                                        src="{{ asset(auth()->user()->ktm ? 'images/user/ktm/'. auth()->user()->ktm : 'images/empty.jpg') }}">
                                    <form action="{{route('profile.ktm')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="ktm">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Update Foto --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img class="rounded-circle my-2 profilepic__image" width="150px"
                                        src="{{ asset(auth()->user()->foto ? 'storage/user/'. auth()->user()->foto : 'admin/img/undraw_profile.svg') }}">
                                    <form action="{{route('profile.foto')}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="foto">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        {{-- Profile --}}
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Edit Profile</h4>
                            </div>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="labels">Nama</label>
                                        <input autocomplete="off" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Nama"
                                            value="{{ old('name') ? old('name') : auth()->user()->name }}">

                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="labels">Jenis Kelamin</label>
                                        <select class="form-control form-control-user @error('jk') is-invalid @enderror"
                                            name="jk">
                                            <option selected disabled>Select Jenis Kelamin</option>
                                            <option value="L"
                                                {{old('jk') ? ((old('jk') == "L") ? 'selected' : '') : ((auth()->user()->jk == "L") ? 'selected' : '')}}>
                                                Laki-Laki</option>
                                            <option value="P"
                                                {{old('jk') ? ((old('jk') == "P") ? 'selected' : '') : ((auth()->user()->jk == "P") ? 'selected' : '')}}>
                                                Perempuan</option>
                                        </select>

                                        @error('jk')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="labels">Nomor Telepon</label>
                                        <input autocomplete="off" type="text"
                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                            name="mobile_number"
                                            value="{{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}"
                                            placeholder="Nomor Telepon">
                                        @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="labels">Alamat</label>
                                        <input autocomplete="off" type="text"
                                            class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                            value="{{ old('alamat') ? old('alamat') : auth()->user()->alamat }}"
                                            placeholder="Alamat">
                                        @error('alamat')
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
                                        <input autocomplete="off" type="password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            placeholder="Password Lama" required>
                                        @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="labels">Password Baru</label>
                                        <input autocomplete="off" type="password" name="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror" required
                                            placeholder="Password Baru">
                                        @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="labels">Konfirmasi Password Baru</label>
                                        <input autocomplete="off" type="password" name="new_confirm_password"
                                            class="form-control @error('new_confirm_password') is-invalid @enderror"
                                            required placeholder="Konfirmasi Password Baru">
                                        @error('new_confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="btn btn-success profile-button" type="submit">Simpan
                                        Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
