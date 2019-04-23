<?php
  function conectarse(){
    $local = 0;
    if($local == 0){
      $server ="localhost";
      $user = "root";
      $pass = "";
      $db = "carepets";
    }else{
      $server ="localhost";
      $user = "id9068130_unai";
      $pass = "11111";
      $db = "id9068130_carepets";
    }
    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  }
 ?>
