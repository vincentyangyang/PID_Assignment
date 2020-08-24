<?php

session_start();
if(isset($_SESSION['carts'])){

    
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
  </div>
</nav>

<h2 align="center" style="padding-top:20px;">購物車</h2>

<form action="/store/submit_orders/" method="post" class="col-11" style="margin: auto;">

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
        ?>
        <tr style="height:150px;"> 
            <td><img src="<?= $cart[2] ?>" style="width:100px; height:100px;" /></td>
            <td height="50" align="left" class="trow"> <?= $cart[1] ?> </td>
            <td align="center" class="trow">
                <input name="quantity_<?= $cart[0] ?>" type="text" value="<?= $cart[4] ?>" onblur="calc({{item.0}},{{item.0}},{{item.3}}, this)">
            </td>
            <td align="center" class="trow"><span id="price_<?= $cart[0] ?>"><?= $cart[3] ?></span></td>
            <td align="center" class="trow"><span id="subtotal_<?= $cart[0] ?>"><?= $sum ?></span></td>
            <td class="text-center"><a class="btn btn-outline-success btn-sm" href="add.php?id=<?= $cart[0] ?>&name=<?= $cart[1] ?>&image=<?= $cart[2] ?>&price=<?= $cart[3] ?>&quantity=0&page=cart">刪除</a></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td height="50" colspan="6" align="right">合計：$<span id="total"><?= $total ?></span>  </td>
        </tr>
    </table>
    <br>
    <div align="center">
        <a href="#" class="submit_orders checkout"><input type="image" src="button_checkout.png" style="width:120px; height:47px;" border="0" onclick="checkout({{list}})"/></a>  
    </div>
</form>

</div>


<div class="footer fixed-bottom">
    Dali E.so © 2020. All Rights Reserved
</div>

<script type="text/javascript">

    $('.cart').addClass("active");
    $('.list').removeClass("active");


//   $(function(){
//     function footerPosition(){
//         $("footer").removeClass("fixed-bottom");
//         var contentHeight = document.body.scrollHeight,
//             winHeight = window.innerHeight;
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