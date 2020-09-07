<!DOCTYPE html>
<html lang="en">

    <head>
      <title>會員購買紀錄</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
      <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
      <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>


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
            <a href="login?logout=1" class="nav-link">登出</a>
          </li>

        </ul>

        <span id="guest"> <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> </span>
      </div>
    </nav>

    <div style="margin-top: 30px;" class="container">

        <h2 align="center" style="padding-top:20px;"><span style="color: #DEB887;">{{ $name }}</span>的購買紀錄</h2>

        <span class="float-right" >
            <a class="btn btn-info" href="members">上一頁</a>
        </span>
                
        <table style="margin-top: 50px;" class="table table-hover table-striped">

          <thead>
            <tr>
              <th>會員編號</th>
              <th>商品</th>
              <th>數量</th>
              <th>小計</th>
              <th>付款狀態</th>
              <th>訂單時間</th>
            </tr>
          </thead>

          <tbody>

            @forelse($orders as $order)     
                <tr>
                  <td>{{ $order['cId'] }}</td>
                  <td>{{ $order['name'] }}</td>
                  <td>{{ $order['quantity'] }}</td>
                  <td>{{ $order['sum'] }}</td>
                  <td>
                    {{ ($order['status']==0) ? '未付款':'已付款' }}
                  </td>
                  <td>{{ $order['date'] }}</td>
                </tr>
            @empty
            @endforelse


          </tbody>

        </table>

    </div>

<script>

    $('.member').addClass("active");

</script>

</body>

</html>
