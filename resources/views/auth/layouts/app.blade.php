<!DOCTYPE html>
<html lang="en">

<head>
    <link href="{{ asset('admin/css/sb-admin-2.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('js/instascan.min.js')}}"></script>
</head>

{{-- Head Before AUTH--}}
@include('auth.includes.head')

<body class="bg-image">

    <div class="container" id="wrapper">

        {{-- Content Goes Here FOR Before AUTH --}}
        @yield('content')

    </div>

    {{-- Scripts Before AUTH --}}
    @include('auth.includes.scripts')

</body>

</html>
