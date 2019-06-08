<?php
  try {

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $tipoBusqueda = $_POST['buscarTipo'];
    $servicio = $_POST['elegirServicio'];
    if(isset($_POST['fecha1'])){
      $inicioFecha = $_POST['fecha1'];
    }
    if(isset($_POST['fecha2'])){
      $finalFecha = $_POST['fecha2'];
    }
    if(isset($_POST['fecha3'])){
      $diaFecha = $_POST['fecha3'];
    }

    if($tipoBusqueda == 'Cuidador'){

      $esCuidador = 1;
      $tipo = 'DuenoCuidador';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Clinica Veterinaria'){

      $tipo = 'Clinica';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Protectora de Animales'){

      $tipo = 'Protectora';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }
    $cantidadUsuarios = count($busqueda);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
