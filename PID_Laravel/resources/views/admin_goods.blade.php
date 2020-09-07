<!DOCTYPE html>
    <html lang="en">
    <head>
      <title>商品資料</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta name="csrf-token" content="{{ csrf_token() }}" />
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

          <span id="guest"> <a href="members" class="btn btn-outline-light btn-sm">你好！{{ Session::get('admin_login') }}</a> </span>
      </div>
    </nav>

  <div style="margin-top: 30px;" class="container col-12">

      <h2 align="center" style="padding-top:20px;">商品資料</h2>

      <span class="float-right" >
          <a class="btn btn-info" href="goods_action">新增</a>
      </span>
             
      <table style="margin-top: 50px;" class="table table-hover table-striped">

          <thead>
            <tr>
              <th>商品</th>
              <th style="width:455px;">名稱</th>
              <th style="width:80px;">價錢</th>
              <th style="width:505px;">說明</th>
            </tr>
          </thead>

          <tbody>

            @forelse($goods as $row)

              <tr>
                <td><img src="../bower/image/{{ $row['image'] }}" style="width:210px;height:210px;" alt=""></td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['price'] }}</td>
                <td>{!! $row['description'] !!}</td>

                <td>
                    <span class="float-right">
                      <a class="edit btn btn-outline-success btn-sm" href="goods_action?id={{ $row['gId'] }}">修改</a>
                      <a class="edit btn btn-outline-success btn-sm" href="javascript:void(0)" onclick="goDelete({{ $row['gId'] }})">刪除</a>
                    </span>
                </td>

              </tr>
            @empty
            @endforelse


          </tbody>

      </table>

  </div>

<script>

    $('.goods').addClass("active");

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function goDelete(id){
      $.ajax({
        type: "delete",
        url: "delete?id="+id,
      }).then(function(e){
        parent.location.reload();
      })
    }


</script>

</body>
</html>
