<?php
  @ob_start();
  session_start();
  if(!isset($_SESSION['verificar']) || $_SESSION['verificar'] != "DuenoCuidador"){
      header("Location: /carepets/index.html");
      exit();
  }
?>
