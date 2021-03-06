<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $nombre = $_POST['nombre'];
    $movil = $_POST['movil'];
    $mailNuevo = $_POST['mail'];
    $direccion = $_POST['autocomplete'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $cambiarMovil = false;
    $cambiarCorreo = false;

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $mailNuevo);
    $sentencia->execute();
    $rows = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows){
      $cambiarCorreo = true;
    }

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE telefonomovil=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows1 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE telefonofijo=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows2 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla protectora
    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE telefonofijo=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows3 = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows1 && !$rows2 && !$rows3){
      $cambiarMovil = true;
    }

    if($cambiarMovil && $cambiarCorreo){

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, mailusuario=?, telefonomovil=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailNuevo, $movil, $idActual]);

    }else if(!$cambiarMovil && !$cambiarCorreo){

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $idActual]);

    }else if(!$cambiarMovil && $cambiarCorreo){

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, mailusuario=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailNuevo, $idActual]);

    }else{

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, telefonomovil=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $movil, $idActual]);

    }

    header('Location: editarDuenoCuidador.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
