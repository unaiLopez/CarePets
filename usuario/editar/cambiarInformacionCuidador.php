<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $escuidador = 1;
    $descripcion = $_POST['descripcion'];
    $perro = $_POST['perros'];
    $gato = $_POST['gatos'];
    $exotico = $_POST['exoticos'];
    $otro = $_POST['otros'];
    $pequeño = $_POST['pequeno'];
    $mediano = $_POST['mediano'];
    $grande = $_POST['grande'];
    $experiencia = $_POST['experiencia'];
    $alojamiento = 'Alojamiento';
    $diaentero = 'Dia Entero';
    $paseo = 'Paseo';
    $visita = 'Visita';
    $precioalojamiento = $_POST['precioAlojamiento'];
    $preciodiaentero = $_POST['preciodiaentero'];
    $preciopaseo = $_POST['preciopaseo'];
    $preciovisita = $_POST['preciovisita'];

    //Buscar si ofrece servicio alojamiento
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $mailActual);
    $sentencia->bindParam(':nombre', $alojamiento);
    $sentencia->execute();
    $rowAlojamiento = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio día entero
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $mailActual);
    $sentencia->bindParam(':nombre', $diaentero);
    $sentencia->execute();
    $rowDiaEntero = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio paseo
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $mailActual);
    $sentencia->bindParam(':nombre', $paseo);
    $sentencia->execute();
    $rowPaseo = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio visita
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $mailActual);
    $sentencia->bindParam(':nombre', $visita);
    $sentencia->execute();
    $rowVisita = $sentencia->fetch(PDO::FETCH_BOTH);

    if(!$rowAlojamiento && isset($alojamiento)){
      //Insertar en la tabla servicio de paseo
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, mailusuario) VALUES(:nombre, :precio, :mailusuario)");
      $sentencia->bindParam(':nombre', $alojamiento);
      $sentencia->bindParam(':precio', $precioalojamiento);
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->execute();
    }else if($rowAlojamiento && isset($alojamiento)){
      //Cambiar información del servicio alojamiento
      $sql = "UPDATE servicio SET precio=? WHERE mailusuario=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$precioalojamiento,$mailActual,$alojamiento]);
    }else{
      //Cambiar información del servicio día entero
      $sql = "UPDATE servicio SET precio=? WHERE mailusuario=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$precioalojamiento,$mailActual,$alojamiento]);
    }

    if(!$rowDiaEntero && isset($diaentero)){
      //Insertar en la tabla servicio de día entero
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, mailusuario) VALUES(:nombre, :precio, :mailusuario)");
      $sentencia->bindParam(':nombre', $diaentero);
      $sentencia->bindParam(':precio', $preciodiaentero);
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio día entero
      $sql = "UPDATE servicio SET precio=? WHERE mailusuario=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciodiaentero,$mailActual,$diaentero]);
    }
    if(!$rowPaseo && isset($paseo)){
      //Insertar en la tabla servicio de paseo
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, mailusuario) VALUES(:nombre, :precio, :mailusuario)");
      $sentencia->bindParam(':nombre', $paseo);
      $sentencia->bindParam(':precio', $preciopaseo);
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio paseo
      $sql = "UPDATE servicio SET precio=? WHERE mailusuario=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciopaseo,$mailActual,$paseo]);
    }
    if(!$rowVisita && isset($visita)){
      //Insertar en la tabla servicio de visita
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, mailusuario) VALUES(:nombre, :precio, :mailusuario)");
      $sentencia->bindParam(':nombre', $visita);
      $sentencia->bindParam(':precio', $preciovisita);
      $sentencia->bindParam(':mailusuario', $mailActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio visita
      $sql = "UPDATE servicio SET precio=? WHERE mailusuario=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciovisita,$mailActual,$visita]);
    }

    //Cambiar información usuario
    $sql = "UPDATE usuario SET descripcion=?  WHERE mailusuario=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$descripcion,$mailActual]);

    //Cambiar información cuidador
    $sql = "UPDATE duenocuidador SET escuidador=?, pequeno=?, mediano=?, grande=?, perro=?, gato=?, exotico=?, otros=?, experiencia=?  WHERE mailusuario=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$escuidador,$pequeño,$mediano,$grande,$perro,$gato,$exotico,$otro,$experiencia,$mailActual]);

    header('Location: editarDuenoCuidador.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
