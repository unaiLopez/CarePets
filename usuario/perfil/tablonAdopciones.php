<?php
  require_once '../../validaciones/verificarProtectora.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/mensajesRecibidosNoLeidos.php';
    //Cuenta la cantidad de solicitudes no leidas para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/solicitudesRecibidasNoLeidas.php';
    //Tomar los datos del usuario para utilizarlos de forma dinámica
    require_once '../datosUsuario.php';
    //Tomar los datos de la clinica para utilizarlos de forma dinámica
    require_once '../datosProtectora.php';
    //Tomar todos los datos de todos los animales del usuario para utilizarlos de forma dinámica
    require_once 'datosAnimales.php';
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
$conn = null;
 ?>

<!DOCTYPE html>

<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CarePets</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPanelesHorizontales.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <script src="../../js/validar.js"></script>
    <script src="../../js/funcionesAnimales.js"></script>
  </head>
  <body>
    <div id="container">
      <!-- Navegación -->
      <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../perfil/perfilProtectora.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
          <div class="dropdown">
            <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">
              <?php
                if($row1['foto']){
                  echo '<img src="'.$row1['foto'].'"  class="imagen-de-perfi" height="70" width="70">';
                }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilProtectora.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="../editar/editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos+$notificacionesSolicitudes; ?></span></a></li>
                <hr>
                <li><a href="#"><i class="fas fa-users"></i> Foro</a></li>
                <hr>
                <li><a href="../ayuda/elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
                <hr>
                <li><a href="../salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
            </ul>
          </div>
        </div>
      </nav>
      <br>
      <div id="body">
        <div class="container-fluid">
          <div class="row">
            <div id="card-principal" class="card">
              <div id="card-header-principal" class="card-header mx-auto">
                <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                  <li class="nav-item">
                   <a class="nav-link active" id="tablonadopciones-tab" data-toggle="tab" href="#tablonadopciones" role="tab" aria-controls="tablonadopciones" aria-selected="true">Mi Tablón de Adopciones</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div id="card-body-principal" class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tablonadopciones-tab" role="tabpanel" aria-labelledby="tablonadopciones-tab">
                      <?php
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
                                          echo '<img class="card-image" src="http://via.placeholder.com/300x180" width="100%" height="100%" alt="Card image cap">';
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
                                            echo '<label for="amigable">Amigable</label>  <i class="fas fa-times-circle"></i>';
                                            echo '<br>';
                                          }else{
                                            echo ' <label for="amigable">Amigable</label>  <i class="fas fa-check-circle"></i>';
                                            echo '<br>';
                                          }
                                          if($animal['esterilizado'] == 0){
                                            echo '<label for="esterilizado">Esterilizado</label> <i class="fas fa-times-circle"></i>';
                                            echo '<br>';
                                          }else{
                                            echo '<label for="esterilizado">Esterilizado</label>  <i class="fas fa-check-circle"></i>';
                                            echo '<br>';
                                          }
                                          if($animal['vacunado'] == 0){
                                            echo '<label for="vacunado">Vacunado</label> </label> <i class="fas fa-times-circle"></i>';
                                            echo '<br>';
                                          }else{
                                            echo '<label for="vacunado">Vacunado</label> </label> <i class="fas fa-check-circle"></i>';
                                            echo '<br>';
                                          }
                                          if($animal['desparasitado'] == 0){
                                            echo '<label for="desparasitado">Desparasitado</label>  <i class="fas fa-times-circle"></i>';
                                            echo '<br>';
                                          }else{
                                            echo '<label for="desparasitado">Desparasitado</label>  <i class="fas fa-check-circle"></i>';
                                            echo '<br>';
                                          }
                                        echo '</div>
                                      </div>
                                    </div>
                                  </div>
                                  <div id="card-footer-horizontal" class="card-footer">
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                        <a id="borrar"><i class="fas fa-trash"></i></a><small style="color: #ffffff;"> '.$animal['fecha'].'</small>
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
                    </div>
                    <button class="btn btn-default" onclick="location.href='perfilProtectora.php';"><i class="fas fa-user"></i> Volver al Perfil</button>
                    <br>
                    <br>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <!-- Footer -->
          <div class="footer">
            <div class="container-fluid padding">
              <div class="row text-center padding">
                <div class="col-lg-12 social padding">
                  <a href="https://www.facebook.com/unai.lopez5851"><i class="fab fa-facebook-square"></i></a>
                  <a href="https://www.instagram.com/carepets1/"><i class="fab fa-instagram"></i></a>
                  <a href="https://twitter.com/cuidacarepets"><i class="fab fa-twitter"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
