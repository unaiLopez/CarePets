<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $tipo = $_SESSION['verificar'];
    $mail = $_SESSION['mail'];
    //Encriptar la contraseña para poder buscarla en la BD
    $passActual = $_POST['passActual'];
    $hash = crypt($passActual, $mail);
    //Fin de la encriptación

    //Encriptar la contraseña para poder insertarla en la BD
    $passNueva = $_POST['passNueva'];
    $hashNuevo = crypt($passNueva, $mail);
    //Fin de la encriptación

    //Cambiar la contraseña actual del usuario
    $sql = "UPDATE usuario SET contrasena=? WHERE mailusuario=? and contrasena=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$hashNuevo, $mail, $hash]);

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
