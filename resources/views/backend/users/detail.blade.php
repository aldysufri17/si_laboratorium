@extends('backend.layouts.app')
@section('title', 'Detail User')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index')}}">User</a></li>
            <li class="breadcrumb-item">Detail</li>
        </ol>
    </div>

    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <img class="rounded-circle my-2" width="150px" src="{{ asset($user->foto ? 'storage/user/'. $user->foto : 'admin/img/undraw_profile.svg') }}">
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
            <button class="btn btn-info profile-button" onclick="history.back()">Oke</button>
        </div>
    </div>
</div>
@endsection
