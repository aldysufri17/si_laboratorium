@extends('backend.layouts.app')

@section('title', 'Update Stok Barang')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Update Stok Barang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/inventaris')}}">Update Stok Barang</a></li>
            <li class="breadcrumb-item">Update Stok Barang</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('stok.update')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <select id="select"
                            class="form-control selectpicker form-control-user @error('barang') is-invalid @enderror"
                            name="barang" data-live-search="true">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $data)
                            <option value="{{$data->id}}">{{ $data->nama }} - {{ $data->tipe }}</option>
                            @endforeach
                        </select>
                        @error('barang')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <input type="text" hidden id="id_inventaris" name="id_inventaris">

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Sekarang</label>
                        <input type="text" id="stock" readonly class="form-control form-control-user" name="total_stok"
                            value="">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Rusak Sekarang</label>
                        <input type="text" id="rusak" readonly class="form-control form-control-user" name="total_rusak"
                            value="">
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input type="number"
                            class="form-control  form-control-user @error('jumlah') is-invalid @enderror"
                            autocomplete="off" id="examplejumlah" autocomplete="off" placeholder="Jumlah" name="jumlah"
                            min="1" value="{{ old('jumlah') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                        @error('jumlah')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('barang.index') }}">Batal</a>
            </div>
        </form>
    </div>

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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('change', '.selectpicker', function () {
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
                $('#id_inventaris').val(data.id)
            }
        });
    });

</script>
@endsection
