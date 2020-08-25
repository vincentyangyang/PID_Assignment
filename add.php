<?php
    session_start();

    if(isset($_GET['id'])){

        $id = $_GET['id'];
        $name = $_GET['name'];
        $image = $_GET['image'];
        $price = $_GET['price'];
        $quantity = $_GET['quantity'];
        $page = $_GET['page'];
        
        $count = count($_SESSION['carts']);


        if ($page == 'cart'){
            for($i=0;$i<=$count;$i++){
                echo $i;
                if($_SESSION['carts'][$i][0] == $id){
                    if($quantity == 0){
                        unset($_SESSION['carts'][$i]);
                    }else{
                        $_SESSION['carts'][$i][4] = $quantity;
                    }

                break;
                }
            }
            // header("Location: cart.php");
            exit();
        }


        if (!isset($_SESSION['carts'])){
            $_SESSION['carts'] = array();
        }

        $flag = 0;
        
        // SESSION[id,名稱,照片,價格,數量]
        for($i=0;$i<=$count;$i++){
            if($_SESSION['carts'][$i][0] == $id){
                $_SESSION['carts'][$i][4] += 1;
                $flag = 1;
                break;
            }
        }


        // 購物車沒有此商品
        if ($flag == 0){
            $item = [$id, $name, $image, $price, 1];
            array_push($_SESSION['carts'],$item);
        }


        // header("Location: goodsList.php");

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['authority'])){
            $admin = $_POST['admin'];
            $admin_pass = $_POST['pass'];
        
        
            $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
            $db->exec("SET CHARACTER SET utf8");
     
            $sth = $db->prepare("select * from admin where admin = :admin and password = :pass");
        
            $sth->bindParam("admin", $admin, PDO::PARAM_STR, 50);
            $sth->bindParam("pass", $admin_pass, PDO::PARAM_STR, 50);
        
            $sth->execute();
        
            $row = $sth->fetch();
        
            if(!empty($row)){
                    $_SESSION["admin"] = $admin;
                    echo 'success';
            }else{
                echo 'fail';
            }
        }else{
            $acc = $_POST['admin'];
            $pass = $_POST['pass'];
        
        
            $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
            $db->exec("SET CHARACTER SET utf8");
     
            $sth = $db->prepare("select * from customers where admin = :admin and password = :pass");
        
            $sth->bindParam("admin", $acc, PDO::PARAM_STR, 50);
            $sth->bindParam("pass", $pass, PDO::PARAM_STR, 50);
        
            $sth->execute();
        
            $row = $sth->fetch();
        
            if(!empty($row)){
                if ($row['Authority'] == 1){
                    $_SESSION["login"] = $acc;
                    $_SESSION["id"] = $row['cId'];
                    echo 'success';
                }else{
                    echo 'no Authority';
                } 
            }else{
                echo 'fail';
            }
        }
    }




?>