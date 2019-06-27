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
    if($_SESSION['servicio'] == 'Alojamiento'){
      $contenido = '<label for="emisor">Usuario</label><p>'.$_POST['nombreUsuarioServicio'].'
      </p><br><label for="correo">Correo electrónico</label><p>'.$correoActual.'
      </p><br><label for="servicio">Servicio</label><p>'.$_POST['servicio'].'
      </p><br><label for="importeTotal">Importe Total</label><p>'.$_POST['importeTotal'].'
      </p><br><label for="fechaInicio">Fecha Inicio</label><p>'.$_POST['fecha1'].'
      </p><br><label for="fechaFin">Fecha Fin</label><p>'.$_POST['fecha2'].'
      </p><br><label for="direccion">Dirección</label><p>'.$usuario['direccion'].'
      </p><br><label for="telefonoMovil">Teléfono Móvil</label><p>'.$usuario['telefonomovil'].'
      </p><br>';
    }else{
      $contenido = '<label for="emisor">Emisor</label><p>'.$_POST['nombreUsuarioServicio'].'
      </p><br><label for="correo">Correo electrónico</label><p>'.$correoActual.'
      </p><br><label for="servicio">Servicio</label><p>'.$_POST['servicio'].'
      </p><br><label for="importeTotal">Importe Total</label><p>'.$_POST['importeTotal'].'
      </p><br><label for="fechaDia">Día</label><p>'.$_POST['fecha3'].'
      </p><br><label for="direccion">Dirección</label><p>'.$usuario['direccion'].'
      </p><br><label for="telefonoMovil">Teléfono Móvil</label><p>'.$usuario['telefonomovil'].'
      </p><br>';
    }
    
    $tipo = 'Solicitud';
    $emisor = $usuario['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $mailReceptor = $_POST['mailUsuarioServicio'];
    $idRespuesta = -1;
    $asunto = 'Solicitud de Servicio <strong>|</strong> '.$_POST['servicio'];
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
