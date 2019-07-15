<?php
  @ob_start();
  session_start();

  $_SESSION['idUsuarioServicio'] = $_POST['idUsuarioServicio'];
  $_SESSION['buscarTipo'] = $_POST['buscarTipo'];
  $_SESSION['fechaInicio'] = $_POST['fechaInicio'];
  $_SESSION['servicio'] = $_POST['servicio'];
  $_SESSION['fechaDia'] = $_POST['fechaDia'];
  $_SESSION['fechaFin'] = $_POST['fechaFin'];
  $_SESSION['precio'] = $_POST['precio'];
?>
