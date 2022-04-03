@extends('backend.layouts.app')
@section('title', 'Detail Pengurus')
@section('content')
<div class="container-fluid">
    @include('sweetalert::alert')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('operator.index')}}">Daftar Pengurus</a></li>
            <li class="breadcrumb-item">Detail Pengurus</li>
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
            <a href="{{ route('operator.edit', ['operator' => $user->id]) }}"
                class="btn btn-primary mx-2" title="Edit"><i class="fa fa-pen"></i> Edit</a>
        </div>
    </div>
</div>

@endsection
