<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
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

    $user_id_receptor = $mensaje['user_id_emisor'];
    $receptor = $mensaje['emisor'];
    $emisor = $mensaje['receptor'];

    if($mensaje['user_id_emisor'] == $idActual){
      $leidoemisor = 1;
      $leidoreceptor = 0;
    }else if($mensaje['user_id_receptor'] == $idActual){
      $leidoemisor = 0;
      $leidoreceptor = 1;
    }

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,user_id_emisor,user_id_receptor,emisor,receptor,idrespuesta) VALUES(:tipo,:contenido,:fecha, :user_id_emisor,:user_id_receptor,:emisor,:receptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':user_id_emisor', $idActual);
    $sentencia->bindParam(':user_id_receptor', $user_id_receptor);
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
      $sentencia = $conn->prepare("INSERT INTO evento (user_id_dar,user_id_recibir,fecha,servicio) VALUES(:user_id_dar,:user_id_recibir,:fecha,:servicio)");
      $sentencia->bindParam(':user_id_dar', $idActual);
      $sentencia->bindParam(':user_id_recibir', $mensaje['user_id_emisor']);
      $sentencia->bindParam(':fecha', $fechadia);
      $sentencia->bindParam(':servicio', $solicitud['servicio']);
      $sentencia->execute();
    }else{
      $date1 = new DateTime($solicitud['fechainicio']);
      $date2 = new DateTime($solicitud['fechafinal']);
      $dateIncrementar = $date1;
      $diff = $date1->diff($date2)->format('%d');
      for ($i =0; $i <= $diff; $i++){
        //Insertar evento
        $dateIngresarDB = $dateIncrementar->format('Y-m-d');
        $sentencia = $conn->prepare("INSERT INTO evento (user_id_dar,user_id_recibir,fecha,servicio) VALUES(:user_id_dar,:user_id_recibir,:fecha,:servicio)");
        $sentencia->bindParam(':user_id_dar', $idActual);
        $sentencia->bindParam(':user_id_recibir', $mensaje['user_id_emisor']);
        $sentencia->bindParam(':fecha', $dateIngresarDB);
        $sentencia->bindParam(':servicio', $solicitud['servicio']);
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
