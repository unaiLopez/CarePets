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
    //Se cuentan todas las imagenes de la carpeta para dar un id a la imagen y que no se repitan los nombres
    $nombreFoto = explode('.', $fotoPerfil);
    $totalImagenes = count(glob('../../iconos/fotos/fotos_animales/{*.jpg,*.gif,*.png}',GLOB_BRACE));
    $numeroImagen = $totalImagenes + 1;
    $fotoPerfil = $numeroImagen.'.'.$nombreFoto[1];
    //Fin de la conversión del nombre
    $ruta = $_FILES['avatar']['tmp_name'];
    $destino = "../../iconos/fotos/fotos_animales/".$fotoPerfil;
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
