@extends('backend.layouts.app')

@section('title', 'Tambah Master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Master</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/operator')}}">Master</a></li>
            <li class="breadcrumb-item">Form Tambah Master</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('operator.store')}}">
            @csrf
            <div class="card-body ">
                <h6 class="m-0 font-weight-bold text-light">Form Tambah Master Baru</h6>
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                            autocomplete="off" id="exampleName" placeholder="Nama" name="name"
                            value="{{ old('name') }}">

                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- JK --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Kelamin</label>
                        <select class="form-control form-control-user @error('jk') is-invalid @enderror" name="jk">
                            <option selected disabled>Select Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jk')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Email</label>
                        <input type="email" class="form-control  form-control-user @error('email') is-invalid @enderror"
                            autocomplete="off" id="exampleEmail" autocomplete="off" placeholder="Email" name="email"
                            value="{{ old('email') }}">

                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Alamat</label>
                        <input type="text" class="form-control form-control-user @error('alamat') is-invalid @enderror"
                            autocomplete="off" id="exampleAlamat" placeholder="Alamat" name="alamat"
                            value="{{ old('alamat') }}">

                        @error('alamat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Mobile Number --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No.Telp</label>
                        <input type="text"
                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                            autocomplete="off" id="exampleMobile" placeholder="No.Telp" name="mobile_number"
                            value="{{ old('mobile_number') }}">

                        @error('mobile_number')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Role</label>
                        <select class="form-control form-control-user @error('role_id') is-invalid @enderror"
                            name="role_id">
                            <option selected disabled>Pilih Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Operator</option>
                        </select>
                        @error('role_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror"
                            name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('operator.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>


@endsection
