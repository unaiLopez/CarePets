<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $sexo = $_POST['sexo'];
    $fechaNacimiento = $_POST['calendario'];
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
      $sql = "UPDATE usuario SET foto=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$destino, $mailActual]);

      $sql = "UPDATE duenocuidador SET apellido1=?, apellido2=?, sexo=?, fechanacimiento=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$apellido1, $apellido2, $sexo, $fechaNacimiento, $mailActual]);
    }else{
      $sql = "UPDATE duenocuidador SET apellido1=?, apellido2=?, sexo=?, fechanacimiento=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$apellido1, $apellido2, $sexo, $fechaNacimiento, $mailActual]);
    }

    header('Location: editarDuenoCuidador.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
