<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $nombre = $_POST['nombre'];
    $movil = $_POST['movil'];
    $mailNuevo = $_POST['mail'];

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
      $sql = "UPDATE usuario SET nombre=?, mailusuario=?, telefonomovil=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $mailNuevo, $movil, $mailActual]);

      $_SESSION['mail'] = $mailNuevo;

    }else if(!$cambiarMovil && !$cambiarCorreo){

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $mailActual]);

    }else if(!$cambiarMovil && $cambiarCorreo){

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, mailusuario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $mailNuevo, $mailActual]);

      $_SESSION['mail'] = $mailNuevo;

    }else{

      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, telefonomovil=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $movil, $mailActual]);

    }

    header('Location: editarDuenoCuidador.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
