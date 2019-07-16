<?php
  require_once '../../validaciones/verificarProtectora.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    //Tomar todos los datos de todos los animales del usuario para utilizarlos de forma dinámica
    require_once '../perfil/datosAnimales.php';
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
  echo '<button style="width: 175px; margin-left: 15px;" onclick="redireccionarAñadirAnimal()" class="btn btn-default"><i class="fas fa-plus-circle"></i> Añadir Animal</button>';
  foreach($animales as $animal){
    echo '<div id="'.$animal['id'].'" class="container-fluid animal-en-adopcion">
      <div class="row">
        <div class="col-12 mt-3">
          <div id="card-horizontal" class="card">
            <div class="card-horizontal scroll-card-horizontal">
              <div id="card-body-horizontal" class="card-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">';
                  if($animal['foto']){
                    echo '<img src="'.$animal['foto'].'"  class="imagen-de-perfi" height="160" width="180">';
                    echo '<br>';
                  }else{
                    echo '<img src="http://via.placeholder.com/300x180"  class="imagen-de-perfi" width="160" height="180">';
                  }
                  echo '</div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <h3 class="card-title">'.$animal['nombre'].'</h3>
                    <label for="edad"> Edad : </label> '.$animal['edad'].' Años
                    <br>
                    <label for="descripcion"> Descripción : </label>
                    <br>
                     '.$animal['descripcion'].'
                    <br>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                      <br>
                      <label for="raza"> Raza : </label> '.$animal['raza'].'
                      <br>
                      <label for="sexo"> Sexo : </label> '.$animal['sexo'].'
                      <br>
                      <label for="peso"> Peso : </label> '.$animal['peso'].' Kg
                      <br>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">';
                    echo '<br>';
                    if($animal['amigable'] == 0){
                      echo '<label for="amigable">Amigable</label>  <i style="color: #FE0000;" class="fas fa-times-circle"></i>';
                      echo '<br>';
                    }else{
                      echo ' <label for="amigable">Amigable</label>  <i style="color: #317F43;" class="fas fa-check-circle"></i>';
                      echo '<br>';
                    }
                    if($animal['esterilizado'] == 0){
                      echo '<label for="esterilizado">Esterilizado</label> <i style="color: #FE0000;"class="fas fa-times-circle"></i>';
                      echo '<br>';
                    }else{
                      echo '<label for="esterilizado">Esterilizado</label>  <i style="color: #317F43;" class="fas fa-check-circle"></i>';
                      echo '<br>';
                    }
                    if($animal['vacunado'] == 0){
                      echo '<label for="vacunado">Vacunado</label> </label> <i  style="color: #FE0000;"class="fas fa-times-circle"></i>';
                      echo '<br>';
                    }else{
                      echo '<label for="vacunado">Vacunado</label> </label> <i style="color: #317F43;" class="fas fa-check-circle"></i>';
                      echo '<br>';
                    }
                    if($animal['desparasitado'] == 0){
                      echo '<label for="desparasitado">Desparasitado</label>  <i  style="color: #FE0000;"class="fas fa-times-circle"></i>';
                      echo '<br>';
                    }else{
                      echo '<label for="desparasitado">Desparasitado</label>  <i style="color: #317F43;" class="fas fa-check-circle"></i>';
                      echo '<br>';
                    }
                  echo '</div>
                </div>
              </div>
            </div>
            <div id="card-footer-horizontal" class="card-footer">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                  <small style="color: #ffffff;"> '.$animal['fecha'].'</small>&nbsp;&nbsp;&nbsp;&nbsp;<a id="'.$animal['id'].'" class="borrarAnimal" style="cursor:pointer"><i class="fas fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="'.$animal['id'].'" class="editarAnimal" style="cursor:pointer"><i class="fas fa-edit"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>';
  }
?>
