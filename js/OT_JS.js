// Muestra los datos de las OT
function obtenerOTDigital(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
    document.getElementById("modalSolucionarOT").classList.add('open');
    document.getElementById("tooltipMP").classList.add('hidden');
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerOTDigital";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}&semanaX=${semanaX}&idPlan=${idPlan}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let idOT = array[0].OT;
            document.getElementById("numeroOT").innerHTML = idOT;
            localStorage.setItem('idOT', idOT);

            // Status de la OT
            document.getElementById("statusOT").innerHTML = array[0].statusOT;
            if (array[0].statusOT == "SOLUCIONADO") {
                document.getElementById("statusOT").classList.remove("bg-yellow-200", "text-yellow-500", "bg-green-200", "text-green-500");
                document.getElementById("statusOT").classList.add("bg-green-200", "text-green-500");
            } else {
                document.getElementById("statusOT").classList.remove("bg-yellow-200", "text-yellow-500", "bg-green-200", "text-green-500");
                document.getElementById("statusOT").classList.add("bg-yellow-200", "text-yellow-500");
            }

            document.getElementById("semanaOT").innerHTML = array[0].semana;
            document.getElementById("comentarioOT").value = array[0].comentario;
            document.getElementById("tipoOT").innerHTML = array[0].tipoPlan;


            // Actividades OT
            var actividades = '';

            for (let i = 0; i < array[0].actividades.length; i++) {
                var id = array[0].actividades[i].id;
                var actividad = array[0].actividades[i].actividad;
                var tipoActividad = array[0].actividades[i].tipoActividad;
                var medicion = array[0].actividades[i].medicion;

                if (tipoActividad == "actividad") {

                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <label class="mx-2 inline-flex items-center">
                                <input id="actividad_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="checkbox" class="form-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600">
                                <div class="ml-2 text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </label>
                        </div>
                    `;
                } else if (tipoActividad == "test") {

                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <div class="mr-2 flex flex-col leading-none">
                                <input id="test_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="text" name="" class="border-2 w-20 h-6 border-green-500 px-2 rounded font-bold" placeholder="Lectura">
                                <h1 class="font-bold text-xxs text-center text-bluegray-600">${medicion}</h1>
                            </div>
                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>
                    `;
                } else if (tipoActividad == "checkList") {
                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start cursor-pointer mb-1 leading-none  hover:bg-green-100 hover:text-green-500">

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_si_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="SI">
                                <div class=" text-justify">
                                    <h1>SI</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_no_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NO">
                                <div class=" text-justify">
                                    <h1>NO</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_na_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NA">
                                <div class=" text-justify">
                                    <h1>N/A</h1>
                                </div>
                            </div>

                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>                    
                    `;
                }
            }
            document.getElementById("actividadesOT").innerHTML = actividades;

            // Funciones Complementarias Primarias
            consultarActividades(idOT);
            consultaAdjuntosOT(idOT);
            consultaStatusOT(idOT);

            return idOT;
        })
        .then(idOT => {
            // Funciones Complementarias Secunadarias
            consultarActividadRealizadaOT(idOT);
            consultaResponsablesOT(idOT);
        });
}


// Función para Agregar Actividades
function agregarActividadesExtra(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let actividadesExtra = document.getElementById("inputActividadesExtra").value;
    const action = "agregarActividadesExtra";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&actividadesExtra=${actividadesExtra}`;
    if (actividadesExtra.length > 0 && actividadesExtra != "0") {
        fetch(URL)
            .then(res => res.json())
            .then(array => {
                if (array == "Agregada") {
                    consultarActividades(idOT);
                    document.getElementById("inputActividadesExtra").value = '';
                    alertaImg('Actividad Agregada', '', 'success', 2000);
                } else {
                    alertaImg('Actividad Repetida', '', 'info', 2500);
                    consultarActividades(idOT);
                }
            });
    } else {
        alertaImg('Actividad Vacia', '', 'info', 2500);
    }
}


// Consulta las actividades Extra de la OT
function consultarActividades(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultarActividadesExtraOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            // ACTIVIDADES EXTRA
            var actividadesExtra = '';
            for (let i = 0; i < array[0].actividadesExtra.length; i++) {
                const actividad = array[0].actividadesExtra[i];
                if (actividad == "0") {
                    document.getElementById("actividadesExtraOT").innerHTML = '';
                } else {
                    actividadesExtra += `
                        <div class="p-2 rounded font-semibold flex items-center justify-start bg-green-100 text-green-500 cursor-pointer mb-1">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="w-full text-justify">
                                <h1>${actividad}</h1>
                            </div>
                            <div class="text-justify text-gray-500" onclick="eliminarActividadesExtra(${idOT}, ${i})";>
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>                   
                    `;
                }

            }
            document.getElementById("actividadesExtraOT").innerHTML = actividadesExtra;
        });
}


// Elimina Actividades Extra de la OT
function eliminarActividadesExtra(idOT, posicionItem) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "eliminarActividadesExtra";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&posicionItem=${posicionItem}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array == "Eliminada") {
                consultarActividades(idOT);
                alertaImg('Actividad Eliminada', '', 'success', 2000);
            } else {
                consultarActividades(idOT);
                alertaImg('Actividad NO Eliminada', '', 'info', 2500);
            }
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
            document.getElementById("imagenesOT").innerHTML = '';
            document.getElementById("documentosOT").innerHTML = '';
            document.getElementById("dataImagenes").innerHTML = '';
            document.getElementById("dataAdjuntos").innerHTML = '';

            let imagenes = '';
            let documentos = '';

            for (let i = 0; i < array.length; i++) {
                const id = array[i].id;
                const nombre = array[i].nombre;
                const url = array[i].url;
                const tipo = array[i].tipo;

                if (tipo == "imagenes") {
                    imagenes += `
                    <a id="${id}" href="../planner/mp_ot/${url}" target="_blank">
                        <div class="m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md">
                            <img src="../planner/mp_ot/${url}" class="w-full" alt="">
                        </div>
                    </a>            
                    `;
                } else {
                    documentos += `
                        <a id="${id}" href="../planner/mp_ot/${url}" target="_blank">
                            <div class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                <i class="fad fa-file-alt fa-2x"></i>
                                <p class=" font-normal ml-2">${url}</p>
                            </div>
                        </a>                   
                    `;
                }
            }

            document.getElementById("imagenesOT").innerHTML = imagenes;
            document.getElementById("documentosOT").innerHTML = documentos;

            document.getElementById("dataImagenes").innerHTML = imagenes;
            document.getElementById("dataAdjuntos").innerHTML = documentos;

            if (imagenes != "") {
                document.getElementById("contenedorImagenes").classList.remove('hidden');
            } else {
                document.getElementById("contenedorImagenes").classList.add('hidden');
            }

            if (documentos != "") {
                document.getElementById("contenedorDocumentos").classList.remove('hidden');
            } else {
                document.getElementById("contenedorDocumentos").classList.add('hidden');
            }

            // Eventos
            document.getElementById("inputAdjuntos").setAttribute("onchange", `subirImagenGeneral(${idOT}, "t_mp_planificacion_iniciada_adjuntos")`);
            document.getElementById("btnAdjuntosOT").setAttribute("onclick", `consultaAdjuntosOT(${idOT}); toggleModalTailwind('modalMedia');`);
        });
}


// Consulta los Status de la OT
function consultaStatusOT(idOT) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultarStatusOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            estiloDefectoModalStatus();
            let status = `
                <div id="statusOT2" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                    <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                </div>            
            `;

            if (array.statusTrabajare == "1") {
                estiloStatusActivoModalStatus("statusTrabajare");
                status += `
                <div class="bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2">
                <h1 class="font-medium">Trabajando</h1>
                <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                </div>
                `;
            }

            if (array.statusMaterial == "1") {
                estiloStatusActivoModalStatus("statusMaterial");
                status += `
                    <div class="bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Material</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusElectricidad == "1") {
                estiloStatusActivoModalStatus("statusElectricidad");
                status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Electricidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusDiesel == "1") {
                estiloStatusActivoModalStatus("statusDiesel");
                status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Diesel</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusGas == "1") {
                estiloStatusActivoModalStatus("statusGas");
                status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Gas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusAgua == "1") {
                estiloStatusActivoModalStatus("statusAgua");
                status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Agua</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusCalidad == "1") {
                estiloStatusActivoModalStatus("statusCalidad");
                status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Calidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusCompras == "1") {
                estiloStatusActivoModalStatus("statusCompras");
                status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Compras</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusDireccion == "1") {
                estiloStatusActivoModalStatus("statusDireccion");
                status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Dirección</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusFinanzas == "1") {
                estiloStatusActivoModalStatus("statusFinanzas");
                status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Finanzas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusRRHH == "1") {
                estiloStatusActivoModalStatus("statusRRHH");
                status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">RRHH</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
            }

            if (array.statusCalidad == "1" || array.statusCompras == "1" || array.statusDireccion == "1" || array.statusFinanzas == "1" || array.statusRRHH == "1") {
                estiloStatusActivoModalStatus("statusdep");
            }

            if (array.statusElectricidad == "1" || array.statusDiesel == "1" || array.statusGas == "1" || array.statusAgua == "1") {
                estiloStatusActivoModalStatus("statusenergeticos");
            }

            return status;
        })
        .then(status => {
            document.getElementById("dataStatusOT").innerHTML = status;
            document.getElementById("statusOT2").setAttribute("onclick", `consultaStatusOT(${idOT}); toggleModalTailwind('modalStatus');`);
            document.getElementById("statusMaterial").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_material');`);
            document.getElementById("statusTrabajare").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_trabajando');`);
            document.getElementById("statusElectricidad").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_electricidad');`);
            document.getElementById("statusAgua").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_agua');`);
            document.getElementById("statusDiesel").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_diesel');`);
            document.getElementById("statusGas").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_gas');`);
            document.getElementById("statusRRHH").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_rrhh');`);
            document.getElementById("statusDireccion").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_direccion');`);
            document.getElementById("statusFinanzas").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_finanzas');`);
            document.getElementById("statusCalidad").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_calidad');`);
            document.getElementById("statusCompras").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_compras');`);
            document.getElementById("statusFinalizar").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status');`);
            document.getElementById("btnFinalizarOT").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status');`);
        });
}


function actualizaStatusOT(idOT, status) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "actualizaStatusOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&status=${status}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array.respuesta == "ACTIVADO") {
                alertaImg(`Status Activado`, '', 'success', 3000);
            } else if (array.respuesta == "DESACTIVADO") {
                alertaImg(`Status Desactivado`, '', 'success', 3000);
            } else if (array.respuesta == "SOLUCIONADO") {
                let idEquipo = localStorage.getItem('idEquipo');
                informacionEquipo(idEquipo);
                despieceEquipos(idEquipo);
                alertaImg(`OT #${array.idOT} Solucionado`, '', 'success', 3000);
                document.getElementById("modalSolucionarOT").classList.remove('open');
                document.getElementById("modalStatus").classList.remove('open');
            }
        });
}


function actividadRealizadaOT(idOT, idActividad, tipoActividad) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let valor = 0;


    if (tipoActividad == "test") {
        valor = document.getElementById("test_" + idActividad).value;
    }

    if (tipoActividad == "checkList") {

        if (document.getElementById("check_si_" + idActividad).checked) {
            valor = document.getElementById("check_si_" + idActividad).value;
        }

        if (document.getElementById("check_no_" + idActividad).checked) {
            valor = document.getElementById("check_no_" + idActividad).value;
        }

        if (document.getElementById("check_na_" + idActividad).checked) {
            valor = document.getElementById("check_na_" + idActividad).value;
        }
    }

    const action = "actividadRealizadaOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&idActividad=${idActividad}&tipoActividad=${tipoActividad}&valor=${valor}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array == "Actualizado") {
                consultarActividadRealizadaOT(idOT);
                alertaImg("Actividad Actualizada", "", "success", 2000);
            } else {
                consultarActividadRealizadaOT(idOT);
                alertaImg("Intente de Nuevo", "", "success", 2000);
            }
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


// Responsables asignados
function eliminarResponsbleOT(idOT, idResponsable) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "eliminarResponsbleOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&idResponsable=${idResponsable}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array == "Agregado") {
                consultaResponsablesOT(idOT);
                document.getElementById("modalUsuarios").classList.remove('open');
                alertaImg("Usuario Asignado a la OT: " + idOT, "", "success", 2000);
            } else if (array == "Eliminado") {
                consultaResponsablesOT(idOT);
                document.getElementById("modalUsuarios").classList.remove('open');
                alertaImg("Usuario Eliminado", "", "success", 2000);
            }
        });
}


// Obtienes Opciones para asignar Responsables OT
function obtenerUsuarios(tipoAsginacion, idItem) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraUsuario = document.getElementById("palabraUsuario").value;

    document.getElementById("modalUsuarios").classList.add("open");
    document.getElementById("dataUsuarios").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

    const action = "obtenerUsuarios";
    $.ajax({
        type: "POST",
        url: "../php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            palabraUsuario: palabraUsuario,
            tipoAsginacion: tipoAsginacion,
            idItem: idItem,
        },
        dataType: "JSON",
        success: function (data) {
            alertaImg("Usuarios Obtenidos: " + data.totalUsuarios, "", "info", 2000);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
            document.getElementById("palabraUsuario").setAttribute("onkeydown", 'obtenerUsuarios("' + tipoAsginacion + '",' + idItem + ")"
            );
        },
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

            for (let i = 0; i < array.actividades.length; i++) {
                var id = array.actividades[i].id;
                var actividad = array.actividades[i].actividad;
                var tipoActividad = array.actividades[i].tipoActividad;
                var medicion = array.actividades[i].medicion;

                if (tipoActividad == "actividad") {

                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <label class="mx-2 inline-flex items-center">
                                <input id="actividad_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="checkbox" class="form-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600">
                                <div class="ml-2 text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </label>
                        </div>
                    `;
                }
            }

            for (let i = 0; i < array.test.length; i++) {
                var id = array.test[i].id;
                var actividad = array.test[i].actividad;
                var tipoActividad = array.test[i].tipoActividad;
                var medicion = array.test[i].medicion;

                if (tipoActividad == "test") {

                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <div class="mr-2 flex flex-col leading-none">
                                <input id="test_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="text" name="" class="border-2 w-20 h-6 border-green-500 px-2 rounded font-bold" placeholder="Lectura">
                                <h1 class="font-bold text-xxs text-center text-bluegray-600">${medicion}</h1>
                            </div>
                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>
                    `;
                }
            }

            for (let i = 0; i < array.check.length; i++) {
                var id = array.check[i].id;
                var actividad = array.check[i].actividad;
                var tipoActividad = array.check[i].tipoActividad;
                var medicion = array.check[i].medicion;

                if (tipoActividad == "checkList") {
                    actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start cursor-pointer mb-1 leading-none  hover:bg-green-100 hover:text-green-500">

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_si_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="SI">
                                <div class=" text-justify">
                                    <h1>SI</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_no_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NO">
                                <div class=" text-justify">
                                    <h1>NO</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_na_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NA">
                                <div class=" text-justify">
                                    <h1>N/A</h1>
                                </div>
                            </div>

                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>                    
                    `;
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
                        <div class="p-2 rounded font-semibold flex items-center justify-start bg-green-100 text-green-500 cursor-pointer mb-1">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="w-full text-justify">
                                <h1>${actividad}</h1>
                            </div>
                            <div class="text-justify text-gray-500" onclick="eliminarActividadesExtra(${idOT}, ${i})";>
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>                   
                    `;
                }

            }

            // Retorna los resultados a los Contenedores HTML
            document.getElementById("actividadesExtraOT").innerHTML = actividadesExtra;
            document.getElementById("actividadesOT").innerHTML = actividades;
        });
}


function guardarCambiosOT() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let comentario = document.getElementById("comentarioOT").value;
    let idOT = localStorage.getItem('idOT');
    const action = "guardarCambiosOT";
    const URL = `../php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&comentario=${comentario}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array == "Actualizado") {
                alertaImg(`OT #${idOT} Actualizada`, '', 'success', 3000);
            } else {
                alertaImg(`Intente de Nuevo`, '', 'info', 3000);
            }
        });
}


// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass("open");
}

// Función para Agregar Evento ENTER y agregar alguna Actividad Extra
document.getElementById("inputActividadesExtra").addEventListener("keyup", function (event) {
    if (event.keyCode === 13) {
        let idOT = localStorage.getItem('idOT');
        agregarActividadesExtra(idOT);
    }
});

// Eventos
document.getElementById("btnGuardarOT").addEventListener("click", guardarCambiosOT);


// Función para Limpiar estilos aplicados en las opciones de modalStatus
function estiloDefectoModalStatus() {
    document.getElementById("statusMaterial").classList.remove("bg-orange-200");
    document.getElementById("statusTrabajare").classList.remove("bg-blue-200");

    //Energeticos
    document.getElementById("statusenergeticos").classList.remove("bg-yellow-200");
    document.getElementById("statusElectricidad").classList.remove("bg-yellow-200");
    document.getElementById("statusAgua").classList.remove("bg-yellow-200");
    document.getElementById("statusDiesel").classList.remove("bg-yellow-200");
    document.getElementById("statusGas").classList.remove("bg-yellow-200");

    //Departamentos
    document.getElementById("statusdep").classList.remove("bg-teal-200");
    document.getElementById("statusRRHH").classList.remove("bg-teal-200");
    document.getElementById("statusCalidad").classList.remove("bg-teal-200");
    document.getElementById("statusDireccion").classList.remove("bg-teal-200");
    document.getElementById("statusFinanzas").classList.remove("bg-teal-200");
    document.getElementById("statusCompras").classList.remove("bg-teal-200");

    //Bitacora
    document.getElementById("statusbitacora").classList.remove("bg-lightblue-50");
    document.getElementById("statusGP").classList.remove("bg-lightblue-50");
    document.getElementById("statusTRS").classList.remove("bg-lightblue-50");
    document.getElementById("statusZI").classList.remove("bg-lightblue-50");
}


// Función para Aplicar Estilo a los Status activos
function estiloStatusActivoModalStatus(status) {
    if (status == "statusMaterial") {
        document.getElementById("statusMaterial").classList.add("bg-orange-200");
    }
    if (status == "statusTrabajare") {
        document.getElementById("statusTrabajare").classList.add("bg-blue-200");
    }
    if (status == "statusenergeticos") {
        document.getElementById("statusenergeticos").classList.add("bg-yellow-200");
    }
    if (status == "statusElectricidad") {
        document.getElementById("statusElectricidad").classList.add("bg-yellow-200");
    }
    if (status == "statusAgua") {
        document.getElementById("statusAgua").classList.add("bg-yellow-200");
    }
    if (status == "statusDiesel") {
        document.getElementById("statusDiesel").classList.add("bg-yellow-200");
    }
    if (status == "statusGas") {
        document.getElementById("statusGas").classList.add("bg-yellow-200");
    }
    if (status == "statusdep") {
        document.getElementById("statusdep").classList.add("bg-teal-200");
    }
    if (status == "statusCalidad") {
        document.getElementById("statusCalidad").classList.add("bg-teal-200");
    }
    if (status == "statusCompras") {
        document.getElementById("statusCompras").classList.add("bg-teal-200");
    }
    if (status == "statusDireccion") {
        document.getElementById("statusDireccion").classList.add("bg-teal-200");
    }
    if (status == "statusFinanzas") {
        document.getElementById("statusFinanzas").classList.add("bg-teal-200");
    }
    if (status == "statusRRHH") {
        document.getElementById("statusRRHH").classList.add("bg-teal-200");
    }
}