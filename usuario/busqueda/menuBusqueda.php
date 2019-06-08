<?php
  require_once '../../validaciones/verificarDuenoCuidador.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/mensajesRecibidosNoLeidos.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/solicitudesRecibidasNoLeidas.php';
    //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/mensajesEnviadosNoLeidos.php';
    //Tomar los datos del usuario para utilizarlos de forma dinámica
    require_once '../datosUsuario.php';
    //Tomar los datos de la clinica para utilizarlos de forma dinámica
    require_once '../datosDuenoCuidador.php';

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/bootstrap-datepicker.css"/>
    <script src="../../js/funcionesBusqueda.js"></script>
    <script src="../../js/bootstrap-datepicker.js"></script>
    <script src="../../js/validar.js"></script>
  </head>
  <body onload="mostrarInicio()">
    <div id="container">
      <!-- Navegación -->
      <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../perfil/perfilDuenoCuidador.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
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
                <li><a href="../editar/editarDuenoCuidador.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos+$notificacionesSolicitudes+$notificacionesEnviados; ?></span></a></li>
                <hr>
                <li><a href="../busqueda/menuBusqueda.php"><i class="fas fa-search"></i> Búsqueda</a></li>
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
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                   <a class="nav-link active" id="buscarservicios-tab" data-toggle="tab" href="#buscarservicios" role="tab" aria-controls="buscarservicios" aria-selected="true"><i class="fas fa-search-location"></i> Buscar Servicios</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="buscarservicios-tab" role="tabpanel" aria-labelledby="buscarservicios-tab">
                      <form action="buscarMapa.php" method="post" onsubmit="return validarMenuBusqueda($('#buscarTipo').val(), $('#elegirServicio').val(), $('#date1').val(), $('#date2').val(), $('#date3').val())">
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <h3>Busco</h3>
                              <select class="form-control" id="buscarTipo" name="buscarTipo" onchange="cambiarInterfaces()">
                                <option>Cuidador</option>
                                <option>Clinica Veterinaria</option>
                                <option>Protectora de Animales</option>
                              </select>
                            </div>
                          </div>
                          <div id="tiposServicios" class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <h3>Servicios</h3>
                              <select class="form-control" id="elegirServicio" name="elegirServicio" onchange="cambiarInterfaces()">
                                <option>Alojamiento</option>
                                <option>Cuidado de Día</option>
                                <option>Paseo</option>
                                <option>Visita a Domicilio</option>
                              </select>
                            </div>
                          </div>
                          <div id="fecha1" class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                            <div class="container">
                              <br>
                              <div class="d-none d-sm-block">
                                <h3>Desde</h3>
                              </div>
                              <div class="input-group dates">
                                <div class="input-group-addon">
                                  <i class="far fa-calendar-alt"></i>
                                </div>
                                <input type="text" class="form-control" id="date1" name="date" placeholder="Inicio" autocomplete="off">
                              </div>
                            </div>
                          </div>
                          <div id="fecha2" class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                            <div class="container">
                              <br>
                              <div class="d-none d-sm-block">
                                <h3>Hasta</h3>
                              </div>
                              <div class="input-group dates">
                                <div class="input-group-addon">
                                  <i class="far fa-calendar-alt"></i>
                                </div>
                                <input type="text" class="form-control" id="date2" name="date" placeholder="Final" autocomplete="off">
                              </div>
                            </div>
                          </div>
                          <div id="fecha3" class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                            <div class="container">
                              <br>
                              <div class="d-none d-sm-block">
                                <h3>Día</h3>
                              </div>
                              <div class="input-group dates">
                                <div class="input-group-addon">
                                  <i class="far fa-calendar-alt"></i>
                                </div>
                                <input type="text" class="form-control" id="date3" name="date" placeholder="Elija el día" autocomplete="off">
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                            <div class="container">
                              <br>
                              <br>
                              <button style="margin-top: 16px" type="submit" id="submit" name="buscar" class="btn btn-default block"><i class="fas fa-search"></i> Buscar</button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
                          <div style="margin-top:10px;text-align: center;" id="validarDatos"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div id="informacionClinicas" class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="container">
                      <br>
                      <img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" style="height:60px;width:60px;border-radius:360px;">
                      <label for="clinica"> Clinicas Veterinarias</label>
                      <p>Busca las clinicas veterinarias más cercanas y contáctalas mediante la mensajería</p>
                    </div>
                  </div>
                  <div id="informacionProtectoras" class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="container">
                      <br>
                      <img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" style="height:60px;width:60px;border-radius:360px;">
                      <label for="protectora"> Protectoras de Animales</label>
                      <p>Busca las protectoras de animales más cercanas, contáctalas mediante la mensajería o solicita adoptarles algún animal desde su tablon de animales en adopción</p>
                    </div>
                  </div>
                  <div id="informacionServicios" class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                      <div class="container">
                        <br>
                        <img src="../../iconos/miscelanea/icono_noche.png" height="40" with="40">
                        <label for="alojamiento"> Alojamiento</label>
                        <p>Deja a tu mascota alojada en la casa de tu cuidador para que la cuide las noches que necesites</p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                      <div class="container">
                        <br>
                        <img src="../../iconos/miscelanea/icono_dia.png" height="40" with="40">
                        <label for="cuidadoDia"> Cuidado de Día</label>
                        <p>Deja a tu mascota en la casa de un cuidador para que la cuide durante el día</p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                      <div class="container">
                        <br>
                        <img src="../../iconos/miscelanea/icono_paseo.png" height="40" with="40">
                        <label for="paseo"> Paseo</label>
                        <p>Un cuidador pasará a por tu mascota para darle un paseo de aproximadamente 1 hora</p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                      <div class="container">
                        <br>
                        <img src="../../iconos/miscelanea/icono_casa.png" height="40" with="40">
                        <label for="visita"> Visita a Domicilio</label>
                        <p>Un cuidador pasará por tu casa para alimentar a tu mascota y darle los cuidados necesarios durante aproximadamente 1 hora</p>
                      </div>
                    </div>
                  </div>
                  <br>
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
