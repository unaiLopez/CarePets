function mensajeEnviado(){
  Swal.fire({
  position: 'center',
  type: 'success',
  title: 'Mensaje enviado con éxito',
  showConfirmButton: false,
  timer: 1500
})
}

function solicitarServicio(nombreUsuarioServicio, servicio, precio, fecha1, fecha2, fecha3){
  if(servicio == 'Alojamiento'){
    var fecha1Comparar = moment(fecha1);
    var fecha2Comparar = moment(fecha2);
    alert(fecha2Comparar.diff(fecha1Comparar, 'days'));
    var diasDiferencia = fecha2Comparar.diff(fecha1Comparar, 'days');
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
    });
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
    });
  }
}
