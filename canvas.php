<?php

    require("config.php");

    session_start();

    $sth = $db->query("select g.name,o.quantity FROM Goods as g LEFT JOIN OrderItem as o on g.name = o.name");   
    $sth->execute();

    $db = null;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>銷售數據</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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

        <a href="http://localhost:8000/PID_Assignment/admin_members.php" class="navbar-brand">管理</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav">

                <li class="nav-item member">
                    <a href="admin_members.php" class="nav-link">會員資料</a>
                </li>

                <li class="nav-item goods">
                    <a href="admin_goods.php" class="nav-link">商品資料</a>
                </li>

                <li class="nav-item canvas">
                    <a href="canvas.php" class="nav-link">銷售數據</a>
                </li>

                <li class="nav-item">
                    <a href="admin_login.php?logout=1" class="nav-link">登出</a>
                </li>

            </ul>

            <span id="guest"> <a href="admin_members.php" class="btn btn-outline-light btn-sm">你好！<?= $_SESSION['admin'] ?></a> </span>
        </div>
    </nav>

    <div class="col-10" style="margin-top: 30px;">
        <canvas id="myChart"></canvas>
    </div>

    
    
    <script>
    
        $('.canvas').addClass("active");


        var labels = [];
        var data = [];
        <?php while( $row = $sth->fetch() ){ ?>
            labels.push("<?=  $row['name'] ?>");
            data.push("<?=  ($row['quantity'] == "") ? 0:$row['quantity'] ?>");
        <?php } ?>
    
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