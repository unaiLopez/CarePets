<?php
	@ob_start();
	session_start();

  try {
    //Configurar base de datos
    include 'conectarDB.php';

    $conn = conectarse();

    if(isset($_POST['ingresar'])){
      //Variables para buscar en la BD
      $correo = $_POST['mail'];
      //Inicio de la encriptación
      $contraseña = $_POST['pass'];
      $hash = crypt($contraseña, $correo);
      //Fin de la encriptación

      //Tomar el valor de la contraseña y del mail
      $sentencia = $conn->prepare("SELECT contrasena,tipo FROM usuario WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correo);
      $sentencia->execute();
      $row = $sentencia->fetch(PDO::FETCH_BOTH);

      //Verificar si el usuario existe y si la contraseña es correta
      if($row && $row[0] == $hash){
        $_SESSION['mail'] = $correo;
        if($row[1] == "DuenoCuidador"){
          $_SESSION['verificar'] = "DuenoCuidador";
          //Redireccionar a la página inicial del DueñoCuidador
          header('Location: perfil/perfilDuenoCuidador.php');
        }else if($row[1] == "Protectora"){
          $_SESSION['verificar'] = "Protectora";
          //Redireccionar a la página inicial de la Protectora
          header('Location: perfil/perfilProtectora.php');
        }else if($row[1] == "Clinica"){
          $_SESSION['verificar'] = "Clinica";
          //Redireccionar a la página inicial de la Clínica
          header('Location: perfil/perfilClinica.php');
        }
      }
    }
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
