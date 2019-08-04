<?php
  require_once '../../validaciones/verificarClinica.php';

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $row2 = $sentencia->fetch(PDO::FETCH_BOTH);

    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/notificacionesMensajeriaRecibidosMensajes.php';

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
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <script src="../../js/validar.js"></script>
    <script src="../../js/googleMaps.js"></script>
    <script src="../../js/pestañasConURL.js"></script>
  </head>
  <body>
    <div id="container">
      <!-- Navegación -->
      <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../perfil/perfilClinica.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
          <div class="dropdown">
            <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">
              <?php
                if($row1['foto']){?>
                  <img src="<?php echo $row1['foto']; ?>" class="imagen-de-perfil" height="70" width="70">
         <?php   }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-de-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesClinica.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes; ?></span></a></li>
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
              <div class="card">
                <div class="card-header mx-auto">
                  <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                    <li class="nav-item">
                     <a class="nav-link active" id="contraseña-tab" data-toggle="tab" href="#contraseña" role="tab" aria-controls="contraseña" aria-selected="true"><i class="fas fa-key"></i> Cambiar Contraseña</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#obligatoria" role="tab" aria-controls="obligatoria" aria-selected="false"><i class="fas fa-info-circle"></i> Información Obligatoria</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#opcional" role="tab" aria-controls="opcional" aria-selected="false"><i class="fas fa-info"></i> Información Opcional</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-12 scroll">
                  <div style="height: 350px;" class="card-body mx-auto">
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="contraseña" role="tabpanel" aria-labelledby="contraseña-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 mx-auto">
                              <h1><strong>Contraseña</strong></h1>
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
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default block"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="obligatoria" role="tabpanel" aria-labelledby="obligatoria-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 mx-auto">
                              <h1><strong>Obligatoria</strong></h1>
                              <form name="formularioCambiarInfoObligatoria" id="formularioCambiarInfoObligatoria" action="cambiarObligatoriaClinica.php" method="post" onsubmit="return compararTelefonos($('#movil').val(), $('#fijo').val()) && validarCorreoEditar($('#mail').val()) && validarTelefonoFijoEditar($('#fijo').val()) && validarTelefonoMovilEditar($('#movil').val())">
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-user"></i>
                                      </div>
                                      <input type="text" id="nombre" name="nombre" maxlength="50" class="form-control" value="<?=$row1['nombre']; ?>" placeholder="Su nombre" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-at"></i>
                                      </div>
                                      <input type="email" id="mail" name="mail" class="form-control" value="<?=$row1['mailusuario']; ?>" placeholder="Ejemplo: usuario@gmail.com" size="50" onkeyup="validarCorreoEditar($('#mail').val());">
                                    </div>
                                    <div id="autenticacionCorreo"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-mobile-alt"></i>
                                        +34
                                      </div>
                                      <input type="number" id="movil" name="movil" class="form-control" value="<?=$row1['telefonomovil']; ?>" placeholder="Ejemplo: 690154921" size="9" onkeyup="validarTelefonoMovilEditar($('#movil').val()) && compararTelefonos($('#movil').val(), $('#fijo').val())">
                                    </div>
                                    <div id="telefonoMovil"></div>
                                    <div id="compararTelefonos"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-mobile-alt"></i>
                                      </div>
                                      <input type="number" id="fijo" name="fijo" class="form-control" value="<?=$row2['telefonofijo']; ?>" placeholder="Ejemplo: 948012761" size="9" onkeyup="validarTelefonoFijoEditar($('#fijo').val()) && compararTelefonos($('#movil').val(), $('#fijo').val())">
                                    </div>
                                    <div id="telefonoFijo"></div>
                                    <div id="compararTelefonos"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-map-marker-alt"></i>
                                      </div>
                                      <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Ingrese su dirección" value="<?=$row1['direccion']; ?>">
                                      <input type="hidden" name="direccion" id="direccion" value="<?=$row1['direccion'];?>">
                                      <input type="hidden" name="latitud" id="latitud" value="<?=$row1['latitud'];?>">
                                      <input type="hidden" name="longitud" id="longitud" value="<?=$row1['longitud'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default block"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                                <br>
                              </form>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="opcional" role="tabpanel" aria-labelledby="opcional-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 mx-auto">
                              <h1><strong>Opcional</strong></h1>
                              <form id="formularioCambiarInfoOpcional" action="cambiarOpcionalClinica.php" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                  <label for="experiencia">Experiencia</label>
                                  <div class="input-group">
                                    <input type="number" id="experiencia" name="experiencia" class="form-control" value="<?=$row2['experiencia']; ?>" placeholder="Años de experiencia">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="experiencia">Especialidad</label>
                                  <div class="input-group">
                                    <input type="text" id="especialidad" name="especialidad" class="form-control" value="<?=$row2['especialidad']; ?>" placeholder="Especialidad de su clínica">
                                  </div>
                                </div>
                                <div class="form-group">
  																<label for="horario">Horario</label>
  																<textarea class="form-control" col="6" rows="3" id="horario" name="horario"><?php echo $row2['horario']; ?></textarea>
  															</div>
                                <div class="form-group">
  																<label for="descripcion">Descripción</label>
  																<textarea class="form-control" col="6" rows="3" id="descripcion" name="descripcion"><?php echo $row1['descripcion']; ?></textarea>
  															</div>
                                <div class="form-group">
                                  <label for="avatar">Foto de Perfil</label>
                                  <input type="file" id="avatar" name="avatar">
                                </div>
                                  <?php
                                    if($row1['foto'])
                                      echo '<img src="'.$row1['foto'].'" width="100" height="100" style="border: solid 2px #ffffff; border-radius: 10px;">';
                                  ?>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default block"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
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
              <a href="https://www.facebook.com/unai.lopez5851"><i class="fab fa-facebook-square"></i></a>
              <a href="https://www.instagram.com/carepets1/"><i class="fab fa-instagram"></i></a>
              <a href="https://twitter.com/cuidacarepets"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
