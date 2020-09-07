<?php
    session_start();

    //購物車操作
    if(isset($_GET['id'])){

        $id = $_GET['id'];
        $name = $_GET['name'];
        $image = $_GET['image'];
        $price = $_GET['price'];
        $quantity = $_GET['quantity'];
        $page = $_GET['page'];
        
        $count = count($_SESSION['carts']);

        //刪除商品
        if ($page == 'cart'){
            for($i=0;$i<=$count;$i++){
                if($_SESSION['carts'][$i][0] == $id){
                    if($quantity == 0){
                        unset($_SESSION['carts'][$i]);
                    }else{
                        $_SESSION['carts'][$i][4] = $quantity;
                    }

                break;
                }
            }
            exit();
        }

        //SESSION中沒有cart
        if (!isset($_SESSION['carts'])){
            $_SESSION['carts'] = array();
        }

        $flag = 0;


        // SESSION中的格式[id,名稱,照片,價格,數量]
        
        //若cart中有該商品則數量+1
        for($i=0;$i<=$count;$i++){
            if($_SESSION['carts'][$i][0] == $id){
                $_SESSION['carts'][$i][4] += 1;
                $flag = 1;
                break;
            }
        }


        //若購物車沒有此商品新增一筆SESSION
        if ($flag == 0){
            $item = [$id, $name, $image, $price, 1];
            array_push($_SESSION['carts'],$item);
        }

    }


    
    //----------------------------------------


    //登入or驗證
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        //管理員介面登入
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
        }

        //會員註冊
        elseif(isset($_POST['register'])){
            $admin = $_POST['admin'];
            $pass = $_POST['pass'];
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $email = $_POST['email'];
            $birthday = $_POST['birthday'];
            $phone = $_POST['phone'];
        
            $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
            $db->exec("SET CHARACTER SET utf8");
        
        
            $sth = $db->prepare("select * from customers where admin = :admin");
                
            $sth->bindParam("admin", $admin, PDO::PARAM_STR, 50);
            $sth->execute();
        
            $row = $sth->fetch();
        
            if(!empty($row)){
              echo 'exist';
            }else{
              $sth = $db->prepare("insert into customers (admin, password, email, birthday, phone) values (:admin, :pass, :email, :birthday, :phone)");
        
              $sth->bindParam("admin", $admin, PDO::PARAM_STR, 50);
              $sth->bindParam("pass", $pass, PDO::PARAM_STR, 100);
              $sth->bindParam("email", $email, PDO::PARAM_STR, 50);
              $sth->bindParam("birthday", $birthday, PDO::PARAM_STR, 50);
              $sth->bindParam("phone", $phone, PDO::PARAM_STR,50);
          
              $sth->execute();
          
              $db = null;
              exit();
            }
        
        }
        
        //會員登入
        else{
            $acc = $_POST['admin'];
            $pass = $_POST['pass'];
        
        
            $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
            $db->exec("SET CHARACTER SET utf8");
     
            $sth = $db->prepare("select * from customers where admin = :admin");
            $sth->bindParam("admin", $acc, PDO::PARAM_STR, 50);
            $sth->execute();

            $row = $sth->fetch();

            $re = password_verify($pass,$row['password']);

        
            if($re){
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