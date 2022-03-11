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
    </style>
</head>

<body>
    <section id="header certificate">
        <img class="center" style="width:695px; height:120px; padding:11px 0;" src="https://i.ibb.co/9bk6jMs/kop.png">
    </section>
    <section class="font-cambria">
        <div class="yth">Kepada Yth.<br>Kepala Laboratorium<br>SISTEM TERTANAM DAN ROBOTIKA</div>
        <div>Dengan hormat,<br>Yang bertanda tangan dibawah ini, menyatakan bahwa :</div>
    </section>
    <section>
        <table class="line-height-table">
            <tr>
                <td style="width: 20%">Nama</td>
                <td style="width: 2%">:</td>
                <td><?= ($request->nama) ?></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td><?= ($request->nim) ?></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td><?= ($request->jurusan) ?></td>
            </tr>
        </table>
    </section>
    <section>
        <div>Telah bebas dari pinjaman peralatan di Laboratorium Sistem Tertanam dan Robotika</div>
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