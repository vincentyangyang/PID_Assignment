<?php

header("content-type:text/html; charset=utf-8");

$db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
$db->exec("SET CHARACTER SET utf8");

if(isset($_POST['insert'])){
    if($_FILES["file"]["error"] == 0){
        if(move_uploaded_file($_FILES["file"]["tmp_name"],"./image/".$_FILES["file"]["name"])){
            if(file_exists("./image/" . $_FILES["file"]["name"])){
                echo "exist";
            }else{
                $imageName  = $_FILES["file"]["name"];

                $sth = $db->prepare("insert into Goods (name,price,image,description) values(:name,:price,:image,:description)");   
                $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,1000);    
                $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);    
                $sth->bindParam("image", $imageName, PDO::PARAM_STR,50);    
                $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,10000);

                $sth->execute();
            }
        }
    }
}

if(isset($_POST['update'])){
    if($_FILES["file"]["error"] == 0){
        if(move_uploaded_file($_FILES["file"]["tmp_name"],"./image/".$_FILES["file"]["name"])){
            // if(file_exists("./image/" . $_FILES["file"]["name"])){
            //     echo "exist";
            // }else{
                $imageName  = $_FILES["file"]["name"];
                
                $sth = $db->prepare("update Goods set name = :name,price = :price,image = :image,description = :description where gId = :gId");
                $sth->bindParam("gId", $_POST['id'], PDO::PARAM_INT);    
                $sth->bindParam("name", $_POST['name'], PDO::PARAM_STR,10000);    
                $sth->bindParam("price", $_POST['price'], PDO::PARAM_INT);    
                $sth->bindParam("image", $imageName, PDO::PARAM_STR,50);    
                $sth->bindParam("description", $_POST['description'], PDO::PARAM_STR,100000); 

                $sth->execute();
            // }
        }
    }
}

if(isset($_POST['change'])){
    if($_FILES["file"]["error"] == 0){
        if(move_uploaded_file($_FILES["file"]["tmp_name"],"./storage/".$_FILES["file"]["name"])){ 
                echo $_FILES["file"]["name"];
        }
    }
}






?>