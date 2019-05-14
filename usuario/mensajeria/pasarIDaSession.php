<?php
  @ob_start();
  session_start();

  $id = $_POST['id'];
  $_SESSION['id'] = $id;
?>
