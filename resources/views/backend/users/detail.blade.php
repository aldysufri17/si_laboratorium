@extends('backend.layouts.app')
@section('title', 'Detail Pengguna')
@section('content')
<div class="container-fluid">
    @include('sweetalert::alert')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Pengguna</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Daftar User</a></li>
            <li class="breadcrumb-item">Detail Pengguna</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{ route('users.index') }}"><i class="fas fa-angle-double-left"></i> Kembali</a>
    </div>

    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <img class="rounded-circle my-2" width="150px" src="{{ asset($user->foto ? 'images/user/'. $user->foto : 'admin/img/undraw_profile.svg') }}">
            @if ($user->status == 0)
            <span class="badge badge-danger">Inactive</span>
            @elseif ($user->status == 1)
            <span class="badge badge-success">Active</span>
            @endif
        </div>
        <div class="d-flex text-center justify-content-around flex-wrap">
            <p class="text-light mx-5"><strong>Nama: </strong><br>{{ $user->name }}</p>
            <p class="text-light mx-5"><strong>Jenis Kelamin: </strong><br>{{ $user->jk }}</p>
            <p class="text-light mx-5"><strong>NIM: </strong><br>{{ $user->nim }}</p>
            <p class="text-light mx-5"><strong>Email: </strong><br>{{ $user->email }}</p>
            <p class="text-light mx-5"><strong>Alamat: </strong><br>{{ $user->alamat }}</p>
            <p class="text-light mx-5"><strong>No.Telp: </strong><br>{{ $user->mobile_number }}</p>
        </div>
        <div class="pb-5 text-center">
            <button class="btn btn-info profile-button" data-toggle="modal" data-target="#ktmModal"><i class="fa-solid fa-address-card"></i> Lihat KTM</button>
            @role('admin')
            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary mx-2" title="Edit"><i class="fa fa-pen"></i> Edit</a>
            @endrole
        </div>
    </div>
</div>

{{-- Ktm --}}
<div class="modal fade" id="ktmModal" tabindex="-1" role="dialog" aria-labelledby="ktmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="ktmModalLabel">KTM {{$user->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="my-2" width="450px"
                    src="{{ asset($user->ktm ? 'images/user/ktm/'. $user->ktm : 'images/empty.jpg') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
