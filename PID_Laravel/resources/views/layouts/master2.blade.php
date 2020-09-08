<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="<?= asset('bower/bootstrap/dist/css/bootstrap.min.css') ?>">
    <script src="<?= asset('bower/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= asset('bower/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

    <style>

        body{
            background-color: #ECFFFF;
            padding: 0;
            margin: 0;
        }

        #navbarCollapse{
            position: relative;
        }

        .navbar-nav{
            position: absolute;
            right: 50px;
        }

        .footer{
            height: 30px;
            color: #ffffff;
            background: #c3c3c3;
            text-align: center;
            clear: both;
            margin-bottom:2px;
            padding-top: 4px;
            padding: auto;
            width: 100%;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 0;
            width:100%;
        }

        @yield('css')

    </style>

</head>
<body>

@include('layouts.navbar2')

@yield('content')

<script>

@yield('script')

</script>
    
</body>
</html>