<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $escuidador = 1;
    $descripcion = $_POST['descripcion'];
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
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE user_id=:user_id and nombre=:nombre");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':nombre', $alojamiento);
    $sentencia->execute();
    $rowAlojamiento = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio día entero
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE user_id=:user_id and nombre=:nombre");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':nombre', $diaentero);
    $sentencia->execute();
    $rowDiaEntero = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio paseo
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE user_id=:user_id and nombre=:nombre");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':nombre', $paseo);
    $sentencia->execute();
    $rowPaseo = $sentencia->fetch(PDO::FETCH_BOTH);

    //Buscar si ofrece servicio visita
    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE user_id=:user_id and nombre=:nombre");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':nombre', $visita);
    $sentencia->execute();
    $rowVisita = $sentencia->fetch(PDO::FETCH_BOTH);

    if(!$rowAlojamiento && isset($alojamiento)){
      //Insertar en la tabla servicio de paseo
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, user_id) VALUES(:nombre, :precio, :user_id)");
      $sentencia->bindParam(':nombre', $alojamiento);
      $sentencia->bindParam(':precio', $precioalojamiento);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();
    }else if($rowAlojamiento && isset($alojamiento)){
      //Cambiar información del servicio alojamiento
      $sql = "UPDATE servicio SET precio=? WHERE user_id=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$precioalojamiento,$idActual,$alojamiento]);
    }else{
      //Cambiar información del servicio día entero
      $sql = "UPDATE servicio SET precio=? WHERE user_id=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$precioalojamiento,$idActual,$alojamiento]);
    }

    if(!$rowDiaEntero && isset($diaentero)){
      //Insertar en la tabla servicio de día entero
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, user_id) VALUES(:nombre, :precio, :user_id)");
      $sentencia->bindParam(':nombre', $diaentero);
      $sentencia->bindParam(':precio', $preciodiaentero);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio día entero
      $sql = "UPDATE servicio SET precio=? WHERE user_id=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciodiaentero,$idActual,$diaentero]);
    }
    if(!$rowPaseo && isset($paseo)){
      //Insertar en la tabla servicio de paseo
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, user_id) VALUES(:nombre, :precio, :user_id)");
      $sentencia->bindParam(':nombre', $paseo);
      $sentencia->bindParam(':precio', $preciopaseo);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio paseo
      $sql = "UPDATE servicio SET precio=? WHERE user_id=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciopaseo,$idActual,$paseo]);
    }
    if(!$rowVisita && isset($visita)){
      //Insertar en la tabla servicio de visita
      $sentencia = $conn->prepare("INSERT INTO servicio(nombre, precio, user_id) VALUES(:nombre, :precio, :user_id)");
      $sentencia->bindParam(':nombre', $visita);
      $sentencia->bindParam(':precio', $preciovisita);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();
    }else{
      //Cambiar información del servicio visita
      $sql = "UPDATE servicio SET precio=? WHERE user_id=? and nombre=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$preciovisita,$idActual,$visita]);
    }

    //Cambiar información usuario
    $sql = "UPDATE usuario SET descripcion=? WHERE user_id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$descripcion,$idActual]);

    //Cambiar información cuidador
    $sql = "UPDATE duenocuidador SET escuidador=?, experiencia=?  WHERE user_id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$escuidador,$experiencia,$idActual]);

    header('Location: editarDuenoCuidador.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }

  $conn = null;
?>
