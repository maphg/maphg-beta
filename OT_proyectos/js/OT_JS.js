const verOTProyectos = () => {
    // OT -> idPlanaccion
    let ot = localStorage.getItem('URL');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const ruta = 'php/ot_crud.php?';
    const action = 'obtnerOTPlanaccion';
    const URL = `${ruta}action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&ot=${ot}`;
    // const URL = 'php/ot_crud.php?action=obtnerOTPlanaccion&idDestino=10&idUsuario=1&ot=3217';
    console.log(URL);
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {

                document.getElementById("numeroOT").innerHTML = 'OT NÚMERO ' + array.idPlanaccion;
                document.getElementById("idOTQR").innerHTML = array.idPlanaccion;
                document.getElementById("seccionOT").innerHTML = array.seccion;
                document.getElementById("destinoOT").innerHTML = array.destino;
                document.getElementById("subseccionOT").innerHTML = array.subseccion;
                document.getElementById("tipoMantenimientoOT").innerHTML = array.proyecto;
                document.getElementById("tipoMatenimiento2OT").innerHTML = array.actividad;
                document.getElementById("logoClassOT").classList.add(array.seccion.toLowerCase() + '-logo');

                if (array.status == "PENDIENTE") {
                    document.getElementById("statusOT").innerHTML = 'EN PROCESO';
                } else {
                    document.getElementById("statusOT").innerHTML = 'FINALIZADA';
                }

                document.getElementById("dataActividades").innerHTML = '';
                if (array.actividades.length > 0) {
                    for (let x = 0; x < array.actividades.length; x++) {
                        const id = array.actividades[x].id;
                        const actividad = array.actividades[x].actividad;

                        document.getElementById("dataActividades").innerHTML += `
                            <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <label class="mx-2 inline-flex items-center">
                                    <input id="actividad_${id}" type="checkbox" class="form-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" disabled>
                                    <div class="ml-2 text-justify">
                                        <h1>${actividad}</h1>
                                    </div>
                                    </label>
                            </div>
                            `;
                    }
                }

                document.getElementById("mediaOT").innerHTML = '';
                if (array.adjuntos.length > 0) {
                    for (let x = 0; x < array.adjuntos.length; x++) {
                        const adjunto = array.adjuntos[x].url;

                        document.getElementById("mediaOT").innerHTML += `
                            <a id="0" href="${adjunto}" target="_blank">
                                <div class="m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md">
                                    <img src="${adjunto}" class="w-full" alt="">
                                </div>
                            </a>
                        `;
                    }
                }

                // document.getElementById("logoClassOT").classList.remove();

                // document.getElementById("comentarioOT").innerHTML = ''
                // document.getElementById("periodicidadOT").innerHTML = '';
                // document.getElementById("semanaOT").innerHTML = '';

                // document.getElementById("añoOT").innerHTML = array.año;
                // document.getElementById("equipoOT").innerHTML = array.equipo;
                // document.getElementById("fechaOT").innerHTML = 'GENERADA EL ' + array.fechaCreacion;
                // document.getElementById("dataMaterialesOT").innerHTML = '';
                // document.getElementById("indicacionesAdicionalesOT").innerHTML = '';

            }
        })
        .catch(function () {
            alertaImg('OT #' + ot + ', No Encontrada', '', 'info', 1000);
        })
}

verOTProyectos();