<?php
  session_start();
  if(!isset($_SESSION['verificar']) || $_SESSION['verificar'] != "Protectora"){
      header("Location: ../index.html");
      exit();
  }
?>
