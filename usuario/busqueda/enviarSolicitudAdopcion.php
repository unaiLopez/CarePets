<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];

    $sentencia = $conn->prepare("SELECT direccion,telefonomovil,nombre FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_BOTH);

    //Si existe ya una solicitud tuya en esas fechas se manda una notificación negandotela, si no se manda la solicitud
    $contenido = '<label for="solicitante">Nombre Solicitante</label><p>'.$usuario['nombre'].
    '<label for="mailSolicitante">Correo Electrónico Solicitante</label><p>'.$correoActual.
    '<label for="direccion">Dirección Solicitante</label><p>'.$usuario['direccion'].
    '<label for="telefonoMovil">Teléfono Móvil Solicitante</label><p>'.$usuario['telefonomovil'].
    '<label for="nombre">Nombre Animal</label><p>'.$_POST['nombre'].
    '</p><br><label for="edad">Edad Animal</label><p>'.$_POST['edad'].
    '</p><br><label for="raza">Raza Animal</label><p>'.$_POST['raza'].
    '</p><br><label for="sexo">Sexo Animal</label><p>'.$_POST['sexo'].
    '</p><br><label for="foto" style="width:50px;height:50px;:border-radius:5px;border: solid 2px #ffffff;">Foto Animal</label><p>'.$_POST['foto'].
    '</p><br>';

    $tipo = 'Solicitud';
    $emisor = $usuario['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $mailReceptor = $_POST['mailUsuarioServicio'];
    $idRespuesta = -1;
    $asunto = 'Solicitud de Adopción <strong>|</strong> '.$_POST['nombre'];
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,emisor,contenido,fecha,asunto,leidoemisor,leidoreceptor,mailemisor,mailreceptor,idrespuesta) VALUES(:tipo,:emisor,:contenido,:fecha,:asunto,:leidoemisor,:leidoreceptor,:mailemisor,:mailreceptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':asunto', $asunto);
    $sentencia->bindParam(':leidoemisor', $leidoEmisor);
    $sentencia->bindParam(':leidoreceptor', $leidoReceptor);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailReceptor);
    $sentencia->bindParam(':idrespuesta', $idRespuesta);
    $sentencia->execute();

    if($sentencia){
      echo true;
    }else{
      echo false;
    }



  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
