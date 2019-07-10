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
      $tipo = "DuenoCuidador";
      $foronombre = "CarePets";
      $escuidador = 0;
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
      $sentencia = $conn->prepare("INSERT INTO duenocuidador(mailusuario, escuidador) VALUES(:mailusuario, :escuidador)");
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':escuidador', $escuidador);
      $sentencia->execute();

      $tiempo = time();
      $fecha = date("Y-m-d", $tiempo);

      //Insertar evento
      $sentencia = $conn->prepare("INSERT INTO evento(mailusuario, fecha) VALUES(:mailusuario, :fecha)");
      $sentencia->bindParam(':mailusuario', $mailusuario);
      $sentencia->bindParam(':fecha', $fecha);
      $sentencia->execute();


      //Crear cookies para guardar datos del usuario
      $_SESSION['mail'] = $mailusuario;
      $_SESSION['verificar'] = $tipo;

      //Redireccionar al perfil del usuario
      header('Location: ../usuario/perfil/perfilDuenoCuidador.php');

    }
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
