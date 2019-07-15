<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $tipo = $_SESSION['verificar'];
    $idActual = $_SESSION['user_id'];
    //Encriptar la contraseña para poder buscarla en la BD
    $passActual = $_POST['passActual'];
    $hash = crypt($passActual, $tipo);
    //Fin de la encriptación

    //Encriptar la contraseña para poder insertarla en la BD
    $passNueva = $_POST['passNueva'];
    $hashNuevo = crypt($passNueva, $tipo);
    //Fin de la encriptación

    //Cambiar la contraseña actual del usuario
    $sql = "UPDATE usuario SET contrasena=? WHERE user_id=? and contrasena=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$hashNuevo, $idActual, $hash]);

    if($tipo == 'Clinica'){
      //Redireccionar a la misma página
      header('Location: editarClinica.php');
    }else if($tipo == 'Protectora'){
      //Redireccionar a la misma página
      header('Location: editarProtectora.php');
    }else{
      //Redireccionar a la misma página
      header('Location: editarDuenoCuidador.php');
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
