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
            margin: 0;

        }

        body {
            margin-left: 4;
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

<body style="margin: 0 20px">
    <section id="header">
        <table collapse="collapse" class="font-arial">
            <tr>
                <td rowspan="1"><img class="center logo" style="width:100px; height:100px;"
                        src="https://rekreartive.com/wp-content/uploads/2018/10/Logo-Undip-Universitas-Diponegoro-Semarang-Warna.jpg">
                </td>
                <td colspan="2" class="text-center">
                    <span style="font-size: 15pt; font-weight: bold">PEMINJAMAN BARANG LABORATORIUM<br>DEPARTMENT TEKNIK
                        KOMPUTER</span><br>
                    <span style="font-size: 10pt; ">1. Sistem Tertanam dan
                        Robotika 2. Rekayasa Perangkat Lunak</span><br>
                    <span style="font-size: 10pt;">3. Keamanan dan Jaringan Komputer 4. Multimedia</span><br>
                    <span style="font-size: 10pt;">Jl. Prof.Soedarto, Tembalang, Kec. Tembalang, Kota Semarang, Jawa
                        Tengah 50275</span><br>
                    <span style="font-size: 6pt;">Kontak : (024) 76480609<br>Email: siskom@undip.ac.id</span>
                </td>
                @php
                date_default_timezone_set('Asia/jakarta');
                $date = date("l jS \of F Y h:i:s A");
                $surat = "Created $date \n website: http://silab18.herokuapp.com/"
                @endphp
                <td rowspan="1"><img src="data:image/png;base64,{{DNS2D::getBarcodePNG(strval($surat), 'QRCODE',3,3)}}"
                        style="background-color: rgb(255, 255, 255); padding:5px; border-radius:1px" alt="barcode" />
                </td>
            </tr>
        </table>
        <hr widht="200px;">
    </section>
    <section class="font-cambria">
        <div class="yth">Kepada Yth.<br>Kepala Laboratorium<br>DEPARTMENT TEKNIK KOMPUTER</div>
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
                <td>Alamat</td>
                <td>:</td>
                <td>{{$alamat}}</td>
            </tr>
        </table>
    </section>
    <br>
    <section>
        <div>Mengajukan permohonan peminjaman barang di Laboratorium Departemen Teknik Komputer
            <br>Adapun barang yang akan saya pinjam adalah :</div>
    </section>
    <br>

    <section>
        <table border="1" class="bordered highlight responsive-table">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Laboratorium</th>
                    <th>jumlah</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $key=>$a)
                <tr>
                    <td>
                        {!! DNS1D::getBarcodeHTML(strval($a->id), "C128",3.5,45) !!}
                    </td>
                    <td align="center">
                        <div class="row">{{ $a->barang->nama}}</div>
                        <div class="row text-muted">{{ $a->barang->tipe}}</div>
                    </td>
                    <td align="center">
                        @if ($a->barang->kategori_lab == 1)
                        Laboratorium Sistem Tertanam dan Robotika
                        @elseif ($a->barang->kategori_lab == 2)
                        Laboratorium Rekayasa Perangkat Lunak
                        @elseif($a->barang->kategori_lab == 3)
                        Laboratorium Jaringan dan Keamanan Komputer
                        @elseif($a->barang->kategori_lab == 4)
                        Laboratorium Multimedia
                        @endif
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
