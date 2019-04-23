<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include '../usuario/conectarDB.php';

    $conn = conectarse();

    if(isset($_POST['registrar'])){
      //Variables para insertar en la base de datos
      $mailusuario = $_POST['mail'];
      $nombre = $_POST['nombre'];
      $telefonomovil = $_POST['movil'];
      $telefonofijo = $_POST['fijo'];
      $tipo = "Protectora";
      $foronombre = "CarePets";
      $latitud = $_POST['latitud'];
      $longitud = $_POST['longitud'];
      $direccion = $_POST['direccion'];
      //Inicio de la encriptación
      $contraseña = $_POST['pass'];
      $hash = crypt($contraseña, $mailusuario);
      //Fin de la encriptación

      //Insertar en la tabla usuario
      $sentencia = $conn->prepare("INSERT INTO usuario(mailusuario, nombre, contrasena, telefonomovil, tipo, foronombre, latitud, longitud, direccion) VALUES(:mailusuario, :nombre, :contrasena, :telefonomovil, :tipo, :foronombre, :latitud, :longitud, :direccion)");
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':contrasena', $hash);
      $sentencia->bindParam(':telefonomovil', $telefonomovil);
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->bindParam(':foronombre', $foronombre);
      $sentencia->bindParam(':latitud', $latitud);
      $sentencia->bindParam(':longitud', $longitud);
      $sentencia->bindParam(':direccion', $direccion);
      $sentencia->execute();

      //Insertar en la tabla dueñocuidador
      $sentencia = $conn->prepare("INSERT INTO protectora(mailusuario, telefonofijo) VALUES(:mailusuario, :telefonofijo)");
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':telefonofijo', $telefonofijo);
      $sentencia->execute();

      //Crear cookies para guardar datos del usuario
      $_SESSION['mail'] = $mailusuario;
      $_SESSION['verificar'] = $tipo;

      //Redireccionar al perfil del usuario
      header('Location: ../usuario/perfilProtectora.php');

    }
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
