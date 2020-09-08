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

        #page-container {
            position: relative;
            min-height: 100vh;
        }


        .navbar-nav{
            margin-left: 60px;
        }

        #navbarCollapse{
            position: relative;
        }

        #guest{
            position: absolute;
            right: 50px;
            color: white;
        }

        @yield('css')

      </style>

</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-primary">

    <a href="http://localhost:8000/PID_Assignment/PID_Laravel/public/admin/members" class="navbar-brand">管理</a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

        <ul class="navbar-nav">

            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $range }}
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="?id=1">今日</a>
                    <a class="dropdown-item" href="?id=2">最近7天</a>
                    <a class="dropdown-item" href="?id=3">最近1個月</a>
                    <a class="dropdown-item" href="?id=4">全部</a>
                </div>
            </li>

        </ul>

        <span id="guest">
        <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> 
    </span>
    
    </div>
</nav>

@yield('content')

<script>

@yield('script')

</script>
    
</body>
</html>