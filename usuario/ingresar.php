<?php
	@ob_start();
	session_start();

  try {
    //Configurar base de datos
    require_once 'conectarDB.php';

    $conn = conectarse();

    if(isset($_POST['ingresar'])){
      //Variables para buscar en la BD
      $correo = $_POST['mail'];
			//Tomar el tipo de usuario
      $sentencia = $conn->prepare("SELECT tipo FROM usuario WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correo);
      $sentencia->execute();
      $tipoUsuario = $sentencia->fetch(PDO::FETCH_BOTH);

      //Inicio de la encriptación
      $contraseña = $_POST['pass'];
			$tipo = $tipoUsuario['tipo'];
      $hash = crypt($contraseña, $tipo);
      //Fin de la encriptación

      //Tomar el valor de la contraseña y del id
      $sentencia = $conn->prepare("SELECT user_id,contrasena,tipo FROM usuario WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correo);
      $sentencia->execute();
      $row = $sentencia->fetch(PDO::FETCH_BOTH);

      //Verificar si el usuario existe y si la contraseña es correta
      if($row && $row['contrasena'] == $hash){
				$_SESSION['user_id'] = $row['user_id'];
        if($row['tipo'] == "DuenoCuidador"){
          $_SESSION['verificar'] = "DuenoCuidador";
          //Redireccionar a la página inicial del DueñoCuidador
          header('Location: perfil/perfilDuenoCuidador.php');
        }else if($row['tipo'] == "Protectora"){
          $_SESSION['verificar'] = "Protectora";
          //Redireccionar a la página inicial de la Protectora
          header('Location: perfil/perfilProtectora.php');
        }else if($row['tipo'] == "Clinica"){
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
