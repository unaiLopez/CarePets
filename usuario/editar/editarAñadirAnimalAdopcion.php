<?php
  require_once '../../validaciones/verificarProtectora.php';

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $tipoFuncion = $_GET['tipo'];

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

    if($tipoFuncion == 'Editar'){
      $id = $_GET['id'];
      //Toma todos los datos del animal para mostrarlos dinámicamente posteriormente solamente si la acción que se va a hacer es editar el animal
      require_once '../datosAnimal.php';
    }

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
                    <?php
                      if($tipoFuncion == 'Editar'){
                        echo '<li class="nav-item">
                         <a class="nav-link active" id="editaranimal-tab" data-toggle="tab" href="#editaranimal" role="tab" aria-controls="editaranimal" aria-selected="true"><i class="fas fa-key"></i> Editar Animal</a>
                        </li>';
                      }else if($tipoFuncion == 'Añadir'){
                        echo '<li class="nav-item">
                         <a class="nav-link active" id="añadiranimal-tab" data-toggle="tab" href="#añadiranimal" role="tab" aria-controls="añadiranimal" aria-selected="true"><i class="fas fa-key"></i> Añadir Animal</a>
                        </li>';
                      }
                    ?>
                  </ul>
                </div>
                <div class="col-lg-12 scroll">
                  <div id="card-body-principal" class="card-body mx-auto">
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="contraseña" role="tabpanel" aria-labelledby="contraseña-tab">
                        <div class="container-fluid padding">
                          <div class="row">
                            <?php
                              if($tipoFuncion == 'Editar'){
                            ?>
                              <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 mx-auto">
                                <h1><strong>Editar Animal</strong></h1>
                                <form id="formularioEditarAnimal" action="cambiarAnimalAdopcion.php" enctype="multipart/form-data" method="post">
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fas fa-file-signature"></i>
                                        </div>
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del animal" value="<?php echo $animal['nombre']; ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fas fa-dog"></i>
                                        </div>
                                        <input type="text" id="raza" name="raza" class="form-control" placeholder="Raza del animal" value="<?php echo $animal['raza']; ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="descripcion">Descripción :</label>
                                    <textarea class="form-control" col="6" rows="3" id="descripcion" name="descripcion"><?php echo $animal['descripcion']; ?></textarea>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <strong>Kg</strong>
                                        </div>
                                        <input type="number" id="peso" name="peso" class="form-control" placeholder="Peso del animal" value="<?php echo $animal['peso']; ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <strong>Años</strong>
                                        </div>
                                        <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad del animal" value="<?php echo $animal['edad']; ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="sexo">Sexo :</label>
                                    <div class="input-group">
                                      <div class="radio">
                                        <label><input type="radio" id="sexo" name="sexo" value="Macho" <?php echo ($animal['sexo']=='Macho') ?  "checked" : "" ; ?>  required> Macho &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                      </div>
                                      <div class="radio">
                                        <label><input type="radio" id="sexo" name="sexo" value="Hembra" <?php echo ($animal['sexo']=='Hembra') ?  "checked" : "" ; ?>  required> Hembra &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="condiciones"> Condiciones Actuales :</label>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="amigable" name="amigable" class="form-check-input" value="1" <?php echo ($animal['amigable']==1) ?  "checked" : "" ; ?>  > Amigable
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="esterilizado" name="esterilizado" class="form-check-input" value="1" <?php echo ($animal['esterilizado']==1) ?  "checked" : "" ; ?>  >Esterilizado
                                      </label>
                                    </div>
                                   <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="vacunado" name="vacunado" class="form-check-input" value="1" <?php echo ($animal['vacunado']==1) ?  "checked" : "" ; ?>  >Vacunado
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="desparasitado" name="desparasitado" class="form-check-input" value="1" <?php echo ($animal['desparasitado']==1) ?  "checked" : "" ; ?>  >Desparasitado
                                      </label>
                                   </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="avatar">Foto del Animal :</label>
                                    <input type="file" id="avatar" name="avatar">
                                  </div>
                                  <br>
                                    <?php
                                      if($animal['foto'])
                                        echo '<img src="'.$animal['foto'].'" width="100" height="100" style="border: solid 2px #ffffff; border-radius: 10px;">';
                                        echo '<br>';
                                    ?>
                                  <div class="form-group">
                                    <button type="submit" id="submit" name="confirmarcambios" class="btn btn-default block"><i class="fas fa-check-circle"></i> Confirmar Cambios</button>
                                  </div>
                                  <br>
                                </form>
                              </div>
                            <?php
                              }else if($tipoFuncion == 'Añadir'){
                            ?>
                              <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4 mx-auto">
                                <h1><strong>Añadir Animal</strong></h1>
                                <form id="formulariAñadirAnimal" action="añadirAnimalAdopcion.php" enctype="multipart/form-data" method="post">
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fas fa-file-signature"></i>
                                        </div>
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del animal" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fas fa-dog"></i>
                                        </div>
                                        <input type="text" id="raza" name="raza" class="form-control" placeholder="Raza del animal" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="descripcion">Descripción :</label>
                                    <textarea class="form-control" col="6" rows="3" id="descripcion" name="descripcion" placeholder="Descripción breve del animal"></textarea>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <strong>Kg</strong>
                                        </div>
                                        <input type="number" id="peso" name="peso" class="form-control" placeholder="Peso del animal" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <strong>Años</strong>
                                        </div>
                                        <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad del animal" required>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="sexo">Sexo :</label>
                                    <div class="input-group">
                                      <div class="radio">
                                        <label><input type="radio" id="sexo" name="sexo" value="Macho" required> Macho &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                      </div>
                                      <div class="radio">
                                        <label><input type="radio" id="sexo" name="sexo" value="Hembra" required> Hembra &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="condiciones"> Condiciones Actuales :</label>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="amigable" name="amigable" class="form-check-input" value="1">Amigable
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="esterilizado" name="esterilizado" class="form-check-input" value="1">Esterilizado
                                      </label>
                                    </div>
                                   <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" id="vacunado" name="vacunado" class="form-check-input" value="1">Vacunado
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox"  id="desparasitado" name="desparasitado" class="form-check-input" value="1">Desparasitado
                                      </label>
                                   </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="avatar">Foto del Animal :</label>
                                    <input type="file" id="avatar" name="avatar">
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <button type="submit" id="submit" name="añadiranimal" class="btn btn-default block"><i class="fas fa-plus-circle"></i> Añadir Animal</button>
                                  </div>
                                  <br>
                                </form>
                              </div>
                            <?php
                              }
                            ?>
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
