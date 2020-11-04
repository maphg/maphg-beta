function validarOT() {
    let URL = window.location.hash;
    const idOT = URL.replace(/#|T|F|/gi, '');

    if (idOT > 0) {
        if (URL[1] == "T") {
            generarOT(idOT, 'TAREA');
        } else if (URL[1] == "F") {
            generarOT(idOT, 'FALLA');
        }
        alertaImg('Generando OT #' + idOT, '', 'success', 1500);
    } else {
        alertaImg('Generando OT #' + idOT, '', 'success', 1500);
    }
}


// GENERA OT
function generarOT(idOT, tipo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "generarOT";
    const URL = `php/ot_fallas_tareas.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&tipo=${tipo}`;
    console.log(URL);
    fetch(URL)
        .then((array) => array.json())
        .then(array => {
            document.getElementById("idOTQR").innerHTML = array.datos.idOT;
            document.getElementById("numeroOT").innerHTML = 'OT NÚMERO #' + array.datos.idOT;
            document.getElementById("destinoOT").innerHTML = array.datos.destino;

            document.getElementById("seccionOT").innerHTML = array.datos.seccion;
            document.getElementById("logoClassOT").className = '';
            document.getElementById("logoClassOT").classList.add('relative', array.datos.seccion.toLowerCase() + '-logo');

            document.getElementById("subseccionOT").innerHTML = array.datos.subseccion;
            document.getElementById("tipoMantenimientoOT").innerHTML = array.datos.tipo;
            document.getElementById("equipoOT").innerHTML = array.datos.equipo;
            document.getElementById("tipoMatenimiento2OT").innerHTML = array.datos.actividad;

            document.getElementById("statusOT").innerHTML = array.datos.status;
            document.getElementById("statusOT").classList.add('bg-red');

            if (array.actividades.length > 0) {
                for (let x = 0; x < array.actividades.length; x++) {
                    const actividad = array.actividades[x].actividad;
                    const status = array.actividades[x].status;

                    if (status == 'PENDIENTE') {
                        var actividadHTML = `
                            <div class="p-2 rounded font-semibold flex items-center justify-start bg-red-100 text-red-500 cursor-pointer mb-1">
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-red-600">
                                </div>
                                <div class="w-full text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </div>
                        `;

                    } else {
                        var actividadHTML = `
                            <div class="p-2 rounded font-semibold flex items-center justify-start bg-green-100 text-green-500 cursor-pointer mb-1">
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="w-full text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </div>
                        `;
                    }
                    document.getElementById("dataActividades").
                        insertAdjacentHTML('beforeend', actividadHTML);
                }
            }

        })
        .catch(function (err) {
            console.log(err);
        })
}

// Función Inicial
validarOT();