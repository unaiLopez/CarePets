<?php
  try {

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
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
      $tipo = 'DuenoCuidador';

      if($servicio == 'Visita a Domicilio'){
        $servicio = 'Visita';
      }else if($servicio == 'Cuidado de Día'){
        $servicio = 'Dia Entero';
      }

      if($servicio == 'Alojamiento'){

        $sentencia = $conn->prepare("SELECT DISTINCT u.*, s.precio, s.nombre as nombreservicio
        FROM usuario AS u NATURAL JOIN duenocuidador AS d INNER JOIN servicio AS s ON s.user_id=d.user_id LEFT JOIN evento as e ON u.user_id=e.user_id_dar
        WHERE tipo=:tipo and d.escuidador=:escuidador and s.nombre=:servicio and s.precio > 0 and u.user_id not in (:user_id) and u.user_id not in(select user_id_dar from evento as ev where ev.fecha between(:fecha1) and (:fecha2))");
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':escuidador', $esCuidador);
        $sentencia->bindParam(':fecha1', $inicioFecha);
        $sentencia->bindParam(':fecha2', $finalFecha);
        $sentencia->bindParam(':servicio', $servicio);
        $sentencia->bindParam(':user_id', $idActual);
        $sentencia->execute();
        $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

      }else{

        $sentencia = $conn->prepare("SELECT DISTINCT u.*, s.precio, s.nombre as nombreservicio
        FROM usuario AS u NATURAL JOIN duenocuidador AS d INNER JOIN servicio AS s ON s.user_id=d.user_id LEFT JOIN evento as e ON u.user_id=e.user_id_dar
        WHERE tipo=:tipo and d.escuidador=:escuidador and s.nombre=:servicio and s.precio > 0 and u.user_id not in (:user_id) and (:fecha3) not in (select fecha from evento as ev where u.user_id=ev.user_id_dar)");
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':escuidador', $esCuidador);
        $sentencia->bindParam(':fecha3', $diaFecha);
        $sentencia->bindParam(':servicio', $servicio);
        $sentencia->bindParam(':user_id', $idActual);
        $sentencia->execute();
        $busqueda = $sentencia->fetchAll(PDO::FETCH_BOTH);

      }


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
