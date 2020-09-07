<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>會員資料</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
        <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    </head>

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

	<span id="guest">
    <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> 
  </span>
  
  </div>
</nav>

<div style="margin-top: 30px;" class="container">

<h2 align="center" style="padding-top:20px;">會員資料</h2>
             
  <table style="margin-top: 50px;" class="table table-hover table-striped">

    <thead>
      <tr>
        <th>會員編號</th>
        <th>會員帳號</th>
        <th>E-mail</th>
        <th>電話</th>
        <th>權限</th>
      </tr>
    </thead>

    <tbody>

    @forelse($customers as $customer)

      <tr>
        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['cId'] }}</td>
        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['admin'] }}</td>
        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['email'] }}</td>
        <td onclick="goOrder({{ $customer['cId'] }})">{{ $customer['phone'] }}</td>
        <td id="status" onclick="goOrder({{ $customer['cId'] }})">
          {{ $customer['authority']==1 ? '正常':'停權' }}
        </td>
        <td>
            <span class="float-right">
              <a class="authority btn btn-sm{{ $customer['authority']==1 ? ' btn-danger':' btn-outline-success' }}" href="members?id={{ $customer['cId'] }}&authority={{ $customer['authority']==1 ? 0:1 }}">{{ $customer['authority']==1 ? "停權":"恢復" }}</a>
            </span>
        </td>
      </tr>

    @empty
    @endforelse


    </tbody>

  </table>

</div>

<script>


      $('.member').addClass("active");


      function goOrder(id){
        window.location.href="member_orders?id="+id;
      }

</script>

</body>
</html>
