<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];

    require_once '../datosAnimal.php?id='.$_POST['id'];
    require_once '../datosUsuario.php';

    //Si existe ya una solicitud tuya en esas fechas se manda una notificación negandotela, si no se manda la solicitud
    $contenido = '<label for="solicitante">Nombre Solicitante</label><p>'.$row1['nombre'].
    '<label for="mailSolicitante">Correo Electrónico Solicitante</label><p>'.$correoActual.
    '<label for="direccion">Dirección Solicitante</label><p>'.$usuario['direccion'].
    '<label for="telefonoMovil">Teléfono Móvil Solicitante</label><p>'.$usuario['telefonomovil'].
    '<label for="nombre">Nombre Animal</label><p>'.$animal['nombre'].
    '</p><br><label for="edad">Edad Animal</label><p>'.$animal['edad'].
    '</p><br><label for="raza">Raza Animal</label><p>'.$animal['raza'].
    '</p><br><label for="sexo">Sexo Animal</label><p>'.$animal['sexo'].
    '</p><br><label for="foto" style="width:50px;height:50px;:border-radius:5px;border: solid 2px #ffffff;">Foto Animal</label><p>'.$animal['foto'].
    '</p><br>';

    $tipo = 'Solicitud';
    $emisor = $row1['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $mailReceptor = $_POST['mailUsuarioServicio'];

    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $mailReceptor);
    $sentencia->execute();
    $usuarioReceptor = $sentencia->fetch(PDO::FETCH_BOTH);

    $receptor = $usuarioReceptor['nombre'];

    $idRespuesta = -1;
    $asunto = 'Solicitud de Adopción <strong>|</strong> '.$_POST['nombre'];
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,emisor,receptor,contenido,fecha,asunto,leidoemisor,leidoreceptor,mailemisor,mailreceptor,idrespuesta) VALUES(:tipo,:emisor,:receptor,:contenido,:fecha,:asunto,:leidoemisor,:leidoreceptor,:mailemisor,:mailreceptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':receptor', $receptor);
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
