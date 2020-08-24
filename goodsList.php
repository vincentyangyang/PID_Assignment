<?php
session_start();
header("content-type:text/html; charset=utf-8");

$admin = $_SESSION['login'];

$db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop;port=3306", "root", "root");
$db->exec("set names utf8");

$result = $db->query("select * from goods");

$db = null;

var_dump($_SESSION['carts']);

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
		height: 150px;
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
		border-top: 1px dashed #666666;
		text-align: center;
	}



    </style>
</head>

<body>

<div id="page-container">


<nav class="navbar navbar-expand-md navbar-dark bg-primary">

  <a href="http://localhost:8000/pid/goodsList.php" class="navbar-brand">商城</a>

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

	<span id="guest"> <a href="" class="btn btn-outline-light btn-sm">你好！<?= $admin ?></a> </span>
  </div>
</nav>

<h2 align="center" style="padding-top:20px;">商品列表</h2>

<div class='info'>

	<?php while ($row = $result->fetch()): ?>

		<div class='infoarea col-xs-4 col-sm-6 col-md-4 col-lg-3'>

			<div style="height: 385px;margin: auto;width: 240px;padding:0 20px;border-style: solid;border-width:1px;border-color: #F5F5F5;">
				<ul>
					<li class="img"><a href="/store/detail/?id=<?= $row['gId'] ?>"><img src="<?= $row['image'] ?>"/></a></li>
					<li class="pname"><a href="/store/detail/?id=<?= $row['gId'] ?>">產品名稱：<?= $row['name'] ?></a></li>
					<li>價格：<?= $row['price'] ?></li>
					<li class="col3" style="margin-top:3px;">
						<a class="add_cart" href="add.php?id=<?= $row['gId'] ?>&name=<?= $row['name'] ?>&image=<?= $row['image'] ?>&price=<?= $row['price'] ?>&quantity=1&page=list">
							<img src="add_to_cart.png" style="width:110px; height:28px;">
						</a>
					</li>
				</ul>
			</div>

		</div>

	<?php endwhile ?>

</div>

</div>


<div class="footer">
    Dali E.so © 2020. All Rights Reserved
</div>

<script type="text/javascript">


	$('.list').addClass("active");
	$('.cart').removeClass("active");

	$('.add_cart').click(function(){
		alert("商品已加入購物車！！");
	});

	// $.ajax({
	// 	var newItem = {
    //             title: a,
    //             ymd: b
    //         };
    //             type: "get",
    //             url: "add.php",
    //             data: newItem
    //         })


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