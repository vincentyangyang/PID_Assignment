<?php

session_start();
header("content-type:text/html; charset=utf-8");

$admin = $_SESSION['login'];

if (isset($_POST['submit'])){
    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    $sth = $db->prepare("insert into Orders(cId, total) values (:cId, :total)");
  
    $sth->bindParam("cId", $_SESSION['id'], PDO::PARAM_INT);
    $sth->bindParam("total", $_SESSION['total'], PDO::PARAM_INT);
  
    $sth->execute();


    foreach($_SESSION['carts'] as $cart){
      $sum = $cart[3]*$cart[4];

      $result = $db->query("select * from Orders ORDER BY oId DESC LIMIT 0 , 1");
      $row = $result->fetch();

      $sth = $db->prepare("insert into OrderItem(oId, cId, name, quantity, sum) values (:oId, :cId, :name, :quantity, :sum)");

      $sth->bindParam("oId", $row[0], PDO::PARAM_INT);
      $sth->bindParam("cId", $_SESSION['id'], PDO::PARAM_INT);
      $sth->bindParam("name", $cart[1], PDO::PARAM_STR, 100000);
      $sth->bindParam("quantity", $cart[4], PDO::PARAM_INT);
      $sth->bindParam("sum", $sum, PDO::PARAM_INT);
    
      $sth->execute();

    }

    $db = null;

    unset($_SESSION['carts']);  

    header("Location: orders.php");
    exit();

}



?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>首頁</title>

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

      #page-container {
		position: relative;
		min-height: 100vh;
		}

      .navbar-nav{
      margin-left: 60px;
      }

      #guest{
        position: absolute;
        right: 50px;
        color: white;
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
        position: absolute;
        bottom: 0;
      }

      .fixed-bottom {
        position: fixed;
        bottom: 0;
        width:100%;
      }

      table {
     border-collapse: collapse;
        }

        .threeboder {
            border: 1px solid #5B96D0;
        }

        .trow {
            border-right: 1px solid #5B96D0;
            border-bottom: 1px solid #5A96D6;
        }

        .theader {
            background-color: #A5D3FF;
            font-size: 14px;
            border-right: 1px solid #5B96D0;
            border-bottom: 1px solid #5A96D6;
        }


    </style>
</head>

<body>

<div id="page-container">



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
        <a href="login.php?logout=1" class="nav-link">登出</a>
      </li>

    </ul>

    <span id="guest"> <a href="orders.php" class="btn btn-outline-light btn-sm">你好！<?= $admin ?></a> </span>

  </div>
</nav>

<h2 align="center" style="padding-top:20px;">購物車</h2>

<form id="form" action="" method="post" class="col-11" style="margin: auto;">

    <br>
    <table width="100%" border="1" align="center" class="threeboder">
        <tr bgcolor="#A5D3FF">
            <td height="50" align="center" class="theader" colspan="2">商品名稱</td>
            <td width="8%" align="center" class="theader">數量</td>
            <td width="15%" align="center" class="theader">單價</td>
            <td width="15%" align="center" class="theader">小計</td>
            <td width="5%" align="center" class="theader">清除</td>
        </tr>

        <?php foreach ($_SESSION['carts'] as $cart): ?>
        <?php
            $sum = $cart[3] * $cart[4];
            $total += $sum;
            $_SESSION['total'] = $total;
        ?>
        <tr style="height:150px;"> 
            <td><img src="<?= $cart[2] ?>" style="width:100px; height:100px;" /></td>
            <td height="50" align="left" class="trow"> <?= $cart[1] ?> </td>
            <td align="center" class="trow">
                <input type="text" value="<?= $cart[4] ?>" onblur="calc(<?= $cart[0] ?>,'<?= $cart[1] ?>','<?= $cart[2] ?>',<?= $cart[3] ?>,this)">
            </td>
            <td align="center" class="trow"><span id="price_<?= $cart[0] ?>"><?= $cart[3] ?></span></td>
            <td align="center" class="trow"><span id="subtotal_<?= $cart[0] ?>"><?= $sum ?></span></td>
            <td class="text-center"><a class="btn btn-outline-success btn-sm" href="javascript:void(0)" 	onclick="addToCart(<?= $cart[0] ?>,'<?= $cart[1] ?>','<?= $cart[2] ?>','<?= $cart[3] ?>',0,'cart')">刪除</a></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td height="50" colspan="6" align="right">合計：$<span id="total"><?= $total ?></span>  </td>
        </tr>
    </table>
    <br>
    <div align="center">
        <button name="submit" value="OK" type="submit" class="btn btn-success">Check Out</button>
    </div>
</form>

</div>


<div class="footer fixed-bottom">
    Dali E.so © 2020. All Rights Reserved
</div>

<script type="text/javascript">

    $('.cart').addClass("active");
    $('.list').removeClass("active");

    // $('#submit').on('click',function(){
    //   $('#form').submit();
    // })


    function addToCart(id,name,image,price,quantity,page){
		var dataList = {
			id: id,
			name: name,
			image: image,
			price: price,
			quantity: quantity,
			page: page
		}
		
		$.ajax({
			type: "get",
			url: "add.php",
			data: dataList
		}).then(function(e){
      parent.location.reload();
			// alert("商品已刪除！！");
		})
	}

  function calc(id,name,image,price,quantityInput) {
    var dataList = {
			id: id,
			name: name,
			image: image,
			price: price,
			quantity: quantityInput.value,
			page: 'cart'
		}

    $.ajax({
			type: "get",
			url: "add.php",
			data: dataList
		}).then(function(e){
      parent.location.reload();
			// alert("商品已刪除！！");
		})
  }

</script>
</body>
</html>