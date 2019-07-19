<?php
  @ob_start();
  session_start();
  try {

    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
    $idUsuarioValorado = $_POST['id'];
    $puntuacion = $_POST['puntuacion'];

    //Tomar la cantidad de veces que ha sido valorado el usuario
    $sentencia = $conn->prepare("SELECT * FROM valoracion WHERE user_id_valorador=:user_id_valorador and user_id_valorado=:user_id_valorado");
    $sentencia->bindParam(':user_id_valorador', $idActual);
    $sentencia->bindParam(':user_id_valorado', $idUsuarioValorado);
    $sentencia->execute();
    $valoraciones = $sentencia->fetchAll(PDO::FETCH_BOTH);

    if(!$valoraciones){
      //Insertar valoracion
      $sentencia = $conn->prepare("INSERT INTO valoracion(user_id_valorador, user_id_valorado, puntuacion) VALUES(:user_id_valorador, :user_id_valorado, :puntuacion)");
      $sentencia->bindParam(':user_id_valorador', $idActual);
      $sentencia->bindParam(':user_id_valorado', $idUsuarioValorado);
      $sentencia->bindParam(':puntuacion', $puntuacion);
      $sentencia->execute();

      echo true;

    }else{

      echo false;

    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
