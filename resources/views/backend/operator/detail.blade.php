@extends('backend.layouts.app')
@section('title', 'Detail User')
@section('content')
<div class="container-fluid">
    @include('sweetalert::alert')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index')}}">User</a></li>
            <li class="breadcrumb-item">Detail</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{ route('operator.index') }}"><i class="fas fa-angle-double-left"></i> Kembali</a>
    </div>
    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <img class="rounded-circle my-2" width="150px" src="{{ asset('admin/img/undraw_profile.svg') }}">
            @if ($user->status == 0)
            <span class="badge badge-danger">Inactive</span>
            @elseif ($user->status == 1)
            <span class="badge badge-success">Active</span>
            @endif
        </div>
        <div class="d-flex text-center justify-content-around flex-wrap pt-5">
            <p class="text-light mx-5"><strong>Nama: </strong><br>{{ $user->name }}</p>
            <p class="text-light mx-5"><strong>Jenis Kelamin: </strong><br>{{ $user->jk }}</p>
            <p class="text-light mx-5"><strong>NIM: </strong><br>{{ $user->nim }}</p>
            <p class="text-light mx-5"><strong>Email: </strong><br>{{ $user->email }}</p>
            <p class="text-light mx-5"><strong>Alamat: </strong><br>{{ $user->alamat }}</p>
            <p class="text-light mx-5"><strong>No.Telp: </strong><br>{{ $user->mobile_number }}</p>
        </div>
        <div class="pb-5 text-center">
            <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#reset">
                <i class="fa-solid fa-clock-rotate-left"></i> Reset Password
            </a>
        </div>
    </div>
</div>
<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="resetExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bgdark shadow-2-strong ">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="resetExample">Anda yakin ingin reset password {{$user->name}}?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body border-0 text-light">Jika anda yakin ingin Reset, Tekan Oke !!</div>
            <div class="modal-footer border-0">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-reset-form').submit();">
                    Oke
                </a>
                <form id="user-reset-form" method="POST" action="{{ route('users.reset', ['user' => $user->id, 'name' => $user->name]) }}">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
