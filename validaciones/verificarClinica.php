<?php
  @ob_start();
  session_start();
  if(!isset($_SESSION['verificar']) || $_SESSION['verificar'] != "Clinica"){
      header("Location: /carepets/index.html");
      exit();
  }
?>
