<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $id = $_GET['id'];

    //Borrar mensaje seleccionado
    $sentencia = $conn->prepare("DELETE FROM mensaje WHERE mailreceptor=:mailusuario and id=:id");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    header('Location: tablonMensajes.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
