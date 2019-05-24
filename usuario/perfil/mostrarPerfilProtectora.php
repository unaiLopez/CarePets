<?php
require_once '../../validaciones/verificarProtectora.php';
try {
  require_once '../conectarDB.php';
  $conn = conectarse();
  require_once '../datosUsuario.php';
  //Tomar los datos de la clinica para utilizarlos de forma dinámica
  require_once '../datosProtectora.php';
  //Obtener el rating del datosUsuario
  require_once 'obtenerRating.php';
}catch(PDOException $e){
  echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="container">
      <br>
      <?php
        if($row1['foto']){
          echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="240" width="200">';
        }else{
          echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="240" width="200">';
        }
       ?>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="container">
      <br>
      <h3>¡Bienvenido!</h3>
      <br>
      <h5>Reputación como protectora :</h5>
      <x-star-rating value="<?=$mediaMostrar?>" number="5"></x-star-rating>
      <br>
      <label for="cantidadValoraciones">Con <?php echo $cantidadValoraciones;?> valoraciones</label>
      <br>
      <script src="../../js/showStars.js"></script>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="container">
      <?php
      if($rowProtectora['horario']) {
        echo '<br>';
        echo '<label for="horario">Horario de Apertura :</label>';
        echo '<br>';
        echo $rowProtectora['horario'];
      }
      if($row1['descripcion']) {
        echo '<br>';
        echo '<br>';
        echo '<label for="descripcion">Descripcion :</label>';
        echo '<br>';
        echo $row1['descripcion'];
      }
      if($row1['direccion']) {
        echo '<br>';
        echo '<br>';
        echo '<label for="direccion">Direccion :</label>';
        echo '<br>';
        echo $row1['direccion'];
      }
      ?>
      <br>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="container">
      <br>
      <label for="fijo">Teléfono Fijo :</label>
      <br>
      <?php echo $rowProtectora['telefonofijo']; ?>
      <br>
      <br>
      <label for="movil">Teléfono Móvil :</label>
      <br>
      <?php echo $row1['telefonomovil']; ?>
      <br>
      <br>
      <label for="correo">Correo Electrónico :</label>
      <br>
      <?php echo $row1['mailusuario']; ?>
      <br>
      <br>
    </div>
  </div>
</div>
