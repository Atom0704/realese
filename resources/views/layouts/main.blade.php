<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/x-icon">

    <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid" id="wrapper" style="padding: 0 !important; overflow-x: hidden">
    @include('layouts.header')
    <div class="row padding">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/vendor.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/common.min.js') }}" type="text/javascript"></script>

@yield('scripts')
</body>
</html>