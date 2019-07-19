<?php
  try {

    $idActual = $_SESSION['user_id'];
    $tipoSolicitud = 'Solicitud';
    $verificada = 1;
    $tiempo = time();
    $fechaActual = date("Y-m-d", $tiempo);

    //Tomar los mensajes de tipo solicitud enviados por mi
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_emisor=:user_id_emisor and tipo=:solicitud");
    $sentencia->bindParam(':user_id_emisor', $idActual);
    $sentencia->bindParam(':solicitud', $tipoSolicitud);
    $sentencia->execute();
    $misMensajesSolicitudEnviados = $sentencia->fetchAll(PDO::FETCH_BOTH);

    foreach($misMensajesSolicitudEnviados as $miMensajeSolicitudEnviado) {

      $sentencia = $conn->prepare("SELECT * FROM solicitud WHERE id=:id and solicitudverificada=:si");
      $sentencia->bindParam(':id', $miMensajeSolicitudEnviado['id']);
      $sentencia->bindParam(':si', $verificada);
      $sentencia->execute();
      $solicitudVerificadaPorReceptor = $sentencia->fetch(PDO::FETCH_BOTH);

      //Tomar los mensajes de tipo solicitud enviados por mi
      $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id_receptor");
      $sentencia->bindParam(':user_id_receptor', $miMensajeSolicitudEnviado['user_id_receptor']);
      $sentencia->execute();
      $receptor = $sentencia->fetch(PDO::FETCH_BOTH);

        if(isset($solicitudVerificadaPorReceptor['fechafinal'])){

          if($fechaActual > $solicitudVerificadaPorReceptor['fechafinal'] && is_null($solicitudVerificadaPorReceptor['serviciovalorado'])){

            echo "
            <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
              <div class=\"modal-dialog\">
                <!-- Modal content-->
                <div style=\"background-color: #EC9664;\" class=\"modal-content\">
                  <div style=\"border: solid 0;background-color: #EC9664;\" class=\"modal-header mx-auto\">
                    <h4>¿Cómo te fué con ";echo $receptor['nombre'];echo"?</h4>
                  </div>
                  <div style=\"border-top: solid 1px #ffffff;background-color: #EC9664;\" class=\"modal-body\">
                    <div class=\"row\">
                      <div class=\"col-xs-12 mx-auto\">
                        <x-star-rating id=\"rating\" value=\"0\" number=\"5\"></x-star-rating>
                        <script src=\"../../js/starRating.js\"></script>
                        <script type=\"text/javascript\">
                          rating.addEventListener('rate', () => {
                            var idMensaje = ".$miMensajeSolicitudEnviado['id'].";
                            var id = ".$receptor['user_id'].";
                            var puntuacion = rating.value;
                            var data = {\"id\" : id, \"puntuacion\" : puntuacion, \"idMensaje\" : idMensaje};
                            $.ajax({
                                data: data,
                                url: '/carepets/usuario/perfil/valorarDuenoCuidador.php',
                                type: 'post',
                                async: false,
                                success: function(response) {
                                  if(response == true){
                                    window.location.reload();
                                  }
                                }
                            });
                          });
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script type=\"text/javascript\">
              $('#myModal').modal({
                  backdrop: 'static',
                  keyboard: false
              })
              $(\"#myModal\").modal('show');
            </script>
            ";
          }

        }else if(isset($solicitudVerificadaPorReceptor['fechadia'])){

          if($fechaActual > $solicitudVerificadaPorReceptor['fechadia'] && is_null($solicitudVerificadaPorReceptor['serviciovalorado'])){

            echo "
            <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
              <div class=\"modal-dialog\">
                <!-- Modal content-->
                <div style=\"background-color: #EC9664;\" class=\"modal-content\">
                  <div style=\"border: solid 0;background-color: #EC9664;\" class=\"modal-header mx-auto\">
                    <h4>¿Cómo te fué con ";echo $receptor['nombre'];echo"?</h4>
                  </div>
                  <div style=\"border-top: solid 1px #ffffff;background-color: #EC9664;\" class=\"modal-body\">
                    <div class=\"row\">
                      <div class=\"col-xs-12 mx-auto\">
                        <x-star-rating id=\"rating\" value=\"0\" number=\"5\"></x-star-rating>
                        <script src=\"../../js/starRating.js\"></script>
                        <script type=\"text/javascript\">
                          rating.addEventListener('rate', () => {
                            var idMensaje = ".$miMensajeSolicitudEnviado['id'].";
                            var id = ".$receptor['user_id'].";
                            var puntuacion = rating.value;
                            var data = {\"id\" : id, \"puntuacion\" : puntuacion, \"idMensaje\" : idMensaje};
                            $.ajax({
                                data: data,
                                url: '/carepets/usuario/perfil/valorarDuenoCuidador.php',
                                type: 'post',
                                async: false,
                                success: function(response) {
                                  if(response == true){
                                    window.location.reload();
                                  }
                                }
                            });
                          });
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script type=\"text/javascript\">
              $('#myModal').modal({
                  backdrop: 'static',
                  keyboard: false
              })
              $(\"#myModal\").modal('show');
            </script>
            ";
          }
        }
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
