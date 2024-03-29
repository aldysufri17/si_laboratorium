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
                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Inventaris</label>
                        <input type="text"
                            class="form-control form-control-user @error('kode_inventaris') is-invalid @enderror"
                            autocomplete="off" id="exampleTgl_masuk" placeholder="Kode Inventaris" name="kode_inventaris">
                        @error('kode_inventaris')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> --}}
                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                    {{-- Jumlah --}}
                    <label><span style="color:red;">*</span>Kode Inventaris</label><br>
                    @php
                    $max = App\Models\Inventaris::max('id');
                    $id = $max + 1;
                    if (strlen($id) == 1) {
                    $kode = "000".$id;
                    } else if(strlen($id) == 2) {
                    $kode = "00".$id;
                    } else if(strlen($id) == 3) {
                    $kode = "0".$id;
                    }else {
                    $kode = $id;
                    }
                    @endphp
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="d-flex">
                                <input type="text" readonly
                                    class="form-control  form-control-user @error('kode1') is-invalid @enderror"
                                    autocomplete="off" id="examplekode1" autocomplete="off" placeholder="No"
                                    name="kode1" min="1" value="{{ $kode }}">
                                <span class="font-weight-bold ml-2" style="font-size: 25px">.</span>
                            </div>
                            @error('kode1')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-sm-2">
                            <div class="d-flex">
                                <input type="text" readonly
                                    class="form-control  form-control-user @error('kode2') is-invalid @enderror"
                                    autocomplete="off" id="kode2" autocomplete="off" placeholder="No"
                                    name="kode2" min="1">
                                <span class="font-weight-bold ml-2" style="font-size: 25px">.</span>
                            </div>
                            @error('kode2')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <div class="d-flex">
                                <input type="text"
                                    class="form-control  form-control-user @error('kode3') is-invalid @enderror"
                                    autocomplete="off" id="examplekode3" autocomplete="off" placeholder="No"
                                    name="kode3" min="1" value="{{ old('kode3') }}">
                                <span class="font-weight-bold ml-2" style="font-size: 25px">.</span>
                            </div>
                            @error('kode3')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex">
                                <input type="text"
                                    class="form-control  form-control-user @error('kode4') is-invalid @enderror"
                                    autocomplete="off" id="examplekode4" autocomplete="off" placeholder="Tahun Pengadaan"
                                    name="kode4" min="1" value="{{ old('kode4') }}">
                            </div>
                            @error('kode4')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

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

                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                    <span style="color:red;">*</span>Jumlah Barang Inventaris</label>
                    <input type="text" class="form-control form-control-user @error('stok') is-invalid @enderror"
                        autocomplete="off" id="stock" placeholder="Jumlah Barang" name="stok" value="">
                    @error('stok')
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
        <a class="btn btn-danger float-right mr-3 mb-3" href="{{ route('inventaris.index') }}">Batal</a>
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
        $('#kode2').val(select);

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
