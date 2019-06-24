<?php
  @ob_start();
  session_start();

  $id = $_POST['id'];
  $buscarTipo = $_POST['buscarTipo'];
  $fechaInicio = $_POST['fechaInicio'];
  $fechaFin = $_POST['fechaFin'];
  $fechaDia = $_POST['fechaDia'];
  $servicio = $_POST['servicio'];
  $precio = $_POST['precio'];

  $_SESSION['id'] = $id;
  $_SESSION['buscarTipo'] = $buscarTipo;
  $_SESSION['fechaInicio'] = $fechaInicio;
  $_SESSION['servicio'] = $servicio;
  $_SESSION['fechaDia'] = $fechaDia;
  $_SESSION['fechaFin'] = $fechaFin;
  $_SESSION['precio'] = $precio;
?>
