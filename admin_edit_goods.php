<?php
    session_start();
    header("content-type:text/html; charset=utf-8");

    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    if (!isset($_SESSION["admin"])){
      header("Location: admin_login.php");
      exit();
    }


    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['name'])){   //新增
          $sth = $db->prepare("insert into Goods (name,price,image,description) values(:name,:price,:image,:description)");   
          $sth->bindParam("name", $_GET['name'], PDO::PARAM_STR,1000);    
          $sth->bindParam("price", $_GET['price'], PDO::PARAM_INT);    
          $sth->bindParam("image", $_GET['image'], PDO::PARAM_STR,50);    
          $sth->bindParam("description", $_GET['description'], PDO::PARAM_STR,1000);    
          $sth->execute();

        }else{  //自動填入資料
            $sth = $db->prepare("select * from Goods where gId = :gId");
            $sth->bindParam("gId", $_GET['id'], PDO::PARAM_INT);    
            $sth->execute();

            $row = $sth->fetch();
        }
    }elseif($_SERVER['REQUEST_METHOD'] == 'POST'){  //修改
        $sth = $db->prepare("update Goods set name = :name,price = :price,image = :image,description = :description where gId = :gId");
        $sth->bindParam("gId", $_POST['id'], PDO::PARAM_INT);    
        $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,10000);    
        $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);    
        $sth->bindParam("image", $_POST['image'], PDO::PARAM_STR,50);    
        $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,100000);    
        $sth->execute();
    }elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){   //刪除
        $sth = $db->prepare("delete from Goods where gId = :gId");
        $sth->bindParam("gId", $_GET['id'], PDO::PARAM_INT);    
        $sth->execute();
    }



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

      .textarea {
        height: 200px;
        width: 300px;
        padding: 4px;
        border: 1px solid #888;
        resize: vertical;
        overflow: auto;
        }
        .textarea:empty:before {
        content: attr(placeholder);
        color: #bbb;
      }
    
    </style>
    
<body>


<nav class="navbar navbar-expand-md navbar-dark bg-primary">

  <a href="http://localhost:8000/PID_Assignment/admin_members.php" class="navbar-brand">管理</a>

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
        <a href="admin_login.php?logout=1" class="nav-link">登出</a>
      </li>

    </ul>

	<span id="guest"> <a href="admin_members.php" class="btn btn-outline-light btn-sm">你好！<?= $_SESSION['admin'] ?></a> </span>
  </div>
</nav>

<div style="margin-top: 30px;" class="container">

<h2 align="center" style="padding-top:20px;">修改商品資訊</h2>

<div style="margin-top: 50px;" class="container col-8">
        <form method="get" id="form">


            <div class="form-group row">
                <label for="name" class="col-4 col-form-label">品名</label> 
                <div class="col-8">
                    <input id="name" name="name" type="text" class="form-control" value="<?= $row['name'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-4 col-form-label">價錢</label> 
                <div class="col-8">
                    <input id="price" name="price" type="text" class="form-control" pattern="\d+" value="<?= $row['price'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-4 col-form-label">圖片檔名</label> 
                <div class="col-8">
                    <input id="image" name="image" type="text" class="form-control" value="<?= $row['image'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-4 col-form-label">說明</label> 
                <div class="col-8">
                  <textarea name="" id="description" cols="45" rows="10"><?= $row['description']?></textarea>
                </div>
            </div>


            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button id="submit" name="" value="OK" type="button" onclick="goEdit(<?= isset($row['gId']) ? ($row['gId']):0 ?>)" class="btn btn-success">送出</button>
                    <a href="admin_goods.php" class="btn btn-success">取消</a>
                </div>
                
            </div>


        </form>

    </div>



</div>

<script>

    $('.goods').addClass("active");
	  $('.member').removeClass("active");


    //修改資料
    function goEdit(id){
      if (id == 0){
        var name = $('#name').val();
        var price = $('#price').val();
        var image = $('#image').val();
        var description = $('#description').val();
        var dataList = {
          name: name,
          price: price,
          image: image,
          description: description
        }

        $.ajax({
          type: "get",
          url: "admin_edit_goods.php",
          data: dataList
        }).then(function(e){
          $('#form').trigger("reset");
          alert("新增成功");
        })
      }else{
        var id = id;
        var name = $('#name').val();
        var price = $('#price').val();
        var image = $('#image').val();
        var description = $('#description').val();
        var dataList = {
          id: id,
          name: name,
          price: price,
          image: image,
          description: description
        }
        $.ajax({
          type: "post",
          url: "admin_edit_goods.php",
          data: dataList
        }).then(function(e){
          $('#form').trigger("reset");
            window.location.replace("admin_goods.php")
        })
      }

    }


</script>

</body>
</html>
