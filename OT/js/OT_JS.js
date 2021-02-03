function verOT() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let url = localStorage.getItem('URL').split(';');
    let idSemana = url[0];
    let idProceso = url[1];
    let idEquipo = url[2];
    let semanaX = url[3];
    let idPlan = url[4];
    const action = "GENERAROT";

    $.ajax({
        type: "POST",
        url: "php/ot_crud.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSemana: idSemana,
            idProceso: idProceso,
            idEquipo: idEquipo,
            semanaX: semanaX,
            idPlan: idPlan
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("idOTQR").innerHTML = data.id;
            document.getElementById("idOT").innerHTML = data.id;
            document.getElementById("seccionOT").innerHTML = data.seccion;
            document.getElementById("destinoOT").innerHTML = data.destino;
            document.getElementById("comentarioOT").innerHTML = data.comentario;
            document.getElementById("subseccionOT").innerHTML = data.grupo;
            document.getElementById("tipoMantenimientoOT").innerHTML = 'Mantenimiento ' + data.tipo_plan;
            document.getElementById("numeroOT").innerHTML = 'OT NÚMERO ' + data.id;
            document.getElementById("tipoMatenimiento2OT").innerHTML = 'Mantenimiento ' + data.grado;
            document.getElementById("periodicidadOT").innerHTML = data.frecuencia;
            document.getElementById("semanaOT").innerHTML = 'Semana ' + data.semana;
            document.getElementById("añoOT").innerHTML = data.año;
            document.getElementById("equipoOT").innerText = data.equipo;
            document.getElementById("fechaOT").innerHTML = 'GENERADA EL ' + data.fecha_creacion;
            document.getElementById("logoClassOT").classList.remove();
            document.getElementById("logoClassOT").classList.add(data.seccion.toLowerCase() + '-logo');
            document.getElementById("dataMaterialesOT").innerHTML = data.materiales;
            document.getElementById("indicacionesAdicionalesOT").innerHTML = data.descripcion;
            document.getElementById("responsable").innerHTML = data.responsable;

            if (data.equipoPrincial != "") {
                document.getElementById("equipoPrincipalOT").innerText = 'Equipo Principal: ' + data.equipoPrincial;
            }

            if (data.status == "PROCESO") {
                document.getElementById("statusOT").innerHTML = 'EN ' + data.status;
            } else {
                document.getElementById("statusOT").innerHTML = data.status;
            }
            consultaAdjuntosOT(data.id);
            consultaActividadesOT(data.id);
        }
    });
}

// Responsables asignados
function consultaResponsablesOT(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultaResponsablesOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;

    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let responsables = `
                <div onclick="toggleModalTailwind('modalUsuarios'); obtenerUsuarios('asignarOT', ${idOT});" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                    <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                </div>
            `;

            for (let i = 0; i < array.length; i++) {
                var nombre = array[i].nombre + ' ' + array[i].apellido;
                var idResponsable = array[i].idUsuario;

                responsables += `
                    <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">${nombre}</h1>
                        <i onclick="eliminarResponsbleOT(${idOT}, ${idResponsable})" class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }
            document.getElementById("responsablesOT").innerHTML = responsables;
        });
}


function consultaAdjuntosOT(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultarAdjuntosOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let imagenes = '';
            let documentos = '';

            for (let i = 0; i < array.length; i++) {
                const id = array[i].id;
                const nombre = array[i].nombre;
                const url = array[i].url;
                const tipo = array[i].tipo;

                if (tipo == "imagenes") {
                    imagenes += `   
                    <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(../planner/mp_ot/${url});"></div>         
                    `;
                } else {
                    documentos += `                 
                    `;
                }
            }

            document.getElementById("mediaOT").innerHTML = '';
            document.getElementById("mediaOT").innerHTML = imagenes;


        });
}


function consultaActividadesOT(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultaActividadesOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;

    fetch(URL)
        .then(res => res.json())
        .then(array => {
            // Actividades OT
            var actividades = '';

            if (array.actividades) {
                for (let i = 0; i < array.actividades.length; i++) {
                    var id = array.actividades[i].id;
                    var actividad = array.actividades[i].actividad;
                    var tipoActividad = array.actividades[i].tipoActividad;
                    var medicion = array.actividades[i].medicion;

                    if (tipoActividad == "actividad") {

                        actividades += `
                        <div class="pb-1 rounded font-semibold text-xs text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer">
                            <label class="mx-2 inline-flex items-center">
                                <input id="actividad_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="checkbox" class="form-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" disabled>
                                <div class="ml-2 text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </label>
                        </div>
                    `;
                    }
                }
            }
            if (array.test) {
                for (let i = 0; i < array.test.length; i++) {
                    var id = array.test[i].id;
                    var actividad = array.test[i].actividad;
                    var tipoActividad = array.test[i].tipoActividad;
                    var medicion = array.test[i].medicion;

                    if (tipoActividad == "test") {

                        actividades += `
                        <div class="pb-1 rounded font-semibold text-xs text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer">
                            <div class="mr-2 flex flex-col leading-none">
                                <input id="test_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="text" name="" class="border-2 w-20 h-6 border-green-500 px-2 rounded font-bold" placeholder="" disabled>
                                <h1 class="font-bold text-xxs text-center text-bluegray-600">${medicion}</h1>
                            </div>
                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>
                    `;
                    }
                }
            }

            if (array.check) {
                for (let i = 0; i < array.check.length; i++) {
                    var id = array.check[i].id;
                    var actividad = array.check[i].actividad;
                    var tipoActividad = array.check[i].tipoActividad;
                    var medicion = array.check[i].medicion;

                    if (tipoActividad == "checkList") {
                        actividades += `
                        <div class="pb-1 rounded font-semibold text-xs text-bluegray-900 flex items-center justify-start cursor-pointer leading-none  hover:bg-green-100 hover:text-green-500">

                            <div class="flex items-center justify-start p-1 rounded">
                                <input id="check_si_${id}" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="SI" disabled>
                                <div class=" text-justify">
                                    <h1>SI</h1>
                                </div>
                            </div>

                            <div class="flex items-center justify-start p-1 rounded">
                                <input id="check_no_${id}" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NO" disabled>
                                <div class=" text-justify">
                                    <h1>NO</h1>
                                </div>
                            </div>

                            <div class="flex items-center justify-start p-1 rounded">
                                <input id="check_na_${id}" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NA" disabled>
                                <div class=" text-justify">
                                    <h1>N/A</h1>
                                </div>
                            </div>

                            <div class=" text-justify text-xs flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>                    
                    `;
                    }
                }
            }

            // ACTIVIDADES EXTRA
            var actividadesExtra = '';
            for (let i = 0; i < array.actividadesExtra.length; i++) {
                const actividad = array.actividadesExtra[i];
                if (actividad == "0") {
                    document.getElementById("actividadesExtraOT").innerHTML = '';
                } else {
                    actividadesExtra += `
                        <div class="pb-1 rounded font-semibold text-xs flex items-center justify-start bg-green-100 text-green-500 cursor-pointer">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="w-full text-justify">
                                <h1>${actividad}</h1>
                            </div>
                        </div>                   
                    `;
                }

            }

            // Retorna los resultados a los Contenedores HTML
            document.getElementById("dataActividades").innerHTML = '';
            document.getElementById("dataActividades").innerHTML = actividades + actividadesExtra;
        })
        .then(() => {
            consultarActividadRealizadaOT(idOT);
        });
}


function consultarActividadRealizadaOT(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultarActividadRealizadaOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let actividades = array.actividades.split(';');
            for (let i = 0; i < actividades.length; i++) {
                if (actividades[i] != "") {
                    document.getElementById("actividad_" + actividades[i]).checked = true;
                }
            }

            let test = array.test.split(';');
            for (let i = 0; i < test.length; i++) {
                if (test[i] != "") {
                    const test_2 = test[i].split('=');
                    const idTest = test_2[0];
                    var valorTest = test_2[1];
                    if (valorTest == undefined) {
                        valorTest = "";
                    }
                    document.getElementById("test_" + idTest).value = valorTest;
                }
            }

            let check = array.check.split(';');
            for (let i = 0; i < check.length; i++) {
                if (check[i] != "") {
                    const check_2 = check[i].split('=');
                    const idCheck = check_2[0];
                    var valorCheck = check_2[1];

                    if (valorCheck == "SI") {
                        document.getElementById("check_si_" + idCheck).checked = true;
                    }
                    if (valorCheck == "NO") {
                        document.getElementById("check_no_" + idCheck).checked = true;
                    }
                    if (valorCheck == "NA") {
                        document.getElementById("check_na_" + idCheck).checked = true;
                    }
                }
            }
        });
}


verOT();
