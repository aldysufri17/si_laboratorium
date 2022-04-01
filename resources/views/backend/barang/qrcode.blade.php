<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h4>Dicetak pada :  {{date('d-m-Y') . " " . date("h:i:sa")}} </h4>
    @foreach ($barang as $item)
    @php
    $qr = 'ID = '.$item->id . ' - '. 'Nama = '. $item->nama .' '. $item->tipe .' - '. 'Lokasi = '. $item->lokasi
    @endphp
    <div style="display: flex;">
        <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(strval($qr), 'QRCODE',5,5)}}"
        style="background-color: rgb(255, 255, 255); padding:5px; border-radius:1px" alt="barcode" />
    <h5>{{$item->nama}}</h5>
    </div>
    @endforeach
</body>

</html>
