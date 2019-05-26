<?php
  require_once '../../validaciones/verificarProtectora.php';

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];

    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $row2 = $sentencia->fetch(PDO::FETCH_BOTH);

    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/mensajesRecibidosNoLeidos.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/solicitudesRecibidasNoLeidas.php';

    require_once '../datosUsuario.php';

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTC035_2c7HqTdiIGYdAYtJCLI0ye4coc&libraries=places&callback=autocompletarEditar" async defer></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPanelesHorizontales.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <script src="../../js/validar.js"></script>
    <script src="../../js/googleMaps.js"></script>
    <script src="../../js/mostrarInformacionDinamica.js"></script>
    <script src="../../js/funcionesAnimalesAdopcion.js"></script>
    <script src="../../js/pestañasConURL.js"></script>
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
                  echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilProtectora.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos+$notificacionesSolicitudes; ?></span></a></li>
                <hr>
                <li><a href="#"><i class="fas fa-users"></i> Foro</a></li>
                <hr>
                <li><a href="#"><i class="fas fa-question"></i> Ayuda</a></li>
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
                  <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                     <a class="nav-link active" id="contraseña-tab" data-toggle="tab" href="#contraseña" role="tab" aria-controls="contraseña" aria-selected="true"><i class="fas fa-key"></i> Cambiar Contraseña</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-12 scroll">
                  <div id="card-body-principal" class="card-body mx-auto">
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="contraseña" role="tabpanel" aria-labelledby="contraseña-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-12 mx-auto">
                              <h1><strong>Nombre del animal</strong></h1>
                              <form id="formularioCambiarContraseña" action="cambiarContraseña.php" method="post" onsubmit="return validarContraseñaActual($('#passActual').val()) && validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val())">
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="passActual" name="passActual" minlength="6" class="form-control" placeholder="Su contraseña actual" onkeyup="validarContraseñaActual($('#passActual').val());" required>
                                    </div>
                                    <div id="validacionContraseñaActual"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="passNueva" name="passNueva" minlength="6" class="form-control" placeholder="Su nueva contraseña" onkeyup="validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val());" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="confirmarPassNueva" name="confirmarPassNueva" minlength="6" class="form-control" placeholder="Confirme su nueva contraseña" onkeyup="validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val());" required>
                                    </div>
                                    <div id="compararContraseñas"></div>
                                </div>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                                <br>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
                  <a href="www.facebook.com"><i class="fab fa-facebook-square"></i></a>
                  <a href="www.instagram.com"><i class="fab fa-instagram"></i></a>
                  <a href="www.twitter.com"><i class="fab fa-twitter"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
  </html>
