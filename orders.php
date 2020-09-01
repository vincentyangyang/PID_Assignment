<?php
    session_start();
    header("content-type:text/html; charset=utf-8");

    $admin = $_SESSION['login'];

    if($admin == ""){
      $admin = "UserNotLogin";
    }

    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    $sth = $db->prepare("select name,quantity,sum,date,status from Orders inner join OrderItem on Orders.oId = OrderItem.oId where Orders.cId = :cId");
    $sth->bindParam("cId", $_SESSION['id'], PDO::PARAM_INT);    
    $sth->execute();

    $db = null;

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>     -->

  <style>

      body{
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

  <a href="http://localhost:8000/PID_Assignment/goodsList.php" class="navbar-brand">商城</a>

  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarCollapse">

    <ul class="navbar-nav">

      <li class="nav-item cart">
        <a href="cart.php" class="nav-link">購物車</a>
      </li>

      <li class="nav-item list">
        <a href="goodsList.php" class="nav-link">商品列表</a>
      </li>

      <li class="nav-item">
        <a href="index.php?logout=1" class="nav-link">登出</a>
      </li>

    </ul>

	<span id="guest"> <a href="orders.php" class="btn btn-outline-light btn-sm">你好！<?= $admin ?></a> </span>
  </div>
</nav>



<div style="margin-top: 30px;" class="container">

<h2 align="center" style="padding-top:20px;">訂單記錄</h2>

 <span class="float-right" >
    <a class="btn btn-info" href="goodsList.php">首頁</a>
 </span>
             
  <table style="margin-top: 50px;" class="table table-hover table-striped">

    <thead>
      <tr>
        <th>商品</th>
        <th>數量</th>
        <th>小計</th>
        <th>付款狀態</th>
        <th>訂單時間</th>
      </tr>
    </thead>

    <tbody>

    <?php while($row = $sth->fetch()){ ?>

      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['sum'] ?></td>
        <td><?= ($row['status']==0) ? '未付款':'已付款'?></td>
        <td><?= $row['date'] ?></td>
      </tr>

    <?php } ?>


    </tbody>

  </table>

</div>


<script>

  if ("<?= $admin ?>" == "UserNotLogin"){
    $("body").html("");
      alert("請先登入！！");
      window.location.href="index.php";
    }

  $('.list').addClass("active");
	$('.cart').removeClass("active");

</script>

</body>
</html>
