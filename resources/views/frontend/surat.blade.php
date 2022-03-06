<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
        line-height: 1.2em;
        font-size: 12pt;
        margin: 0 8px;
    
    }
    
    .font-arial {
        font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif
    }
    
    .font-cambria {
        font-family: Cambria, Georgia, serif
    }
    
    .text-center {
        text-align: center
    }
    
    .margin-bottom {
        margin-bottom: 1.2em
    }
    
    table {
        border-collapse: collapse;
        width: 100%
    }
    
    table.line-height-table {
        line-height: 2em
    }
    
    table .col-center {
        text-align: center
    }
    
    #header table td {
        padding: 5px
    }
    
    img.center {
        display: block;
        margin: 0 auto
    }
    
    img.logo {
        width: 93px;
        height: 123px
    }
    
    img.certificate {
        padding: 0 10px;
        width: 110px;
        height: 64px
    }
    
    .head-info td {
        vertical-align: top;
        font-size: 8pt
    }
    
    .yth {
        padding: 20px 0
    }
    
    .align-top {
        vertical-align: top
    }
    </style>
</head>
<body>
    <section id="header certificate">
        <img class="center" style="width:695px; height:120px; padding:11px 0;"
            src="{{ storage_path('app/public/kop.png') }}">
    </section>
    <section class="font-cambria">
        <div class="yth">Kepada Yth.<br>Kepala Laboratorium<br>SMK DHARMA ANALITIKA MEDAN</div>
        <div>Dengan hormat,<br>Yang bertanda tangan dibawah ini, saya :</div>
    </section>
    <section>
        <table class="line-height-table">
            <tr>
                <td style="width: 20%">Nama</td>
                <td style="width: 2%">:</td>
                <td>{{$name}}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{$nim}}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>
    </section>
    <section>
        <div>Mengajukan permohonan peminjaman barang di Laboratorium Sistem Tertanam dan Robotika<br>Adapun barang yang
            akan
            saya pinjam adalah :</div>
    </section>
    <br>
    
    <section>
        <table border="1" class="bordered highlight responsive-table">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>jumlah</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $key=>$a)
                <tr>
                    <td align="center" style="padding: 10px 2px">
                        {!! DNS1D::getBarcodeHTML(strval($a->id), "C128",4.5,50) !!}
                    </td>
                    <td align="center">
                        <div class="row">{{ $a->barang->nama}}</div>
                        <div class="row text-muted">{{ $a->barang->tipe}}</div>
                    </td>
                    <td align="center">{{$a->jumlah }}</td>
                    <td align="center">{{$a->tgl_start }}</td>
                    <td align="center">{{ $a->tgl_end}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <br>
    <section id="ttd">
        <table>
            <tr>
                <td style="width: 70%;"></td>
                <td style="width: 30%;">Semarang, <?= date('d-m-Y') ?></td>
            </tr>
            <tr>
                <td colspan="2">Mengetahui,</td>
            </tr>
            <tr>
                <td>Dosen pengampu/pembimbing,</td>
                <td>Hormat saya,</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 70px"></td>
            </tr>
            <tr>
                <td class="align-top">(............................................................)</td>
                <td class="align-top">(............................................................)</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="col-center">Menyetujui,<br>Kepala Laboratorium</td>
            </tr>
            <tr>
                <td style="height: 70px"></td>
            </tr>
            <tr>
                <td class="align-top col-center">(............................................................)</td>
            </tr>
        </table>
    </section>
</body>
</html>