<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $sexo = $_POST['sexo'];
    $edad = $_POST['edad'];
    $desparasitado = $_POST['desparasitado'];
    $amigable = $_POST['amigable'];
    $esterilizado = $_POST['esterilizado'];
    $vacunado = $_POST['vacunado'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['avatar']['name'];
    $ruta = $_FILES['avatar']['tmp_name'];
    $destino = "../../iconos/fotos/".$fotoPerfil;
    copy($ruta, $destino);
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    if(!empty($fotoPerfil)){
      $sql = "UPDATE animal SET foto=?, fecha=?, nombre=?, raza=?, peso=?, desparasitado=?, amigable=?, esterilizado=?, vacunado=?, sexo=?, edad=?, descripcion=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$destino, $fecha, $nombre, $raza, $peso, $desparasitado, $amigable, $esterilizado, $vacunado, $sexo, $edad, $descripcion, $mailActual]);
    }else{
      $sql = "UPDATE animal SET nombre=?, fecha=?, raza=?, peso=?, desparasitado=?, amigable=?, esterilizado=?, vacunado=?, sexo=?, edad=?, descripcion=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$nombre, $fecha, $raza, $peso, $desparasitado, $amigable, $esterilizado, $vacunado, $sexo, $edad, $descripcion, $mailActual]);
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
