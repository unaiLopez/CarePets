<?php
    $pass = $_POST['pass'];
    $confirmarpass = $_POST['confirmarpass'];
    $resultado = false;

    if(($pass == $confirmarpass) && (strlen($pass) > 5) && (strlen($confirmarpass) > 5)){
      $resultado = true;
      echo $resultado;
    }else{
      echo $resultado;
    }
?>
