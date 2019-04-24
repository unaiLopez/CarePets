<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include 'conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $horario = $_POST['horario'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['avatar']['name'];
    $ruta = $_FILES['avatar']['tmp_name'];
    $destino = "../iconos/fotos/".$fotoPerfil;
    copy($ruta, $destino);

    if(!empty($fotoPerfil)){
      $sql = "UPDATE usuario SET foto=?, descripcion=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$destino, $descripcion, $mailActual]);

      $sql = "UPDATE protectora SET horario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$horario, $mailActual]);
    }else{
      $sql = "UPDATE usuario SET descripcion=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$descripcion, $mailActual]);

      $sql = "UPDATE protectora SET horario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$horario, $mailActual]);
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
