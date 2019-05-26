<?php
  @ob_start();
  session_start();
  try {
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idAnimal = $_POST['id'];

    //Se elimina el animal con el id seleccionado
    $sql = "DELETE FROM animal WHERE id=?";
    $sentencia = $conn->prepare($sql);
    $sentencia->execute([$idAnimal]);
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
