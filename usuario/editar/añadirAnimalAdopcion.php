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
      //Insertar animal
      $sentencia = $conn->prepare("INSERT INTO animal(foto, fecha, nombre, raza, peso, desparasitado, amigable, esterilizado, vacunado, sexo, edad, descripcion, mailusuario) VALUES(:foto, :fecha, :nombre, :raza, :peso, :desparasitado, :amigable, :esterilizado, :vacunado, :sexo, :edad, :descripcion, :mailusuario)");
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->bindParam(':foto', $destino);
      $sentencia->bindParam(':fecha', $fecha);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':raza', $raza);
      $sentencia->bindParam(':peso', $peso);
      $sentencia->bindParam(':desparasitado', $desparasitado);
      $sentencia->bindParam(':amigable', $amigable);
      $sentencia->bindParam(':esterilizado', $esterilizado);
      $sentencia->bindParam(':vacunado', $vacunado);
      $sentencia->bindParam(':sexo', $sexo);
      $sentencia->bindParam(':edad', $edad);
      $sentencia->bindParam(':descripcion', $descripcion);
      $sentencia->execute();

    }else{
      //Insertar en la tabla usuario
      $sentencia = $conn->prepare("INSERT INTO animal(fecha, nombre, raza, peso, desparasitado, amigable, esterilizado, vacunado, sexo, edad, descripcion, mailusuario) VALUES(:fecha, :nombre, :raza, :peso, :desparasitado, :amigable, :esterilizado, :vacunado, :sexo, :edad, :descripcion, :mailusuario)");
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->bindParam(':fecha', $fecha);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':raza', $raza);
      $sentencia->bindParam(':peso', $peso);
      $sentencia->bindParam(':desparasitado', $desparasitado);
      $sentencia->bindParam(':amigable', $amigable);
      $sentencia->bindParam(':esterilizado', $esterilizado);
      $sentencia->bindParam(':vacunado', $vacunado);
      $sentencia->bindParam(':sexo', $sexo);
      $sentencia->bindParam(':edad', $edad);
      $sentencia->bindParam(':descripcion', $descripcion);
      $sentencia->execute();
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
