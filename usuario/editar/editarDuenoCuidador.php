<?php
  include '../../validaciones/verificarDuenoCuidador.php';

  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $correo = $_SESSION['mail'];
    $servicio1 = 'Alojamiento';
    $servicio2 = 'Dia Entero';
    $servicio3 = 'Paseo';
    $servicio4 = 'Visita';

    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

    $sentencia = $conn->prepare("SELECT * FROM duenocuidador WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $row2 = $sentencia->fetch(PDO::FETCH_BOTH);

    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->bindParam(':nombre', $servicio1);
    $sentencia->execute();
    $row31 = $sentencia->fetch(PDO::FETCH_BOTH);

    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->bindParam(':nombre', $servicio2);
    $sentencia->execute();
    $row32 = $sentencia->fetch(PDO::FETCH_BOTH);

    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->bindParam(':nombre', $servicio3);
    $sentencia->execute();
    $row33 = $sentencia->fetch(PDO::FETCH_BOTH);

    $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario and nombre=:nombre");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->bindParam(':nombre', $servicio4);
    $sentencia->execute();
    $row34 = $sentencia->fetch(PDO::FETCH_BOTH);

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
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <script src="../../js/validar.js"></script>
  </head>
  <body>
    <div id="container">
      <!-- Navegación -->
      <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../perfilDuenoCuidador.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
          <div class="dropdown">
            <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">
              <?php
                if($row1['foto']){
                  echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilDuenoCuidador.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="editarDuenoCuidador.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesSolicitud.php"><i class="fas fa-envelope"></i> Mensajes</a></li>
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
              <div class="card">
                <div class="card-header mx-auto">
                  <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                    <li class="nav-item">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#contraseña" role="tab" aria-controls="contraseña" aria-selected="true">Cambiar Contraseña</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#obligatoria" role="tab" aria-controls="obligatoria" aria-selected="false">Información Obligatoria</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#opcional" role="tab" aria-controls="opcional" aria-selected="false">Información Opcional</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#cuidador" role="tab" aria-controls="cuidador" aria-selected="false">Información Cuidador</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-12 scroll">
                  <div class="card-body mx-auto">
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="contraseña" role="tabpanel" aria-labelledby="contraseña-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-12 mx-auto">
                              <h1><strong>Contraseña</strong></h1>
                              <form id="formularioCambiarContraseña" action="cambiarContraseña.php" method="post" onsubmit="return validarContraseñaActual($('#passActual').val()) && validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val())">
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="passActual" name="passActual" minlength="6" class="form-control" placeholder="Su contraseña actual" onchange="validarContraseñaActual($('#passActual').val());" required>
                                    </div>
                                    <div id="validacionContraseñaActual"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="passNueva" name="passNueva" minlength="6" class="form-control" placeholder="Su nueva contraseña" onchange="validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val());" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-eye-slash"></i>
                                      </div>
                                      <input type="password" id="confirmarPassNueva" name="confirmarPassNueva" minlength="6" class="form-control" placeholder="Confirme su nueva contraseña" onchange="validarContraseña($('#passNueva').val(), $('#confirmarPassNueva').val());" required>
                                    </div>
                                    <div id="compararContraseñas"></div>
                                </div>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="obligatoria" role="tabpanel" aria-labelledby="obligatoria-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-12 mx-auto">
                              <h1><strong>Obligatoria</strong></h1>
                              <form id="formularioCambiarInfoObligatoria" action="cambiarObligatoriaDuenoCuidador.php" method="post" onsubmit="return validarCorreoEditar($('#mail').val()) && validarTelefonoMovilEditar($('#movil').val())">
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
                                      <input type="email" id="mail" name="mail" class="form-control" value="<?=$row1['mailusuario']; ?>" placeholder="Ejemplo: usuario@gmail.com" size="50" onchange="validarCorreoEditar($('#mail').val());">
                                    </div>
                                    <div id="autenticacionCorreo"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-mobile-alt"></i>
                                        +34
                                      </div>
                                      <input type="number" id="movil" name="movil" class="form-control" value="<?=$row1['telefonomovil']; ?>" placeholder="Ejemplo: 690154921" size="9" onchange="validarTelefonoMovilEditar($('#movil').val());">
                                    </div>
                                    <div id="telefonoMovil"></div>
                                </div>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                                </div>
                              </form>
                            </div>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="opcional" role="tabpanel" aria-labelledby="opcional-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <div class="col-xs-12 mx-auto">
                              <h1><strong>Opcional</strong></h1>
                              <form id="formularioCambiarInfoOpcional" action="cambiarOpcionalDuenoCuidador.php" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-user"></i>
                                      </div>
                                      <input type="text" id="apellido1" name="apellido1" class="form-control" value="<?=$row2['apellido1']; ?>" placeholder="Su primer apellido" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fas fa-user"></i>
                                      </div>
                                      <input type="text" id="apellido2" name="apellido2" class="form-control" value="<?=$row2['apellido2']; ?>" placeholder="Su segundo apellido" size="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label for="Sexo">Sexo</label>
                                  <div class="input-group">
                                    <div class="radio">
                                      <label><input type="radio" id="sexo" name="sexo" value="Masculino" <?php echo ($row2['sexo']=='Masculino') ?  "checked" : "" ;  ?>> Masculino &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="radio">
                                      <label><input type="radio" id="sexo" name="sexo" value="Femenino" <?php echo ($row2['sexo']=='Femenino') ?  "checked" : "" ;  ?>> Femenino &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="radio">
                                      <label><input type="radio" id="sexo" name="sexo" value="Otro" <?php echo ($row2['sexo']=='Otro') ?  "checked" : "" ;  ?>> Otro</label>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="form-group">
                                  <label for="fechaNacimiento">Fecha de Nacimiento</label>
                                  <div class="input-group">
                                    <div class="input-group-addon">
                                      <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <input type="date" id="calendario" name="calendario" class="form-control" value="<?=$row2['fechanacimiento']; ?>">
                                  </div>
                                </div>
                                <br>
                                <div class="form-group">
                                  <label for="avatar">Foto de Perfil</label>
                                  <input type="file" id="avatar" name="avatar">
                                </div>
                                <br>
                                  <?php
                                    if($row1['foto'])
                                      echo '<img src="'.$row1['foto'].'" width="100" height="100" style="border: solid 2px #ffffff; border-radius: 10px;">';
                                  ?>
                                <br>
                                <div class="form-group">
                                  <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                </div>
                              </form>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="cuidador" role="tabpanel" aria-labelledby="cuidador-tab">
                      <div class="container-fluid padding">
                        <div class="row">
                          <div class="col-xs-12 mx-auto">
                            <h1><strong>Cuidador</strong></h1>
                            <form id="formularioInformacionCuidador" action="cambiarInformacionCuidador.php" method="post" onsubmit="return validarCorreoEditar($('#mail').val()) && validarTelefonoMovilEditar($('#movil').val()) && validarPrecios()">
                              <?php
                                if($row2['escuidador']==0)
                                  echo '<div class="form-group"><h5 style="color: red;">Aún no eres cuidador hazte cuidador rellenando este formulario.</h5></div>'
                              ?>
                              <div class="form-group">
                                <label for="tipos">¿Qué tipos de animales puede cuidar?</label>
                                <div class="input-group">
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="perros" name="perros" value="1" <?php echo ($row2['perro']==1) ?  "checked" : "" ;  ?>> Perros &nbsp;&nbsp;</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="gatos" name="gatos" value="1" <?php echo ($row2['gato']==1) ?  "checked" : "" ;  ?>> Gatos &nbsp;&nbsp;</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="exoticos" name="exoticos" value="1" <?php echo ($row2['exotico']==1) ?  "checked" : "" ;  ?>> Exóticos &nbsp;&nbsp;</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="otros" name="otros" value="1" <?php echo ($row2['otros']==1) ?  "checked" : "" ;  ?>> Otros</label>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="form-group">
                                <label for="tipos">¿De qué tamaños?</label>
                                <div class="input-group">
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="pequeno" name="pequeno" value="1" <?php echo ($row2['pequeno']==1) ?  "checked" : "" ;  ?>> <span>Pequeños 1 - 5 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="20" with="20"></span></label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="mediano" name="mediano" value="1" <?php echo ($row2['mediano']==1) ?  "checked" : "" ;  ?>> <span>Medianos 5 - 15 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="25" with="25"></span></label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" id="grande" name="grande" value="1" <?php echo ($row2['grande']==1) ?  "checked" : "" ;  ?>> <span>Grandes 15 - 50 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="35" with="35"></span></label>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <br>
                              <br>
                              <br>
                              <div class="form-group">
                                <label for="experiencia">Experiencia :</label>
                                <div class="input-group">
                                  <input type="number" id="experiencia" name="experiencia" class="form-control" value="<?=$row2['experiencia']; ?>" placeholder="Años de experiencia">
                                </div>
                              </div>
                              <br>
                              <div class="form-group">
                                <label for="experiencia">Descripcion</label>
                                <div class="input-group">
                                  <input type="text" id="descripcion" name="descripcion" class="form-control" value="<?=$row1['descripcion']; ?>" placeholder="Descripcion de sus habilidades">
                                </div>
                              </div>
                              <br>
                              <br>
                              <div class="form-group">
                                <div class="input-group">
                                  <label for="tipos">¿Qué servicios quieres ofrecer?</label>
                                </div>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fas fa-home"></i>
                                    <strong>€</strong>
                                  </div>
                                  <input type="number" id="precioAlojamiento" name="precioAlojamiento" class="form-control" value="<?=$row31['precio'];?>" placeholder="Precio por alojamiento">
                                </div>
                                <br>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fas fa-cloud-sun"></i>
                                    <strong>€</strong>
                                  </div>
                                  <input type="number" id="preciodiaentero" name="preciodiaentero" class="form-control" value="<?=$row32['precio'];?>" placeholder="Precio por cuidado de día entero">
                                </div>
                                <br>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fas fa-walking"></i>
                                    <strong>€</strong>
                                  </div>
                                  <input type="number" id="preciopaseo" name="preciopaseo" class="form-control" value="<?=$row33['precio'];?>" placeholder="Precio por paseo">
                                </div>
                                <br>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fas fa-handshake"></i>
                                    <strong>€</strong>
                                  </div>
                                  <input type="number" id="preciovisita" name="preciovisita" class="form-control" value="<?=$row34['precio'];?>" placeholder="Precio por visita">
                                </div>
                              </div>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <div class="form-group">
                                  <?php
                                    if($row2['escuidador'] == 0){
                                      echo '<div class="form-group"><button type="submit" id="haztecuidador" name="haztecuidador" class="btn btn-default"><i class="fas fa-paw"></i> Hazte Cuidador</button></div>';
                                    }else{
                                      echo '<div class="form-group"><button type="submit" id="confirmarcambios" name="confirmarcambios" class="btn btn-default"><i class="fas fa-check-circle"></i> Confirmar Cambios</button></div>';
                                    }
                                  ?>
                                  <br>
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
              <a href="www.facebook.com"><i class="fab fa-facebook-square"></i></a>
              <a href="www.instagram.com"><i class="fab fa-instagram"></i></a>
              <a href="www.twitter.com"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
  </div>
  </body>
</html>
