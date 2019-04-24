<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $nombre = $_POST['nombre'];
    $direccion = $_POST['autocomplete'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $movil = $_POST['movil'];
    $fijo = $_POST['fijo'];
    $mailNuevo = $_POST['mail'];

    $cambiarMovil = false;
    $cambiarFijo = false;
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

    //Buscar en la tabla clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE telefonofijo=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows4 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE telefonomovil=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows5 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla protectora
    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE telefonofijo=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows6 = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows1 && !$rows2 && !$rows3){
      $cambiarMovil = true;
    }

    if(!$rows4 && !$rows5 && !$rows6){
      $cambiarFijo = true;
    }

    if(!$cambiarMovil && !$cambiarCorreo && !$cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailActual]);

    }else if(!$cambiarMovil && !$cambiarCorreo && $cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailActual]);

      //Cambiar información obligatoria
      $sql = "UPDATE protectora SET telefonofijo=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$fijo, $mailActual]);

    }else if(!$cambiarMovil && $cambiarCorreo && !$cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, mailusuario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailNuevo, $mailActual]);

      $_SESSION['mail'] = $mailNuevo;

    }else if(!$cambiarMovil && $cambiarCorreo && $cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, mailusuario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $mailNuevo, $mailActual]);

      //Cambiar información obligatoria
      $sql = "UPDATE protectora SET fijo=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$fijo, $mailNuevo]);

      $_SESSION['mail'] = $mailNuevo;

    }else if($cambiarMovil && !$cambiarCorreo && !$cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, telefonomovil=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $movil, $mailActual]);

    }else if($cambiarMovil && !$cambiarCorreo && $cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, telefonomovil=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $movil, $mailActual]);

      $sql = "UPDATE protectora SET fijo=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$fijo, $mailNuevo]);

    }else if($cambiarMovil && $cambiarCorreo && !$cambiarFijo){
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, telefonomovil=?, mailusuario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $movil, $mailNuevo, $mailActual]);

      $_SESSION['mail'] = $mailNuevo;

    }else{
      //Cambiar información obligatoria
      $sql = "UPDATE usuario SET nombre=?, direccion=?, latitud=?, longitud=?, telefonomovil=?, mailusuario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $direccion, $latitud, $longitud, $movil, $mailNuevo, $mailActual]);

      $sql = "UPDATE protectora SET fijo=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$fijo, $mailNuevo]);

      $_SESSION['mail'] = $mailNuevo;
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
