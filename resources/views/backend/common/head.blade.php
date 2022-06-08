<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laboratorium | @yield('title')</title>

    {{-- ICON --}}
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/icon.png') }}" />
    <!-- Font Awesome UI KIT-->
    <script src="https://kit.fontawesome.com/f75ab26951.js" crossorigin="anonymous"></script>
    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Custom styles for this page -->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" ></script>	
    <style>
        .select2-search input {
            color: #ffffff;
            background-color: #343A40;
        }

        .select2-results {
            background-color: #343A40;
            color: #ffffff
        }

        span.select2-container--default .select2-selection--single {
            background-color: #2a3038;
            border: none;
            height: 39px;
        }
        span.select2-container--default .select2-selection--single .select2-selection__rendered{
            color: #ffffff ;
        }
        .visible {
  height: 3em;
  width: 10em;
  background: yellow;
}
    </style>
</head>
