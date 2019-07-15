<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $horario = $_POST['horario'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['avatar']['name'];
    //Se cuentan todas las imagenes de la carpeta para dar un id a la imagen y que no se repitan los nombres
    $nombreFoto = explode('.', $fotoPerfil);
    $totalImagenes = count(glob('../../iconos/fotos/fotos_perfil/{*.jpg,*.gif,*.png}',GLOB_BRACE));
    $numeroImagen = $totalImagenes + 1;
    $fotoPerfil = $numeroImagen.'.'.$nombreFoto[1];
    //Fin de la conversión del nombre
    $ruta = $_FILES['avatar']['tmp_name'];
    $destino = "../../iconos/fotos/fotos_perfil/".$fotoPerfil;
    copy($ruta, $destino);

    if(!empty($fotoPerfil)){
      $sql = "UPDATE usuario SET foto=?, descripcion=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$destino, $descripcion, $idActual]);

      $sql = "UPDATE protectora SET horario=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$horario, $idActual]);
    }else{
      $sql = "UPDATE usuario SET descripcion=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$descripcion, $idActual]);

      $sql = "UPDATE protectora SET horario=? WHERE user_id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$horario, $idActual]);
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
