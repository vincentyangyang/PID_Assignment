<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理者登錄</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	

    <style>

      body{
        background-color: #ECFFFF;
        padding: 0;
        margin: 0;
      }
      .navbar-nav{
        margin-left: 60px;
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

      #fail{
          color: red;
      }

    </style>


</head>

<body>


  <nav class="navbar navbar-expand-md navbar-dark bg-primary">

    <a href="http://localhost:8000/PID_Assignment/PID_Laravel/public/admin/login" class="navbar-brand">管理</a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

  </nav>

  <div style="margin-top: 50px;" class="container">

    <form method="post">


      <div class="form-group row">
          <label for="admin" class="col-4 col-form-label"><span class="float-right">帳號</span></label> 
          <div class="col-4">
              <input id="admin" name="admin" type="text" class="form-control" value=""  placeholder="請輸入帳號" pattern="\w{7,}">
          </div>
      </div>

      <div class="form-group row">
          <label for="pass" class="col-4 col-form-label float-right"><span class="float-right">密碼</span></label> 
          <div class="col-4">
              <input id="pass" name="pass" type="password" class="form-control" value=""  placeholder="請輸入密碼" pattern="\w{7,}">
          </div>
      </div>


      <div class="form-group row">
          <div class="offset-4 col-10">
              <button id="submit" name="" value="OK" type="button" class="btn btn-success">登入</button>
          </div>
          
      </div>


    </form>

      <div id="fail" class="text-center"> </div>


  </div>


  <div class="footer fixed-bottom">
    Ching Yo© 2020. All Rights Reserved
  </div>

  <script type="text/javascript">

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#submit').on('click',function(){
      var dataList = {
        admin: $('#admin').val(),
        pass: $('#pass').val(),
      }
    
      $.ajax({
        
        type: "post",
        url: "{{ route('admin.loginPost') }}",
        data: dataList,
        success: function(msg) {
          if (msg=="success"){
            window.location.href="members";
          }else if (msg=="fail"){
            $('#fail').html("帳號或密碼錯誤！！");
          }
        }
      })
    });

    

  </script>
</body>
</html>