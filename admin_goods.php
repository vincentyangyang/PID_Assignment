<?php
    session_start();
    header("content-type:text/html; charset=utf-8");

    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    $sth = $db->prepare("select * from Goods");   
    $sth->execute();


    // if(isset($_GET['authority'])){
    //   $sth = $db->prepare("update customers set Authority = :authority where cId = :cId");
    //   $sth->bindParam("cId", $_GET['id'], PDO::PARAM_INT);    
    //   $sth->bindParam("authority", $_GET['authority'], PDO::PARAM_INT);   
    //   $sth->execute();

    //   header("Location: admin_members.php");
    //   exit();
    // }

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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

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
    
<body>


<nav class="navbar navbar-expand-md navbar-dark bg-primary">

  <a href="http://localhost:8000/pid/goodsList.php" class="navbar-brand">商城</a>

  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarCollapse">

    <ul class="navbar-nav">

      <li class="nav-item member">
        <a href="admin_members.php" class="nav-link">會員資料</a>
      </li>

      <li class="nav-item goods">
        <a href="admin_goods.php" class="nav-link">商品資料</a>
      </li>

      <li class="nav-item">
        <a href="login.php?logout=1" class="nav-link">登出</a>
      </li>

    </ul>

	<span id="guest"> <a href="admin_meembers.php" class="btn btn-outline-light btn-sm">你好！<?= $_SESSION['admin'] ?></a> </span>
  </div>
</nav>

<div style="margin-top: 30px;" class="container col-12">

<h2 align="center" style="padding-top:20px;">商品資料</h2>

 <span class="float-right" >
    <a class="btn btn-info" href="goodsList.php">首頁</a>
 </span>
             
  <table style="margin-top: 50px;" class="table table-hover table-striped">

    <thead>
      <tr>
        <th>商品</th>
        <th>名稱</th>
        <th>價錢</th>
        <th>說明</th>
      </tr>
    </thead>

    <tbody>

    <?php
      while( $row = $sth->fetch()){
        $dataList = array();
        array_push($dataList,$row);
    ?>

      <tr>
        <td><img src="<?= $row['image'] ?>" style="width:210px;height:210px;" alt=""></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['description'] ?></td>

        <td>
            <span class="float-right">
              <a class="edit btn btn-outline-success btn-sm" href="admin_edit_goods.php?id=<?= $row['gId'] ?>">修改</a>
              <a class="edit btn btn-outline-success btn-sm" style="margin-top:5px;" href="javascript:void(0)" onclick="goDelete(<?= $row['gId'] ?>)"">刪除</a>
            </span>
        </td>
      </tr>

    <?php } ?>




    </tbody>

  </table>

</div>

<script>

    $('.goods').addClass("active");
	  $('.member').removeClass("active");

    function goDelete(id){
      alert(id);
      $.ajax({
        type: "delete",
        url: "admin_edit_goods.php?id="+id,
      }).then(function(e){
        parent.location.reload();
      })
    }





</script>

</body>
</html>
