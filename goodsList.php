<?php
session_start();
header("content-type:text/html; charset=utf-8");


$admin = $_SESSION['login'];

$db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop;port=3306", "root", "root");
$db->exec("set names utf8");

$result = $db->query("select * from goods");

$db = null;
// unset($_SESSION['id']);

// var_dump($_SESSION['id']);

// $item = array("a","b","c");

// $item2 = array("d","e","f");
// $_SESSION['arr'] = array();
// array_push($_SESSION['arr'],$item,$item2);
// echo count($_SESSION['arr']);

// foreach ($_SESSION['arr'] as $s){
// 	echo $s[0] == 'a';
// }


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

	  #navbarCollapse{
		  position: relative;
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


      h3{
		align: center;
	}

	.info{
		clear: both;

		height: 50px;
		margin:0px auto 50px;
	}


	.info .infoarea{
		float:left;
		padding:10px;
		height: 400px;
	}

	.info .infoarea img{
		width: 200px;
		margin-bottom: 10px;
	}

	.web{
		margin-bottom: 10px;
	}

	.pname{
		margin-bottom: 10px;
		height: 100px;
	}

	.info >p{
		font-size: 28px;
		padding-top: 20px;
		font-weight: bold;
	}

	ul{
		padding: 0;
	}


	li{
		list-style-type: none;
	}

	.price{
		width:135px;
		height:60px;
	}

	.by_accuracy{
		width:50px;
		height:60px;
		float:left;
	}

	.by_price{
		width:85px;
		height:60px;
	}

	.col3 {
		padding-top: 5px;
		text-align: center;
	}

	#goodsName{
		width: 210px;
		overflow:hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 4;
		-webkit-box-orient: vertical;
		white-space: normal;
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

<h2 align="center" style="padding-top:20px;">商品列表</h2>

<div class='info'>

	<?php while ($row = $result->fetch()): ?>

		<div class='infoarea col-xs-4 col-sm-6 col-md-4 col-lg-3' style="height:470px;">

			<div style="margin: auto;width: 240px;padding:0 20px;border-style: solid;border-width:1px;border-color: #BDB76B;">
				<ul>
					<li class="img"><a href="goodsDetail.php?id=<?= $row['gId'] ?>"><img src="<?= $row['image'] ?>"/></a></li>
					<li class="pname">
						<a href="goodsDetail.php?id=<?= $row['gId'] ?>">
							<p id="goodsName"><?= $row['name'] ?></p>
						</a>
					</li>
					<li>價格：<?= $row['price'] ?></li>
					<hr style="margin-bottom: 15px; margin-top: 10px;">
					<li class="col3" style="margin-top:3px;">
						<a id="add" class="add_cart" href="javascript:void(0)" 	onclick="addToCart(<?= $row['gId'] ?>,'<?= $row['name'] ?>','<?= $row['image'] ?>','<?= $row['price'] ?>',0,'list')">

							<img src="add_to_cart.png" style="width:110px; height:28px;">
						</a>
					</li>
				</ul>
			</div>

		</div>

	<?php endwhile ?>

</div>

</div>


<!-- <div class="footer">
    Dali E.so © 2020. All Rights Reserved
</div> -->

<script type="text/javascript">


	$('.list').addClass("active");
	$('.cart').removeClass("active");

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


// 	$(function(){
//     function footerPosition(){
//         $("footer").removeClass("fixed-bottom");
//         var contentHeight = document.body.scrollHeight,
//             winHeight = window.innerHeight;
// 		alert(contentHeight);
// 		alert(winHeight);
//         if(!(contentHeight > winHeight)){

//             $("footer").addClass("fixed-bottom");
//         } else {
//             $("footer").removeClass("fixed-bottom");
//         }
//     }
//     footerPosition();
//     $(window).resize(footerPosition);
//   });


</script>
</body>
</html>