@extends('backend.layouts.app')
@section('title', 'Detail Barang')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Detail Laboratorium</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('lab.index')}}">Daftar Barang</a></li>
            <li class="breadcrumb-item">Detail Laboratorium</li>
        </ol>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a class="btn btn-sm btn-danger" href="{{route('lab.index')}}"><i class="fas fa-angle-double-left"></i>
            Kembali</a>
    </div>

    <div class="card shadow mb-4 border-0 bgdark">
        {{-- Page Content --}}

        <div class="d-flex flex-column align-items-center text-center p-3 pt-5">
            <h4 class="text-center font-weight-bold text-light">DETAIL Laboratorium</h4>
        </div>
        <div class="d-flex justify-content-around flex-wrap">
            <table class="table mx-5 table-striped table-dark table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Nama</th>
                        <td>{{ $lab->nama }} - {{$lab->kode}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Total Barang</th>
                        <td>{{ $barang }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pb-5 text-center">
            <button class="btn btn-info profile-button" data-toggle="modal" data-target="#exampleModal"><i
                    class="fas fa-qrcode"></i> Daftar Akun</button>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bgdark">
                    <h5 class="modal-title text-light">Akun Operator {{ $lab->nama }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center bgdark">
                    <ol>
                        @foreach ($user as $item)
                        <li class="text-white">{{$item->name}} - {{$item->mobile_number}}</li>
                        @endforeach
                    </ol>
                        
                </div>
                <div class="modal-footer bgdark">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
