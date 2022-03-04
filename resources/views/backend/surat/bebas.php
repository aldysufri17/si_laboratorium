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
<section id="header">
    <img class="center certificate" style="width:1031px; height:150px; padding:11px 0" src="<?= asset('admin/img/kop.png') ?>">
    <hr widht="200px;">
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
        <tr>
            <td style="color: #9c9c9c;">UID</td>
        </tr>
    </table>
</section>