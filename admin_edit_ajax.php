<?php

require("config.php");


//新增商品資料到資料庫
if(isset($_POST['insert'])){
    if($_FILES["file"]["error"] == 0){

        $imageName = $_FILES["file"]["type"];
        $image = str_replace("image/",".",$imageName);
        
        date_default_timezone_set("Asia/Shanghai");
        $pm = date("Ymd").date("h")+12;
        $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");
            if(move_uploaded_file($_FILES["file"]["tmp_name"],"./image/".$dateTime.$image)){
                $name = $dateTime.$image;

                $sth = $db->prepare("insert into Goods (name,price,image,description) values(:name,:price,:image,:description)");   
                $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,1000);    
                $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);    
                $sth->bindParam("image", $name, PDO::PARAM_STR,50);    
                $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,10000);

                $sth->execute();
        }
    }
}


//更新商品資料到資料庫(相片有更新)
if(isset($_POST['update'])){
    if($_FILES["file"]["error"] == 0){
        $sth = $db->prepare("select * from Goods where gId = :gId");
        $sth->bindParam("gId", $_POST['id'], PDO::PARAM_INT);    
        $sth->execute();

        $row = $sth->fetch();
        if(move_uploaded_file($_FILES["file"]["tmp_name"],"./image/".$row['image'])){

                $sth = $db->prepare("update Goods set name = :name,price = :price,image = :image,description = :description where gId = :gId");
                $sth->bindParam("gId", $_POST['id'], PDO::PARAM_INT);    
                $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,10000);    
                $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);    
                $sth->bindParam("image", $row['image'], PDO::PARAM_STR,50);    
                $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,100000); 

                $sth->execute();
        }
    }
}

//更新商品資料到資料庫(相片無更新)
if(isset($_POST['updateImageNoChange'])){
    $sth = $db->prepare("update Goods set name = :name,price = :price,description = :description where gId = :gId");
    $sth->bindParam("gId", $_POST['id'], PDO::PARAM_INT);    
    $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,10000);    
    $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);       
    $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,100000); 

    $sth->execute();
}


//預覽圖片
if(isset($_POST['change'])){
    if($_FILES["file"]["error"] == 0){
        $imageName = $_FILES["file"]["type"];
        $image = str_replace("image/",".",$imageName);

        date_default_timezone_set("Asia/Shanghai");
        $pm = date("Ymd").date("h")+12;
        $dateTime = (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:s");

        if(move_uploaded_file($_FILES["file"]["tmp_name"],"./storage/".$dateTime.$image)){ 
                echo $dateTime.$image;
        }
    }
}






?>