<?php
    session_start();

    if(isset($_GET['id'])){

        $id = $_GET['id'];
        $name = $_GET['name'];
        $image = $_GET['image'];
        $price = $_GET['price'];
        $page = $_GET['page'];
        $quantity = $_GET['quantity'];

        if ($page == 'cart'){
            $count = count($_SESSION['carts']);
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
            header("Location: cart.php");
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
                break;
            }
        }


        // 購物車沒有此商品
        if ($flag == 0){
            $item = [$id, $name, $image, $price, 1];
            array_push($_SESSION['carts'],$item);
        }

        header("Location: goodsList.php");

    }




?>