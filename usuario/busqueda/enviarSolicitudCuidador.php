<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_BOTH);

    $servicio = $_POST['servicio'];
    $importetotal = $_POST['importeTotal'];
    $contenido = 'Se solicita lo siguiente :';
    $direccion = $usuario['direccion'];
    $telefonomovil = $usuario['telefonomovil'];

    if($_SESSION['servicio'] == 'Alojamiento'){

      $fechafinal = $_POST['fecha2'];
      $fechainicio = $_POST['fecha1'];

    }else{

      $fechadia = $_POST['fecha3'];

    }

    $tipo = 'Solicitud';
    $emisor = $usuario['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $user_id_receptor = $_POST['idUsuarioServicio'];

    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $user_id_receptor);
    $sentencia->execute();
    $usuarioReceptor = $sentencia->fetch(PDO::FETCH_BOTH);

    $receptor = $usuarioReceptor['nombre'];

    $asunto = 'Solicitud de Servicio <strong>|</strong> '.$servicio;
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,emisor,receptor,contenido,fecha,asunto,leidoemisor,leidoreceptor,user_id_emisor,user_id_receptor) VALUES(:tipo,:emisor,:receptor,:contenido,:fecha,:asunto,:leidoemisor,:leidoreceptor,:user_id_emisor,:user_id_receptor)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':receptor', $receptor);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':asunto', $asunto);
    $sentencia->bindParam(':leidoemisor', $leidoEmisor);
    $sentencia->bindParam(':leidoreceptor', $leidoReceptor);
    $sentencia->bindParam(':user_id_emisor', $idActual);
    $sentencia->bindParam(':user_id_receptor', $user_id_receptor);
    $sentencia->execute();
    $ultimoId = $conn->lastInsertId();

    if($sentencia){
      if(isset($fechadia)){
        //Insertar mensaje de respuesta
        $sentencia = $conn->prepare("INSERT INTO solicitud (id,servicio,importetotal,fechadia) VALUES(:id,:servicio,:importetotal,:fechadia)");
        $sentencia->bindParam(':servicio', $servicio);
        $sentencia->bindParam(':importetotal', $importetotal);
        $sentencia->bindParam(':fechadia', $fechadia);
        $sentencia->bindParam(':id', $ultimoId);
        $sentencia->execute();
      }else{
        //Insertar mensaje de respuesta
        $sentencia = $conn->prepare("INSERT INTO solicitud (id,servicio,importetotal,fechafinal,fechainicio) VALUES(:id,:servicio,:importetotal,:fechafinal,:fechainicio)");
        $sentencia->bindParam(':servicio', $servicio);
        $sentencia->bindParam(':importetotal', $importetotal);
        $sentencia->bindParam(':fechafinal', $fechafinal);
        $sentencia->bindParam(':fechainicio', $fechainicio);
        $sentencia->bindParam(':id', $ultimoId);
        $sentencia->execute();
      }

      if($sentencia){
        echo true;
      }else{
        echo false;
      }

    }else{
      echo false;
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
