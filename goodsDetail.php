<?php
session_start();
header("content-type:text/html; charset=utf-8");

$admin = $_SESSION['login'];

$db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
$db->exec("SET CHARACTER SET utf8");

$sth = $db->prepare("select * from goods where gid = :id");

$sth->bindParam("id", $_GET['id'], PDO::PARAM_INT);

$sth->execute();

$row = $sth->fetch();

// if(!empty($row)){
//     $_SESSION["login"] = $admin;
//     header("Location: goodsList.php");
//     exit();
// }else{

//     $fail = "帳號或密碼錯誤！！";
// }

$db = null;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品詳情</title>

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
      .navbar-nav{
      margin-left: 60px;
      }

      #guest{
		position: absolute;
		right: 50px;
		color: white;
	  } 


      .fixed-bottom {
        position: fixed;
        bottom: 0;
        width:100%;
      }

      .title {
		font-size: 20px;
		color: #FF6600;
		font-style: italic;
		margin-top: 50px;
	    }

        .add_cart{
            float: right;
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
        <a href="login.php?logout=1" class="nav-link">登出</a>
      </li>

    </ul>

    <span id="guest"> <a href="orders.php" class="btn btn-outline-light btn-sm">你好！<?= $admin ?></a> </span>
  </div>
</nav>

<div class="text3 title" align="center"><?= $row['name'] ?></div><br><br>
<table width="100%" border="0" align="center">
    <tr>
			<td width="40%" align="right">
				<div><img src="image/<?= $row['image'] ?>" width="360px" height="360px"/></div>
        <br>
			</td>

			<td>
				<div style="width:80%; height:200;">
					<dl style="margin-left:100px;">
						<dd style="width:25%;"><h4>特色：</h4></dd>
						<dd style="width:25%; margin-left:30px;"><?= $row['description'] ?></dd>
					</dl>
				</div>

				<div align="center" class="text4">價格：<span class="title"><?= $row['price'] ?>元</span></div>

				<br>

				<div style="float:left; margin-left:150px; margin-top:40px;">
					<a class="add_cart" href="javascript:void(0)" 	onclick="addToCart(<?= $row['gId'] ?>,'<?= $row['name'] ?>','<?= $row['image'] ?>','<?= $row['price'] ?>',0,'list')">
						<img src="image/add_to_cart.png" style="width:185px; height:50px;"></a>
				</div>
			</td>
		</tr>
</table>


<script type="text/javascript">

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
			alert("商品已加入購物車！！");
		})
	}


</script>




</script>
</body>
</html>