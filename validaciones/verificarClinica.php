<?php
  session_start();
  if(!isset($_SESSION['verificar']) || $_SESSION['verificar'] != "Clinica"){
      header("Location: ../index.html");
      exit();
  }
?>
