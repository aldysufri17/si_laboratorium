@extends('backend.layouts.app')

@section('title', 'Tambah Barang Rusak')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h5 mb-0 text-light">Form Tambah Barang Rusak</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/inventaris')}}">Catatan Barang Rusak</a></li>
            <li class="breadcrumb-item">Tambah Barang Rusak</li>
        </ol>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow border-0 mb-4 bgdark ">
        <form method="POST" action="{{route('damaged.store')}}">
            @csrf
            <div class="card-body ">
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama Barang</label>
                        <select id="select" class="form-control selectpicker form-control-user @error('barang') is-invalid @enderror"
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
                        <input type="text" id="stock" readonly class="form-control form-control-user" name="total_stok" value="">
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Barang Rusak Sekarang</label>
                        <input type="text" id="rusak" readonly class="form-control form-control-user" name="total_rusak" value="">
                    </div>

                    {{-- Jumlah --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input type="number"
                            class="form-control  form-control-user @error('jumlah') is-invalid @enderror"
                            autocomplete="off" id="inp" autocomplete="off" placeholder="Jumlah" name="jumlah" min="1"
                            value="{{ old('jumlah') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                        @error('jumlah')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <div class="form-group">
                            <span style="color:red;">*</span>Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                id="exampleFormControlTextarea1" name="keterangan" rows="3"></textarea>
                        </div>
                        @error('keterangan')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bgdark border-0">
                <button type="submit" class="btn btn-primary btn-user float-right mb-3">Simpan</button>
                <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('barang.damaged') }}">Batal</a>
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
            }
        });
    });

    $(document).on("change", '#inp', function() {
        let v = parseInt(this.value);
        var stock = $('#stock').val()
        if (v < 1) this.value = 1;
        if (v > stock) this.value = stock;
    });

</script>
@endsection
