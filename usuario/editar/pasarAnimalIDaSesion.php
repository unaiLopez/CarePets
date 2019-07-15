<?php
  @ob_start();
  session_start();

  $_SESSION['idAnimal'] = $_POST['id'];
?>
