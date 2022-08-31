@extends('backend.layouts.app')

@section('title', 'Barang Dipinjam')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Barang Dipinjam</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item">Barang Dipinjam</li>
        </ol>
    </div>
    @if ($barang->isNotEmpty())
    <div class="card shadow border-0 mb-4 bgdark ">
        <div class="card-body ">
            <span style="color:red;">*</span>Pilih Barang</label>
            <select id="select"
                class="form-control selectpicker form-control-user @error('barang') is-invalid @enderror" name="barang"
                data-live-search="true">
                <option selected disabled>Pilih Barang</option>
                @foreach ($barang as $data)
                <option value="{{$data->barang_id}}">{{ $data->barang->nama }} - {{ $data->barang->tipe }}</option>
                @endforeach
            </select>
            @error('barang')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <h3 class="text-center mt-3 text-light" id="nama"></h3>
            <div class="table-responsive mt-2">
                <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                    <thead id="head">
                    </thead>
                    <tbody id="body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="align-items-center bg-light p-3 border-left-success rounded">
        <span class="">Oops!</span><br>
        <p><i class="fa-solid fa-circle-info text-info"></i> Belum Terdapat Peminjaman</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $(".selectpicker").select2({
            maximumSelectionLength: 2
        });
    });

    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });

    $(document).on('change', '.selectpicker', function () {
        var select = $('#select option:selected').val()

        $.ajax({
            url: "{{ route('dipinjam.ajax') }}",
            type: "GET",
            data: {
                select: select
            },
            success: function (data) {
                $('#head').html(data.head)
                $('#body').html(data.body)
                $('#nama').html(data.nama)
            }
        });
    });
</script>
@endsection
