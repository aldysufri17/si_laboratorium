@extends('backend.layouts.app')
@section('title', 'Detail Pengurus')
@section('content')
<div class="container-fluid">
    @include('sweetalert::alert')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Pengurus</h1>
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
        @php
        if ($user->jk == 'L') {
        $foto = 'male.svg';
        } elseif($user->jk == 'P') {
        $foto = 'female.svg';
        }
        @endphp
        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <h4 class="text-center font-weight-bold text-light">DETAIL PENGURUS</h4>
            <img class="rounded-circle my-2" width="150px"
                src="{{ asset('images/'.$foto) }}">
            @if ($user->status == 0)
            <span class="badge badge-danger">Inactive</span>
            @elseif ($user->status == 1)
            <span class="badge badge-success">Active</span>
            @endif
        </div>

        <div class="d-flex justify-content-around flex-wrap">
            <table class="table mx-5 table-striped table-dark table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">NIM</th>
                        <td>{{ $user->nim }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Jenis Kelamin</th>
                        <td>{{ $user->jk }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Alamat</th>
                        <td>{{ $user->alamat }}</td>
                    </tr>
                    <tr>
                        <th scope="row">No.Telpone</th>
                        <td>{{ $user->mobile_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pb-5 text-center">
            @role('admin')
            <a href="{{ route('operator.edit', ['operator' => encrypt($user->id)]) }}" class="btn btn-primary mx-2" title="Edit"><i
                    class="fa fa-pen"></i> Edit</a>
            @endrole
        </div>
    </div>
</div>

@endsection
