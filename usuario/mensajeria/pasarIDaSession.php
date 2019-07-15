<?php
  @ob_start();
  session_start();

  $_SESSION['id'] = $_POST['id'];
?>
