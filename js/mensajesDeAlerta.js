function enviarMensaje(idUsuarioServicio, asunto, contenido){
  var data = {"idUsuarioServicio" : idUsuarioServicio, "asunto" : asunto, "contenido" : contenido};
  $.ajax({
    data: data,
    url: '/carepets/usuario/busqueda/enviarMensaje.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Mensaje enviado con éxito',
          showConfirmButton: false,
          timer: 1500
        })
        document.getElementById("asunto").value = "";
        document.getElementById("mensaje").value = "";
      }else{
        Swal.fire({
          position: 'center',
          type: 'error',
          title: 'Lo sentimos, no se pudo enviar el mensaje con éxito',
          showConfirmButton: false,
          timer: 2300
        })
      }
    }
  });
}

function confirmarSolicitud(idUsuarioServicio, nombreUsuarioServicio, servicio, precio, fecha1, fecha2, fecha3, importeTotal){
  var data = {"idUsuarioServicio" : idUsuarioServicio, "nombreUsuarioServicio" : nombreUsuarioServicio, "servicio" : servicio, "fecha1" : fecha1, "fecha2" : fecha2, "fecha3" : fecha3, "importeTotal" : importeTotal};
  $.ajax({
    data: data,
    url: '/carepets/usuario/busqueda/enviarSolicitudCuidador.php',
    type: 'post',
    async: false,
    success: function(response){
      alert(response);
      if(response == true){
        Swal.fire({
          position: 'center',
          type: 'success',
          title: 'Solicitud enviada con éxito',
          showConfirmButton: false,
          timer: 1500
        })
      }else{
        Swal.fire({
          position: 'center',
          type: 'error',
          title: 'Lo sentimos, su solicitud no se pudo enviar con éxito',
          showConfirmButton: false,
          timer: 2300
        })
      }
    }
  });
}

function solicitarServicio(idUsuarioServicio, nombreUsuarioServicio, servicio, precio, fecha1, fecha2, fecha3){
  if(servicio == 'Alojamiento'){
    var fecha1Comparar = moment(fecha1);
    var fecha2Comparar = moment(fecha2);
    var diasDiferencia = fecha2Comparar.diff(fecha1Comparar, 'days');
    diasDiferencia = diasDiferencia+1;
    var importeTotal = (diasDiferencia * precio)+'€';
    swal.fire({
      title: "¿Seguro que deseas solicitar este servicio?",
      type: "warning",
      text: "Cuidador: "+nombreUsuarioServicio+" | Servicio: "+servicio+" | Desde: "+fecha1+" | Hasta: "+fecha2+" | Importe Total: "+importeTotal,
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      confirmButtonColor: "#00ff55",
      cancelButtonColor: "#999999",
      reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            this.confirmarSolicitud(idUsuarioServicio, nombreUsuarioServicio, servicio, precio, fecha1, fecha2, fecha3, importeTotal);
        }
    })
  }else{
    importeTotal = precio+'€';
    swal.fire({
      title: "¿Seguro que deseas solicitar este servicio?",
      type: "warning",
      text: "Cuidador: "+nombreUsuarioServicio+" | Servicio: "+servicio+" | Día: "+fecha3+" | Importe Total: "+importeTotal,
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
      confirmButtonColor: "#00ff55",
      cancelButtonColor: "#999999",
      reverseButtons: true,
    }).then((result) => {
        if (result.value) {
            this.confirmarSolicitud(idUsuarioServicio, nombreUsuarioServicio, servicio, precio, fecha1, fecha2, fecha3, importeTotal);
        }
    })
  }
}
