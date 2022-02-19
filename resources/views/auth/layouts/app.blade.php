<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{config('app.name', 'Laravel')}} | @yield('title')</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/icon.png') }}" />
    <link href="{{ asset('admin/css/sb-admin-2.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/f75ab26951.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('js/instascan.min.js')}}"></script>
    <style>
        .bgdark,
        .custom-control-label:before {
            background-color: #191c24;
        }
        .swal2-container.swal2-top-end>.swal2-popup, .swal2-container.swal2-top-right>.swal2-popup{
            background-color: #00C9A7;
        }
        .swal2-popup.swal2-toast .swal2-title, .swal2-popup.swal2-toast .swal2-close{
            color: white;
        }
    </style>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</head>

<body class="bg-image">
    <div class="container" id="wrapper">
        @yield('content')
    </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>
    @yield('script')
</body>
</html>
