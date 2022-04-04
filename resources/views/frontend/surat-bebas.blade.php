<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        * {
            line-height: 1.2em;
            font-size: 12pt;
            margin: 0 5px;

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

        .lab td {
            text-align: center;
            padding: 15px 0
        }

    </style>
</head>

<body>
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
                    @php
                    $date = date("l jS \of F Y h:i:s A");
                    $surat = "Created $date \n website: http://silab18.herokuapp.com/"
                    @endphp
                <td rowspan="1"><img src="data:image/png;base64,{{DNS2D::getBarcodePNG(strval($surat), 'QRCODE',3,3)}}"
                    style="background-color: rgb(255, 255, 255); padding:5px; border-radius:1px" alt="barcode" />
                </td>
                </td>
            </tr>
        </table>
        <hr widht="200px;">
    </section>
    <section class="font-cambria">
        <div class="yth">Kepada Yth.<br>Kepala Laboratorium<br>DEPARTMENT TEKNIK KOMPUTER</div>
        <div>Dengan hormat,<br>Yang bertanda tangan dibawah ini, menyatakan bahwa :</div>
    </section>
    <section>
        <table class="line-height-table">
            <tr>
                <td style="width: 20%">Nama</td>
                <td style="width: 2%">:</td>
                @hasanyrole('admin')
                <td>{{$request->name}}</td>
                @else
                <td>{{$name}}</td>
                @endhasanyrole
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                @hasanyrole('admin')
                <td>{{$request->nim}}</td>
                @else
                <td>{{$nim}}</td>
                @endhasanyrole
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                @hasanyrole('admin')
                <td>{{$request->alamat}}</td>
                @else
                <td>{{$alamat}}</td>
                @endhasanyrole
            </tr>
        </table>
    </section>
    <br>
    <section>
        <div>Bahwa memang benar mahasiswa tersebut diatas bebas tanggungan pada Laboratorium Departemen Teknik Komputer
        </div>
    </section>
    <br>
    <section>
        <table border="1" class="lab bordered highlight responsive-table">
            <thead>
                <tr>
                    <th style="width: 1%">NO</th>
                    <th style="width: 2%">NAMA</th>
                    <th style="width: 2%">JABATAN</th>
                    <th style="width: 1%">TTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Mamad Jumaili Michail</td>
                    <td>Ketua Laboratorium Sistem Tertanam dan Robotika</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Riki Dwi Abiyanto</td>
                    <td>Ketua Laboratorium Rekayasa Perangkat Lunak</td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Aldo Pratama Siregar</td>
                    <td>Ketua Laboratorium Jaringan dan Keamanan Komputer</td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Pramudya Wulandari</td>
                    <td>Ketua Laboratorium Multimedia</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </section>
    <br>
    <section>
        <div>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</div>
    </section>
    <br>
    <section id="ttd">
        <table>
            <tr>
                <td style="width: 70%;"></td>
                <td style="width: 30%;">Semarang, {{date('d-m-Y')}}</td>
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
