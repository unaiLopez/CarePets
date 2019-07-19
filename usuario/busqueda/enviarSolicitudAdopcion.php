<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $idAnimal = $_POST['id'];

    //Tomar todos los datos de todos los animales en adopcion del usuario
    $sentencia = $conn->prepare("SELECT * FROM animal WHERE id=:id");
    $sentencia->bindParam(':id', $idAnimal);
    $sentencia->execute();
    $animal = $sentencia->fetch(PDO::FETCH_BOTH);

    require_once '../datosUsuario.php';

    $servicio = 'Adopción';
    $contenido = 'Se solicita lo siguiente :';
    $direccion = $row1['direccion'];
    $telefonomovil = $row1['telefonomovil'];

    $tipo = 'Solicitud';
    $emisor = $row1['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $user_id_receptor = $_POST['idUsuarioServicio'];

    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $user_id_receptor);
    $sentencia->execute();
    $usuarioReceptor = $sentencia->fetch(PDO::FETCH_BOTH);

    $receptor = $usuarioReceptor['nombre'];

    $asunto = 'Solicitud de Adopción de <strong>|</strong> '.$animal['nombre'];
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
        //Insertar mensaje de respuesta
        $sentencia = $conn->prepare("INSERT INTO solicitud (id,servicio,id_animal) VALUES(:id,:servicio,:id_animal)");
        $sentencia->bindParam(':servicio', $servicio);
        $sentencia->bindParam(':id', $ultimoId);
        $sentencia->bindParam(':id_animal', $animal['id']);
        $sentencia->execute();

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
