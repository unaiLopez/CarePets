<?php
  $idUsuarioServicio = $_SESSION['idUsuarioServicio'];

  //Tomar la media de las valoraciones al usuario
  $sentencia = $conn->prepare("SELECT AVG(puntuacion) AS averageRating FROM valoracion WHERE user_id_valorado=:user_id");
  $sentencia->bindParam(':user_id', $idUsuarioServicio);
  $sentencia->execute();
  $rating = $sentencia->fetch(PDO::FETCH_BOTH);

  $media = $rating['averageRating'];

  $mediaMostrar = round($media, 0, PHP_ROUND_HALF_UP);

  //Tomar la cantidad de veces que ha sido valorado el usuario
  $sentencia = $conn->prepare("SELECT * FROM valoracion WHERE user_id_valorado=:user_id");
  $sentencia->bindParam(':user_id', $idUsuarioServicio);
  $sentencia->execute();
  $valoraciones = $sentencia->fetchAll(PDO::FETCH_BOTH);
  $cantidadValoraciones = count($valoraciones);

?>
