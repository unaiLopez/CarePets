<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $id = $_POST['idmensaje'];
    $tipo = 'Respuesta';
    $contenido = '<h4 style="text-align:center;">La solicitud ha sido aceptada.</h4>';
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Conseguir datos del mensaje
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);

    $mailreceptor = $mensaje['mailemisor'];
    $receptor = $mensaje['emisor'];
    $emisor = $mensaje['receptor'];

    if($mensaje['mailemisor'] == $correoActual){
      $leidoemisor = 1;
      $leidoreceptor = 0;
    }else if($mensaje['mailreceptor'] == $correoActual){
      $leidoemisor = 0;
      $leidoreceptor = 1;
    }

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,mailemisor,mailreceptor,emisor,receptor,idrespuesta) VALUES(:tipo,:contenido,:fecha, :mailemisor,:mailreceptor,:emisor,:receptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailreceptor);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':receptor', $receptor);
    $sentencia->bindParam(':idrespuesta', $id);
    $sentencia->execute();

    $sql = "UPDATE mensaje SET leidoemisor=?, leidoreceptor=? WHERE id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$leidoemisor,$leidoreceptor, $id]);

    $solicitudVerificada = 1;

    $sql = "UPDATE solicitud SET solicitudverificada=? WHERE id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$solicitudVerificada, $id]);

    //Conseguir datos del mensaje
    $sentencia = $conn->prepare("SELECT * FROM solicitud WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $solicitud = $sentencia->fetch(PDO::FETCH_BOTH);

    if(isset($solicitud['fechadia'])){
      $fechadia = $solicitud['fechadia'];
      //Insertar evento
      $sentencia = $conn->prepare("INSERT INTO evento (mailusuario,fecha) VALUES(:mailusuario,:fecha)");
      $sentencia->bindParam(':mailusuario', $correoActual);
      $sentencia->bindParam(':fecha', $fechadia);
      $sentencia->execute();
    }else{
      $date1 = new DateTime($solicitud['fechainicio']);
      $date2 = new DateTime($solicitud['fechafinal']);
      $dateIncrementar = $date1;
      $diff = $date1->diff($date2)->format('%d');
      for ($i =0; $i <= $diff; $i++){
        //Insertar evento
        $dateIngresarDB = $dateIncrementar->format('Y-m-d');
        $sentencia = $conn->prepare("INSERT INTO evento (mailusuario,fecha) VALUES(:mailusuario,:fecha)");
        $sentencia->bindParam(':mailusuario', $correoActual);
        $sentencia->bindParam(':fecha', $dateIngresarDB);
        $sentencia->execute();
        $dateIncrementar->modify('+1 day');
      }
    }

    $_SESSION['id'] = $id;

    echo true;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
