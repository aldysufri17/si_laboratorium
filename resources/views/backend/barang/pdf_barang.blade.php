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

<body style="margin: 20px 50px">
    <section class="font-cambria text-center">
        <div class="yth"><h2>REKAPITULASI DATA BARANG<br>{{strtoupper($name)}} PADA {{date('d-m-Y')}}</h2></div>
    </section>
    <section>
        <table border="1" class="bordered highlight responsive-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Baik</th>
                    <th>Rusak</th>
                    <th>Total</th>
                    <th>Lokasi</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $key=>$data)
                <tr class="text-center">
                    <td>{{$key+1}}</td>
                    <td>{{$data->kode_barang}}</td>
                    <td>{{$data->nama}} - {{$data->tipe}}</td>
                    <td>{{$data->stock}}</td>
                    @if ( $data->jml_rusak == null)
                    <td>0</td>
                    @else
                    <td>{{ $data->jml_rusak }}</td>
                    @endif
                    <td>{{$data->stock + $data->jml_rusak}}</td>
                    <td>{{$data->lokasi}}</td>
                    <td>{{$data->tgl_masuk}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <br>
</body>
</html>
