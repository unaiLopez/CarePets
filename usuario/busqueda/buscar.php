<?php

    $correoActual = $_SESSION['mail'];
    $tipoBusqueda = $_POST['buscarTipo'];
    $servicio = $_POST['elegirServicio'];
    $inicioFecha = $_POST['fecha1'];
    $finalFecha = $_POST['fecha2'];
    $diaFecha = $_POST['fecha3'];

    if($tipoBusqueda == 'Cuidador'){

      $esCuidador = 1;
      $tipo = 'DuenoCuidador';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetch(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Clinica Veterinaria'){

      $tipo = 'Clinica';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetch(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Protectora de Animales'){

      $tipo = 'Protectora';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->execute();
      $busqueda = $sentencia->fetch(PDO::FETCH_BOTH);

    }

    $conn = null;
?>
