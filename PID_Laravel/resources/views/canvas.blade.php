<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>銷售數據</title>


    <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    <style>

        body{
          background-color: #ECFFFF;
          padding: 0;
          margin: 0;
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

                <li class="nav-item member">
                    <a href="members" class="nav-link">會員資料</a>
                </li>

                <li class="nav-item goods">
                    <a href="goods" class="nav-link">商品資料</a>
                </li>

                <li class="nav-item canvas">
                    <a href="canvas" class="nav-link">銷售數據</a>
                </li>

                <li class="nav-item">
                    <a href="./?logout=1" class="nav-link">登出</a>
                </li>

            </ul>

            <span id="guest"> <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> </span>
        </div>
    </nav>

    <div class="col-10" style="margin-top: 30px;">
        <canvas id="myChart"></canvas>
    </div>

    
    
    <script>
    
        $('.canvas').addClass("active");


        var labels = [];
        var data = [];
        @forelse($data as $row)
            labels.push("{{  $row['name'] }}");
            data.push("{{  ($row['quantity'] == '') ? 0:$row['quantity'] }}");
        @empty
        @endforelse
    
        var ctx = $('#myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,

                datasets: [
                {    
                    type: 'bar',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255,99,132,1)'
                    ],
                    borderWidth: 1,
                    label: '銷售量',
                    data: data
                }
                ]
            
            }
            });
    
    </script>
</body>
</html>