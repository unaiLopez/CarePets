<?php
  require_once '../../validaciones/verificarClinica.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/mensajesRecibidosNoLeidos.php';
    //Tomar los datos del usuario para utilizarlos de forma dinámica
    require_once '../datosUsuario.php';
    //Tomar los datos de la clinica para utilizarlos de forma dinámica
    require_once '../datosClinica.php';
    //Obtener el rating del datosUsuario
    require_once 'obtenerRating.php';
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
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/starRating.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
                if($row1['foto']){
                  echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="../editar/editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="../mensajeria/tablonMensajesClinica.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos; ?></span></a></li>
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
        <div id="body">
          <div class="container-fluid">
            <div class="row">
              <div class="card">
                <div class="card-header">
                  <h2>Mi Perfil</h2>
                </div>
                <div class="col-xs-12 col-lg-12 scroll">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xs-12 col-lg-3">
                        <div class="container">
                          <br>
                          <?php
                            if($row1['foto']){
                              echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="240" width="200">';
                            }else{
                              echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-perfil" height="240" width="200">';
                            }
                           ?>
                        </div>
                      </div>
                      <div class="col-xs-12 col-lg-3">
                        <div class="container">
                          <br>
                          <h3>¡Bienvenido!</h3>
                          <br>
                          <h5>Reputación como clínica :</h5>
                          <x-star-rating value="<?=$mediaMostrar?>" number="5"></x-star-rating>
                          <label for="cantidadValoraciones">Con <?php echo $cantidadValoraciones;?> valoraciones</label>
                          <script src="../../js/showStars.js"></script>
                        </div>
                      </div>
                      <div class="col-xs-12 col-lg-3">
                        <div class="container">
                          <?php
                          if($rowClinica['especialidad']) {
                            echo '<br>';
                            echo '<label for="especialidad">Especialidad :</label>';
                            echo '<br>';
                            echo $rowClinica['especialidad'];
                            echo '<br>';
                          }
                          echo '<br>';
                          if($rowClinica['especialidad']) {
                            echo '<label for="horario">Horario de Apertura :</label>';
                            echo '<br>';
                            echo $rowClinica['horario'];
                          }
                          ?>
                          <br>
                        </div>
                      </div>
                      <div class="col-xs-12 col-lg-3">
                        <div class="container">
                          <br>
                          <label for="fijo">Teléfono Fijo :</label>
                          <br>
                          <?php echo $rowClinica['telefonofijo']; ?>
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
    <script type="text/javascript">
      $('#Estrellas').starrr({
        rating: 5,
        change:function(e, valor){
          alert(valor);
        }
      });
    </script>
  </body>
</html>
