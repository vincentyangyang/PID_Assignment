<?php
    session_start();
    header("content-type:text/html; charset=utf-8");

    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");

    if (!isset($_SESSION["admin"])){
      header("Location: admin_login.php");
      exit();
    }


    if ($_SERVER['REQUEST_METHOD'] == 'GET'){     //自動填入資料

        $sth = $db->prepare("select * from Goods where gId = :gId");
        $sth->bindParam("gId", $_GET['id'], PDO::PARAM_INT);    
        $sth->execute();

        $row = $sth->fetch();

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
      <title>修改商品資訊</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </head>

    <style>
       body{
        background-color: #ECFFFF;
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
                <div id="errorName" class='text-center col-11' style="display:none;color:red;font-size:13px;">商品名稱不得為空</div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-4 col-form-label">價錢</label> 
                <div class="col-8">
                    <input id="price" name="price" type="text" class="form-control" pattern="\d+" value="<?= $row['price'] ?>">
                </div>
                <div id="errorPrice" class='text-center col-11' style="display:none;color:red;font-size:13px;">價錢必須為數字且不為0</div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-2 col-form-label" style="height:50px;padding-right: 0px;">圖片
                  <p style="color:blue;font-size:10px;">(點擊此處以上傳)</p>
                </label> 
                <div class="col-8">
                    <img id="photo" src="image/<?= isset($row['image']) ? $row['image']:'none.jpeg' ?>" class="col-12" style="border-style: outset;margin-left: 122px;"  >
                    <input id="image" name="image" style="display: none;" accept="image/*" type="file" onchange="setImage()" class="form-control" value="image/<?= isset($row['image']) ? $row['image']:'none.jpeg' ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-4 col-form-label">說明</label> 
                <div class="col-8">
                  <textarea name="" id="description" cols="45" rows="10"></textarea>
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

    var description = '<?= $row['description'] ?>';
    console.log(description);
    if(description != ""){
      description = description.replace(/<br>/g,"\n");
      console.log(description);
      $("#description").val(description);
    }
    //修改資料
    function goEdit(id){
      if($('#name').val() !== ""){
        if(/[^0]\d+/.test($('#price').val())){
          if (id == 0){
            if(typeof $('#image').prop('files')[0] !== "undefined"){
              var name = $('#name').val();
              var price = $('#price').val();
              var image = $('#image').val();
              var description = $('#description').val().replace(/\n/g, '<br>');
              var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
              var form_data = new FormData();  //建構new FormData()

              form_data.append('name', name);
              form_data.append('price', price);
              form_data.append('image', image);
              form_data.append('description', description);
              form_data.append('file', file_data);
              form_data.append('insert', "insert");
              

              $.ajax({
                type: "post",
                url: "admin_edit_ajax.php",
                contentType: false,
                cache: false,
                processData: false,
                data: form_data
              }).then(function(e){
                  $("#photo").prop("src","image/none.jpeg");
                  $('#form').trigger("reset");
                  alert("新增成功");

              })
            }else{
              alert("請選擇圖片！！");
            }

          }
          else{
            if(typeof $('#image').prop('files')[0] == "undefined"){
              var name = $('#name').val();
              var price = $('#price').val();
              var image = $('#image').val();
              var description = $('#description').val().replace(/\n/g, '<br>');
              var form_data = new FormData();  //建構new FormData()

              form_data.append('id', id);
              form_data.append('name', name);
              form_data.append('price', price);
              form_data.append('image', image);
              form_data.append('description', description);
              form_data.append('updateImageNoChange', "updateImageNoChange");

              $.ajax({
                type: "post",
                url: "admin_edit_ajax.php",
                contentType: false,
                cache: false,
                processData: false,
                data: form_data
              }).then(function(e){
                window.location.replace("admin_goods.php")
              })
            }else{
                var name = $('#name').val();
                var price = $('#price').val();
                var image = $('#image').val();
                var description = $('#description').val();
                var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
                var form_data = new FormData();  //建構new FormData()
    
                form_data.append('id', id);
                form_data.append('name', name);
                form_data.append('price', price);
                form_data.append('image', image);
                form_data.append('description', description);
                form_data.append('file', file_data);
                form_data.append('update', "update");

                $.ajax({
                  type: "post",
                  url: "admin_edit_ajax.php",
                  contentType: false,
                  cache: false,
                  processData: false,
                  data: form_data
                }).then(function(e){
                  window.location.replace("admin_goods.php")
                })
            }
          }
        }else{
          $("#errorPrice").show();
        }
      }else{
        $("#errorName").show();
      }


    }

    // ----------------------------------

    function setImage(){
      var file_data = $('#image').prop('files')[0];   //取得上傳檔案屬性
        var form_data = new FormData();  //建構new FormData()
        form_data.append('file', file_data);  //吧物件加到file後面
        form_data.append('change', "change");  //吧物件加到file後面
            
        $.ajax({
            type: "post",
            url: "admin_edit_ajax.php",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function(e){
                $("#photo").prop("src","storage/"+e);
            }
        })
    }


</script>

</body>
</html>
