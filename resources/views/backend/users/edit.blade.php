@extends('backend.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Edit Pengguna</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users')}}">Daftar Pengguna</a></li>
            <li class="breadcrumb-item">Edit Pengguna</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card bgdark border-0 shadow mb-4">
        <form method="POST" action="{{route('users.update', ['user' => $user->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-light">Edit Pengguna</h6>
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleName"
                            placeholder="Nama" name="name" value="{{ old('name') ?  old('name') : $user->name}}">

                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- JK --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Kelamin</label>
                        <select class="form-control form-control-user @error('jk') is-invalid @enderror" name="jk">
                            <option selected disabled>Select Jenis Kelamin</option>
                            <option value="L"
                                {{old('jk') ? ((old('jk') == "L") ? 'selected' : '') : (($user->jk == "L") ? 'selected' : '')}}>
                                Laki-Laki</option>
                            <option value="P"
                                {{old('jk') ? ((old('jk') == "P") ? 'selected' : '') : (($user->jk == "P") ? 'selected' : '')}}>
                                Perempuan</option>
                        </select>
                        @error('jk')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Email</label>
                        <input autocomplete="off" type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror"
                            id="exampleEmail" placeholder="Email" name="email"
                            value="{{ old('email') ? old('email') : $user->email }}">

                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Alamat</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('alamat') is-invalid @enderror"
                            id="exampleAlamat" placeholder="Alamat" name="alamat"
                            value="{{ old('alamat') ? old('alamat') : $user->alamat }}">

                        @error('alamat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- NIM --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>NIM</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('nim') is-invalid @enderror" id="exampleNim"
                            placeholder="NIM" name="nim" value="{{ old('nim') ? old('nim') : $user->nim }}">

                        @error('nim')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Mobile Number --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No.Telp</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                            id="exampleMobile" placeholder="No.Telp" name="mobile_number"
                            value="{{ old('mobile_number') ? old('mobile_number') : $user->mobile_number }}">

                        @error('mobile_number')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror"
                            name="status">
                            <option selected disabled>Select Status</option>
                            <option value="1"
                                {{old('role') ? ((old('role') == 1) ? 'selected' : '') : (($user->status == 1) ? 'selected' : '')}}>
                                Active</option>
                            <option value="0"
                                {{old('role') ? ((old('role') == 0) ? 'selected' : '') : (($user->status == 0) ? 'selected' : '')}}>
                                Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- foto --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto">
                    </div>

                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('users.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>


@endsection
