<?php
  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $resultado = false;
    $busco = $_POST['busco'];
    $servicio = $_POST['servicio'];
    $fecha1 = $_POST['date1'];
    $fecha2 = $_POST['date2'];
    $fecha3 = $_POST['date3'];

    if(isset($fecha1)){
      $definida1 = true;
    }
    if(isset($fecha2)){
      $definida2 = true;
    }
    if(isset($fecha3)){
      $definida3 = true;
    }

    date_default_timezone_set("Europe/Madrid");
    $fechaActual = date("Y-m-d");

    //Condicion de buscar un cuidador
    if($busco == 'Cuidador' && $servicio == 'Alojamiento'){
      if($definida1 && $definida2){
        if($fecha1 >= $fechaActual && $fecha1 < $fecha2){
          $resultado = true;
        }
      }
    }else if($busco == 'Cuidador' && $servicio != 'Alojamiento'){
      if($definida3){
        if($fecha3 >= $fechaActual){
          $resultado = true;
        }
      }
    //Condicion de buscar una Clinica o una Protectora
    }else if($busco != 'Cuidador'){
      $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
