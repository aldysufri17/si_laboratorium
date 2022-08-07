@extends('backend.layouts.app')

@section('title', 'Edit Pengurus')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Edit Pengurus</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/operator')}}">Daftar Pengurus</a></li>
            <li class="breadcrumb-item">Edit Pengurus</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 bgdark border-0">
        <form method="POST" action="{{route('operator.update', $operator->id)}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-light">Edit Pengurus</h6>

                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleName"
                            placeholder="Nama" name="name" value="{{ old('name') ?  old('name') : $operator->name}}">

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
                                {{old('jk') ? ((old('jk') == "L") ? 'selected' : '') : (($operator->jk == "L") ? 'selected' : '')}}>
                                Laki-Laki</option>
                            <option value="P"
                                {{old('jk') ? ((old('jk') == "P") ? 'selected' : '') : (($operator->jk == "P") ? 'selected' : '')}}>
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
                            value="{{ old('email') ? old('email') : $operator->email }}">

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
                            value="{{ old('alamat') ? old('alamat') : $operator->alamat }}">

                        @error('alamat')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Mobile Number --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No.Telp</label>
                        <input autocomplete="off" type="text"
                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                            id="exampleMobile" placeholder="No.Telp" name="mobile_number"
                            value="{{ old('mobile_number') ? old('mobile_number') : $operator->mobile_number }}">

                        @error('mobile_number')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Role --}}
                    {{-- Role --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Role</label>
                        <select id="select"
                            class="form-control slc form-control-user @error('role') is-invalid @enderror"
                            name="role">
                            <option selected disabled>Pilih Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}" {{$role->id == $operator->role?'selected':''}}>
                                {{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role')
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
                                {{old('role') ? ((old('role') == 1) ? 'selected' : '') : (($operator->status == 1) ? 'selected' : '')}}>
                                Active</option>
                            <option value="0"
                                {{old('role') ? ((old('role') == 0) ? 'selected' : '') : (($operator->status == 0) ? 'selected' : '')}}>
                                Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Hak akses --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0" id="operator">
                        <span style="color:red;">*</span>Pilih Hak Akses Operator</label>
                        <select required class="form-control form-control-user @error('laboratorium_id') is-invalid @enderror"
                            name="laboratorium_id">
                            <option selected disabled>Pilih Hak Akses</option>
                            @foreach ($laboratorium as $lab)
                            <option value="{{$lab->id}}" {{$lab->id == $operator->laboratorium_id ? 'selected' : ''}}>
                                {{$lab->nama}}</option>
                            @endforeach
                        </select>
                        @error('laboratorium_id')
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
@section('scripts')
<script>
    $('#operator').hide();
    console.log($('#select').val());
    if ($('#select').val() == 3) {
        $('#operator').show();
    } 
    $(document).on('change', '.slc', function () {
        var select = $('#select option:selected').val()
        if (select == 3) {
            $('#operator').show();
        } else {
            $('#operator').hide();
        }
    });

</script>
@endsection
