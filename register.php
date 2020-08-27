<?php


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>用戶註冊</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>     -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
      body{
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

      .fail{
        font-size: 13px;
        color: red;
      }

      #exist{
        color: red;
      }

    </style>

</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">

  <a href="http://localhost:8000/PID_Assignment/goodsList.php" class="navbar-brand">商城</a>

  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarCollapse">

  
      <ul class="navbar-nav">

      <li class="nav-item cart active">
        <a href="login.php" class="nav-link">登入</a>
      </li>


    </ul>
  


  </div>


</nav>

<div style="margin-top: 50px;" class="container">

<form method="post">


<div id="divadmin" class="form-group row">
    <label for="admin" class="col-4 col-form-label"><span class="float-right"">帳號</span></label> 
    <div class="col-8">
        <input id="admin" name="admin" type="text" class="form-control col-5" value="" placeholder="請輸入至少7碼的英文或數字" pattern="\w{7,}">
    </div>
</div>

<div id="divpass" class="form-group row">
    <label for="pass" class="col-4 col-form-label"><span class="float-right">密碼</span></label> 
    <div class="col-8">
        <input id="pass" name="pass" type="text" class="form-control col-5" value="" placeholder="請輸入至少7碼的英文或數字" pattern="\w{7,}">
    </div>
</div>

<div id="divemail" class="form-group row">
    <label for="email" class="col-4 col-form-label"><span class="float-right">信箱</span></label> 
    <div class="col-8">
        <input id="email" name="email" type="text" class="form-control col-5" placeholder="xxx@xxx.com" pattern="\w+([.-]\w+)*@\w+([.-]\w+)+" value="">
    </div>
</div>

<div id="divbirthday" class="form-group row">
    <label for="birthday" class="col-4 col-form-label"><span class="float-right">生日</span></label> 
    <div class="col-8">
        <input id="birthday" name="birthday" type="text" class="form-control col-5" placeholder="2000-01-01" value="" pattern="\d{4}-\d{2}-\d{2}">
    </div>
</div>

<div id="divphone" class="form-group row">
    <label for="phone" class="col-4 col-form-label"><span class="float-right">手機</span></label> 
    <div class="col-8">
        <input id="phone" name="phone" type="text" class="form-control col-5" value="" placeholder="0912345678" pattern="\d{10}">
    </div>
</div>



<div class="form-group row">
    <div class="offset-4 col-8">
        <button id="register" name="submit" value="OK" type="button" class="btn btn-success">註冊</button>
        <input type="button" id="cancel" name="cancel" value="清除" class="btn btn-success"></button>
    </div>
    
</div>


</form>

<div id="exist" class='text-center'></div>


<div class="footer fixed-bottom">
  Chung Yo© 2020. All Rights Reserved
  
</div>



<script type="text/javascript">
  
    $('#cancel').on('click',function(){
        $('.form-control').val("");
    });

    $('#register').on('click',function(){
      var acc = /\w{7,}/;
      var mail = /\w+([.-]\w+)*@\w+([.-]\w+)+/;
      var bd = /\d{4}-\d{2}-\d{2}/;
      var tel = /\d{10}/;

      var admin = $('#admin').val();
      var pass = $('#pass').val();
      var email = $('#email').val();
      var birthday = $('#birthday').val();
      var phone = $('#phone').val();

      var format = [acc.test(admin),acc.test(pass),mail.test(email),bd.test(birthday),tel.test(phone)];
      var column = ["admin","pass","email","birthday","phone"];
      var columnName = ["帳號","密碼","信箱","生日","電話"];

      $(".fail").remove();

      var i;
      var flag = 0;

      for(i=0;i<5;i++){
        if (format[i] == false){
          flag = 1;
          var divName = "div"+column[i];
          $("#"+divName).append("<div class='text-center col-10 fail'>"+columnName[i]+"格式錯誤！！</div>");
        }
      }
      

      if(flag == 0){

        var dataList = {
        admin: admin,
        pass: pass,
        email: email,
        birthday: birthday,
        phone: phone,
        register: "register"
        }

        $.ajax({
          type: "POST",
          url: "add.php",
          data: dataList,
          success: function(e){
            if(e == 'exist'){
              $('#exist').html("帳號已存在！！");
            }else{
              window.location.replace("login.php");
            }
          }
        })
      }

    })


  </script>

</body>
</html>