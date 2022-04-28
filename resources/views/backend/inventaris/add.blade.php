@extends('backend.layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Inventaris</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/inventaris')}}">Catatan Inventaris</a></li>
            <li class="breadcrumb-item">Tambah Inventaris</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('inventaris.store')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    {{-- Tanggal masuk --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Inventaris</label>
                        <input type="text"
                            class="form-control form-control-user @error('kode_inventaris') is-invalid @enderror"
                            autocomplete="off" id="exampleTgl_masuk" placeholder="Kode Inventaris" name="kode_inventaris">
                        @error('kode_inventaris')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <select id="select" class="form-control form-control-user @error('barang') is-invalid @enderror"
                            name="barang">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $data)
                            <option value="{{$data->id}}">{{ $data->nama }} - {{ $data->tipe }}</option>
                            @endforeach
                        </select>
                        @error('barang')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Stok Barang Sekarang</label>
                        <input type="text" id="stock" readonly class="form-control form-control-user" value="">
                        <input type="text" readonly value="" id="stok" hidden>
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Rusak Sekarang</label>
                        <input type="text" id="rusak" readonly class="form-control form-control-user" value="">
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('inventaris.index') }}">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection


@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#select', function () {
        var select = $('#select option:selected').val()

        $.ajax({
            url: "{{ route('select.inventaris') }}",
            type: "GET",
            data: {
                select: select
            },
            success: function (data) {
                $('#stock').val(data.stock)
                if (data.rusak == null) {
                    var rusak = 0
                } else {
                    var rusak = data.rusak
                }
                $('#rusak').val(rusak)
            }
        });
    });

</script>
@endsection
