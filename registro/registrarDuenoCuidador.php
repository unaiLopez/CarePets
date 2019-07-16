<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    if(isset($_POST['registrar'])){
      //Variables para insertar en la base de datos
      $mailusuario = $_POST['mail'];
      $nombre = $_POST['nombre'];
      $telefonomovil = $_POST['movil'];
      $tipo = "DuenoCuidador";
      $escuidador = 0;
      $latitud = $_POST['latitud'];
      $longitud = $_POST['longitud'];
      $direccion = $_POST['direccion'];
      //Inicio de la encriptación
      $contraseña = $_POST['pass'];
      $hash = crypt($contraseña, $tipo);
      //Fin de la encriptación

      //Insertar en la tabla usuario
      $sentencia = $conn->prepare("INSERT INTO usuario(mailusuario, nombre, contrasena, telefonomovil, tipo, latitud, longitud, direccion) VALUES(:mailusuario, :nombre, :contrasena, :telefonomovil, :tipo, :latitud, :longitud, :direccion)");
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':contrasena', $hash);
      $sentencia->bindParam(':telefonomovil', $telefonomovil);
      $sentencia->bindParam(':tipo', $tipo);
      $sentencia->bindParam(':latitud', $latitud);
      $sentencia->bindParam(':longitud', $longitud);
      $sentencia->bindParam(':direccion', $direccion);
      $sentencia->execute();

      //Insertar en la tabla dueñocuidador
      $last_id = $conn->lastInsertId();
      $sentencia = $conn->prepare("INSERT INTO duenocuidador(user_id, mailusuario, escuidador) VALUES(:user_id, :mailusuario, :escuidador)");
      $sentencia->bindParam(':user_id', $last_id);
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':escuidador', $escuidador);
      $sentencia->execute();

      $tiempo = time();
      $fecha = date("Y-m-d", $tiempo);


      //Crear cookies para guardar datos del usuario
      $_SESSION['user_id'] = $last_id;
      $_SESSION['verificar'] = $tipo;

      //Redireccionar al perfil del usuario
      header('Location: ../usuario/perfil/perfilDuenoCuidador.php');

    }
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
