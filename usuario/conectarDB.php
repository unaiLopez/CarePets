<?php
  function conectarse(){
    $local = 0;
    if($local == 0){
      $server ="localhost";
      $user = "root";
      $pass = "";
      $db = "carepets";
    }else{
      $server ="db5000152620.hosting-data.io";
      $user = "dbu319775";
      $pass = "Aixerrota1#";
      $db = "dbs147722";
    }
    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  }
 ?>
