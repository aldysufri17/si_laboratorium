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
        <div class="yth"><h2>REKAPITULASI DATA PENGGUNA SISTEM INFORMASI PEMINJAMAN <br> LABORATOTIUM DEPARTEMEN TEKNIK KOMPUTER PADA {{date('d-m-Y')}}</h2></div>
    </section>
    <section>
        <table border="1" class="bordered highlight responsive-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No-Telp</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $key=>$data)
                <tr class="text-center">
                    <td>{{$key+1}}</td>
                    <td>{{$data->nim}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{ $data->mobile_number }}</td>
                    <td>{{$data->jk}}</td>
                    <td>{{$data->alamat}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <br>
</body>
</html>
