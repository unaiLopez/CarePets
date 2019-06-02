<?php
  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $fecha3 = $_POST['fecha3'];
    $fecha1 = strtotime($fecha1);
    $fecha2 = strtotime($fecha2);
    $fecha3 = strtotime($fecha3);
    $tiempo = time();
    $fechaActual = date("Y-m-d H:i:s", $tiempo);
    $resultado = true;

    if(isset($fecha3)){
      if($fecha3 >= $fechaActual){
        $resultado = true;
      }
    }else if($fecha1 > $fecha2 && $fecha1 >= $fechaActual && $fecha2 > $fechaActual){
      $resultado = true;
    }
    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
