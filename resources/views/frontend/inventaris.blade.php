@extends('frontend.layouts.app')
@section('title', 'Daftar Barang Laboratorium')
@section('content')
<main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Daftar Barang Laboratorium</h2>
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li>Daftar Barang Laboratorium</li>
                </ol>
            </div>

        </div>
    </section><!-- Breadcrumbs Section -->
    <div class="container-fluid">
        {{-- Alert Messages --}}
        @include('sweetalert::alert')
        @if ($barang->isNotEmpty())
        <div class="card shadow mb-4 border-0 bgdark">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-borderless dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Tgl Masuk</th>
                                <th width="15%">Kategori Lab</th>
                                <th width="15%">Nama</th>
                                <th width="15%">Stock</th>
                                <th width="15%">Lokasi Barang</th>
                                <th width="15%">Jenis Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $data)
                            <tr>
                                <td>{{ $data->tgl_masuk }}</td>
                                <td>{{$data->laboratorium->nama}}</td>
                                <td>{{ $data->nama }} - {{ $data->tipe }}</td>
                                <td>{{ $data->stock }} {{ $data->satuan->nama_satuan }}</td>
                                <td>{{ $data->lokasi }}</td>
                                <td>{{ $data->pengadaan->nama_pengadaan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $barang->links() }}
                </div>
            </div>
        </div>
        @else
            <div class="card shadow-sm p-3 mb-4 bg-white rounded" style="border-left: solid 4px rgb(0, 54, 233);">
                <div class="card-block">
                    <span class="">Oops!</span><br>
                    <p><i class="fa-solid fa-circle-info text-primary"></i> Data tidak ditemukan</p>
                </div>
            </div>
            @endif
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "bInfo": false,
            "paging": false,
            responsive: true,
            autoWidth: false,
            "order": [
                [0, "desc"]
            ]
        });
    });

</script>
@endsection
