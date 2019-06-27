<?php
  try{
    $correoServicio = $row1['mailusuario'];

    //Tomar todos los datos de todos los animales en adopcion del usuario
    $sentencia = $conn->prepare("SELECT * FROM animal WHERE mailusuario=:mailusuario ORDER BY fecha ASC");
    $sentencia->bindParam(':mailusuario', $correoServicio);
    $sentencia->execute();
    $animales = $sentencia->fetchAll(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  if(count($animales) > 0){
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
                      echo '<img src="'.$animal['foto'].'" class="imagen-perfil" height="160" width="180">';
                      echo '<br>';
                    }else{
                      echo '<img src="http://via.placeholder.com/300x180" class="imagen-perfil" width="160" height="180">';
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
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <div id="card-footer-horizontal" class="card-footer">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                    <br>
                    <small style="color: #ffffff;"> <?php echo $animal['fecha']; ?> </small>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <button class="btn btn-default" onclick="enviarSolicitudAdopcion(<?php echo $animal['id']; ?>, <?php echo $animal['nombre']; ?>, <?php echo $animal['raza']; ?>, <?php echo $animal['sexo']; ?>, <?php echo $animal['foto']; ?>, <?php echo $row1['mailusuario']; ?>)"><i class="fas fa-bone"></i> ¡Adóptame!</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    <?php
    }
  }else{ ?>
    <br>
    <br>
    <br>
    <h4>El tablón de adopciones esta vacío</h4>
    <br>
  <?php } ?>
