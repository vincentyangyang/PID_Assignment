<?php
    header("content-type:text/html; charset=utf-8");

    $db = new PDO("mysql:host=127.0.0.1;dbname=Online_Shop", "root", "root");
    $db->exec("SET CHARACTER SET utf8");


    if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){

      $sth = $db->prepare("delete from Goods where gId = :gId");
      $sth->bindParam("gId", $_GET['id'], PDO::PARAM_INT);    
      $sth->execute();
    }





    $db = null;

?>