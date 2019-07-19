<?php
  @ob_start();
  session_start();
  try {

    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
    $idMensaje = $_POST['idMensaje'];
    $idUsuarioValorado = $_POST['id'];
    $puntuacion = $_POST['puntuacion'];

    //Insertar valoracion
    $sentencia = $conn->prepare("INSERT INTO valoracion(user_id_valorador, user_id_valorado, puntuacion) VALUES(:user_id_valorador, :user_id_valorado, :puntuacion)");
    $sentencia->bindParam(':user_id_valorador', $idActual);
    $sentencia->bindParam(':user_id_valorado', $idUsuarioValorado);
    $sentencia->bindParam(':puntuacion', $puntuacion);
    $sentencia->execute();

    if($sentencia){

      $valorado = 1;

      //Cambiar solicitud a valorada
      $sentencia = $conn->prepare("UPDATE solicitud SET serviciovalorado=:valorado WHERE id=:id");
      $sentencia->bindParam(':valorado', $valorado);
      $sentencia->bindParam(':id', $idMensaje);
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

?>
