<?php
  try {

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $tipoBusqueda = $_GET['buscarTipo'];
    $servicio = $_GET['elegirServicio'];
    if(isset($_GET['date1'])){
      $inicioFecha = $_GET['date1'];
    }
    if(isset($_GET['date2'])){
      $finalFecha = $_GET['date2'];
    }
    if(isset($_GET['date3'])){
      $diaFecha = $_GET['date3'];
    }
    if($tipoBusqueda == 'Cuidador'){

      $esCuidador = 1;
      $eventosNo = 0;
      $eventosSi = 1;
      $tipo = 'DuenoCuidador';

      $sentencia = $conn->prepare("SELECT DISTINCT u.*, s.precio, s.nombre as nombreservicio
      FROM usuario AS u NATURAL JOIN duenocuidador AS d INNER JOIN servicio AS s ON s.mailusuario=d.mailusuario, evento as e
      WHERE tipo=:tipo and d.escuidador=:escuidador and s.nombre=:servicio and s.precio > 0 and u.mailusuario not in (:mailusuario) and d.eventos=:eventosNo or d.eventos=:eventosSi and e.fecha not between (:fecha1) and (:fecha2) and fecha not in (:fecha3) and s.nombre=:servicio and s.precio > 0");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->bindParam(':eventosNo', $eventosNo);
      $sentencia->bindParam(':eventosSi', $eventosSi);
      $sentencia->bindParam(':escuidador', $esCuidador);
      $sentencia->bindParam(':fecha1', $inicioFecha);
      $sentencia->bindParam(':fecha2', $finalFecha);
      $sentencia->bindParam(':fecha3', $diaFecha);
      $sentencia->bindParam(':servicio', $servicio);
      $sentencia->bindParam(':mailusuario', $correoActual);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Clinica Veterinaria'){

      $tipo = 'Clinica';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo and mailusuario not in (:mailusuario)");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->bindParam(':mailusuario', $correoActual);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }else if($tipoBusqueda == 'Protectora de Animales'){

      $tipo = 'Protectora';

      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE tipo=:tipo and mailusuario not in (:mailusuario)");
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->bindParam(':mailusuario', $correoActual);
      $sentencia->execute();
      $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

    }
    $cantidadUsuarios = count($busqueda);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
