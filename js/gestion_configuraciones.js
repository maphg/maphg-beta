// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';
// API PARA REPORTE DE ERRORES

let iconSpin = '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>';

const codigoUsuario = x => {
    const id = x['y'].idUsuario;
    const usuario = x['y'].usuario;
    const contraseña = x['y'].contraseña;
    const nombre = x['y'].nombre;
    const apellido = x['y'].apellido;
    const correo = x['y'].correo;
    const fase = x['y'].fase;
    const status = x['y'].status;
    const destino = x['y'].destino;
    const cargo = x['y'].cargo;
    const rol = x['y'].rol;
    const telefono = x['y'].telefono;
    const DEC = x['y'].DEC;
    const ZIL = x['y'].ZIL;
    const ZIE = x['y'].ZIE;
    const AUTO = x['y'].AUTO;
    const DEP = x['y'].DEP;
    const OMA = x['y'].OMA;
    const ZHA = x['y'].ZHA;
    const ZHC = x['y'].ZHC;
    const ZHH = x['y'].ZHH;
    const ZHP = x['y'].ZHP;
    const ZIA = x['y'].ZIA;
    const ZIC = x['y'].ZIC;

    if (status == "A") {
        statusX = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800">
                ACTIVO
            </span>
        `;
    } else {
        statusX = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-red-800">
                BAJA
            </span>
        `;
    }

    if (fase == "ZI") {
        faseX = `<span class="bg-orange-200 p-1 font-semibold uppercase rounded">
        ${fase}</span>`;
    } else {
        faseX = `<span class="bg-blue-200 p-1 font-semibold uppercase rounded">
        ${fase}</span>`;
    }

    if (correo != "") {
        correoX = ` 
            <a class="text-sm text-gray-500" data-title="${correo}" href="mailto:${correo}">
            <p class="truncate"><i class="fa fa-envelope"></i> ${correo}</p></a>`;
    } else {
        correoX = '';
    }

    if (telefono != "" || telefono < 0) {
        telefonoX = `
        <a class="text-sm text-blue-500" href="tel:${telefono}">
        <i class="fa fa-phone"></i> ${telefono}</a>
                        `;
    } else {
        telefonoX = '';
    }

    let DECX = '';
    let ZILX = '';
    let ZIEX = '';
    let AUTOX = '';
    let DEPX = '';
    let OMAX = '';
    let ZHAX = '';
    let ZHCX = '';
    let ZHHX = '';
    let ZHPX = '';
    let ZIAX = '';
    let ZICX = '';

    if (DEC == 1) {
        DECX = ` <span class="text-purple-700 bg-purple-400 px-1 font-semibold uppercase rounded">DEC</span>`;
    }

    if (ZIL == 1) {
        ZILX = ` <span class="text-green-700 bg-green-400 px-1 font-semibold uppercase rounded">ZIL</span>`;
    }

    if (ZIE == 1) {
        ZIEX = ` <span class="text-yellow-700 bg-yellow-400 px-1 font-semibold uppercase rounded">ZIE</span>`;
    }

    if (AUTO == 1) {
        AUTOX = ` <span class="text-teal-700 bg-teal-400 px-1 font-semibold uppercase rounded">AUTO</span>`;
    }

    if (DEP == 1) {
        DEPX = ` <span class="text-gray-300 bg-gray-900 px-1 font-semibold uppercase rounded">DEP</span>`;
    }

    if (OMA == 1) {
        OMAX = ` <span class=" px-1 font-semibold uppercase rounded">OMA</span>`;
    }

    if (ZHA == 1) {
        ZHAX = ` <span class="text-indigo-700 bg-indigo-400 px-1 font-semibold uppercase rounded">ZHA</span>`;
    }

    if (ZHC == 1) {
        ZHCX = ` <span class="text-orange-700 bg-orange-400 px-1 font-semibold uppercase rounded">ZHC</span>`;
    }

    if (ZHH == 1) {
        ZHHX = ` <span class="text-cyan-700 bg-cyan-400 px-1 font-semibold uppercase rounded">ZHH</span>`;
    }

    if (ZHP == 1) {
        ZHPX = ` <span class="text-lightblue-700 bg-lightblue-400 px-1 font-semibold uppercase rounded">ZHP</span>`;
    }

    if (ZIA == 1) {
        ZIAX = ` <span class="text-blue-700 bg-blue-400 px-1 font-semibold uppercase rounded">ZIA</span>`;
    }

    if (ZIC == 1) {
        ZICX = ` <span class="text-red-700 bg-red-400 px-1 font-semibold uppercase rounded">ZIC</span>`;
    }

    const codigo = `
        <tr id="usuario_${id}">

            <td class="px-6 py-4 whitespace-nowrap">
                <img class="rounded-circle" src="https://ui-avatars.com/api/?uppercase=true&name=${nombre + ' ' + apellido}&background=d8e6ff&rounded=true&color=4886ff&size=100%" alt="" width="40px" height="40px" data-title="${nombre}">
                <div class="text-center text-xs font-semibold text-blue-400">ID: ${id}</div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                <div class="ml-4 w-40 flex flex-col">
                    <div class="text-sm font-medium text-gray-900 uppercase" data-title="${nombre + ' ' + apellido}">
                    <p>${nombre}</p>
                    <p>${apellido}</p>
                    </div >
                    ${correoX}
                    ${telefonoX}
                </div >
            </td >

            <td class="px-6 py-4 whitespace-nowrap" >
                <div class="text-sm text-gray-900 w-24" data-title="${cargo}"><p class="truncate">
                ${cargo}</p></div>
                <div class="text-sm text-gray-500" onclick="hotelRM()"> <i class="fa fa-flag"></i> ${destino}</div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-8">
                ${rol}</span>
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 sm:hidden md:block lg:block xl:block 2xl:block">
                ${DECX}
                ${ZILX}
                ${ZIEX}
                ${AUTOX}
                ${DEPX}
                ${OMAX}
                ${ZHAX}
                ${ZHCX}
                ${ZHHX}
                ${ZHPX}
                ${ZIAX}
                ${ZICX}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${faseX}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${statusX}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="abrirmodal('modalEditarUsuario'); obtenerUsuariosX(${id})">
                <a href="#" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-ellipsis-v fa-lg"></i></a>
            </td>

        </tr >
    `;
    return codigo;
}

const codigoCargo = x => {
    const idCargo = x['y'].idCargo;
    const cargo = x['y'].cargo;
    const totalAsignados = x['y'].totalAsignados;
    const status = x['y'].status;

    if (status == "ACTIVO") {
        statusX = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800">
                ACTIVO
            </span>
        `;
    } else {
        statusX = `
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-red-800">
                BAJA
            </span>
        `;
    }

    const codigo = `
        <tr id="cargo_${idCargo}">

            <td class="px-6 py-4 whitespace-nowrap" >
                ${idCargo}
            </td>

            <td class="px-6 py-4">
                <div class="text-sm text-gray-900" data-title="${cargo}">
                    <p class="truncate">${cargo}</p>
                </div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${totalAsignados}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${statusX}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="abrirmodal('modalEditarCargos'); obtenerCargosX(${idCargo})">
                <a href="#" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-ellipsis-v fa-lg"></i></a>
            </td>

        </tr >
    `;
    return codigo;
}


// FUNCIÓN PARA OBTENER TODOS LOS USUARIOS SEGÚN DESTINO
function obtenerUsuarios(configuracionIdUsuario) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerUsuarios";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&configuracionIdUsuario=${configuracionIdUsuario}`;
    let load = document.getElementById("load");
    let palabraUsuario = document.getElementById("palabraUsuario");
    console.log(URL);
    load.innerHTML = iconSpin;
    if (configuracionIdUsuario > 0) {
        tablaUsuarios = document.getElementById("usuario_" + configuracionIdUsuario);
    } else {
        tablaUsuarios = document.getElementById("dataUsuarios");
    }
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            tablaUsuarios.innerHTML = "";
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const y = array[x];
                    const codigo = codigoUsuario({ y });
                    tablaUsuarios.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(() => {
            load.innerHTML = '';
            setTimeout(() => {
                document.getElementById("palabraUsuario").value = '';
            }, 1200);
        })
        .catch(function (err) {
            fetch(APIERROR + err + ' obtenerUsuarios(0)');
            load.innerHTML = '';
            palabraUsuario.value = '';
        })
}


// OBTIENE CONFIGURACIONES DEL USUARIO SELECCIONADO
function obtenerUsuariosX(configuracionIdUsuario) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const URL1 = `php/gestion_configuraciones.php?action=opcionesUsuario&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    const URL2 = `php/gestion_configuraciones.php?action=obtenerUsuariosX&idDestino=${idDestino}&idUsuario=${idUsuario}&configuracionIdUsuario=${configuracionIdUsuario}`;

    // ELEMENTOS
    let datosComplementariosUsuario = document.getElementById("datosComplementariosUsuario");
    let dataFases = document.getElementById("dataFases");
    let dataSecciones = document.getElementById("dataSecciones");
    let dataDestinos = document.getElementById("dataDestinos");
    let dataCargos = document.getElementById("dataCargos");
    let dataRoles = document.getElementById("dataRoles");
    let dataStatus = document.getElementById("dataStatus");
    let dataOpcionSubalmacenes = document.getElementById("dataOpcionSubalmacenes");
    let dataSubalmacenes = document.getElementById("dataSubalmacenes");
    // ELEMENTOS

    // INPUTS
    let nombreX = document.getElementById('nombreUsuario');
    let apellidoX = document.getElementById('apellidoUsuario');
    let correoX = document.getElementById('correoUsuario');
    let telefonoX = document.getElementById('telefonoUsuario');
    let usuarioX = document.getElementById('usuarioUsuario');
    let contraseñaX = document.getElementById('contraseñaUsuario');
    // INPUTS

    // SETATRIBUT
    document.getElementById("btnGuardarUsuario").
        setAttribute('onclick', `actualizarUsuario(${configuracionIdUsuario})`);
    // SETATRIBUT

    // OCULTA CONTRASEÑA
    contraseñaX.setAttribute("type", "password");
    document.getElementById("contraseñaEyes").className = "fa far fa-eye-slash p-2 mx-2";
    // OCULTA CONTRASEÑA

    // CHECK
    let check = '<i class="ml-2 fa far fa-check"></i>';
    // CHECK

    fetch(URL1)
        .then(array => array.json())
        .then(array => {

            // LIMPIA CONTENIDO
            dataFases.innerHTML = '';
            dataSecciones.innerHTML = '';
            dataDestinos.innerHTML = '';
            dataCargos.innerHTML = '';
            dataRoles.innerHTML = '';
            dataStatus.innerHTML = '';
            dataOpcionSubalmacenes.innerHTML = '';
            dataSubalmacenes.innerHTML = '';
            // LIMPIA CONTENIDO

            // FASES
            if (array.fases.length > 0) {
                for (let x = 0; x < array.fases.length; x++) {
                    const idFase = array.fases[x].idFase;
                    const fase = array.fases[x].fase;
                    const codigo = `
                        <span id="fase_${idFase}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'fase', ${idFase});">
                            ${fase}
                        </span>
                        
                    `;
                    dataFases.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // SECCIONES
            if (array.secciones.length > 0) {
                for (let x = 0; x < array.secciones.length; x++) {
                    const idSeccion = array.secciones[x].idSeccion;
                    const seccion = array.secciones[x].seccion;
                    const codigo = `
                        <span id="seccion_${seccion}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'seccion', '${seccion}');">
                            ${seccion}
                        </span>
                    `;
                    dataSecciones.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // DESTINOS
            if (array.destinos.length > 0) {
                for (let x = 0; x < array.destinos.length; x++) {
                    const idDestino = array.destinos[x].idDestino;
                    const destino = array.destinos[x].destino;
                    const codigo = `
                        <span id="destino_${idDestino}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'destino', ${idDestino});">
                            ${destino}
                        </span>
                    `;
                    dataDestinos.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // CARGOS
            if (array.cargos.length > 0) {
                for (let x = 0; x < array.cargos.length; x++) {
                    const idCargo = array.cargos[x].idCargo;
                    const cargo = array.cargos[x].cargo;
                    const codigo = `
                        <span id="cargo_${idCargo}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'cargo', ${idCargo});">
                            ${cargo}
                        </span>
                    `;
                    dataCargos.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // ROLES
            if (array.roles.length > 0) {
                for (let x = 0; x < array.roles.length; x++) {
                    const idRol = array.roles[x].idRol;
                    const rol = array.roles[x].rol;
                    const codigo = `
                        <span id="rol_${idRol}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'rol', ${idRol});">
                            ${rol}
                        </span>
                    `;
                    dataRoles.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // STATUS
            if (array.status.length > 0) {
                for (let x = 0; x < array.status.length; x++) {
                    const idStatus = array.status[x].idStatus;
                    const status = array.status[x].status;
                    const codigo = `
                        <span id="status_${idStatus}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'status', '${idStatus}');">
                            ${status}
                        </span>
                    `;
                    dataStatus.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // OPCIONES SUBALMACENES
            if (array.opcionSubalmacenes.length > 0) {
                for (let x = 0; x < array.opcionSubalmacenes.length; x++) {
                    const idOpcion = array.opcionSubalmacenes[x].idOpcion;
                    const opcion = array.opcionSubalmacenes[x].opcion;
                    const codigo = `
                        <span id="opcionSubalmacen_${idOpcion}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, '${idOpcion}', '0');">
                            ${opcion}
                        </span>
                    `;
                    dataOpcionSubalmacenes.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // SUBALMACENES
            if (array.subalmacenes.length > 0) {
                for (let x = 0; x < array.subalmacenes.length; x++) {
                    const idSubalmacen = array.subalmacenes[x].idSubalmacen;
                    const nombre = array.subalmacenes[x].nombre;
                    const fase = array.subalmacenes[x].fase;
                    const destino = array.subalmacenes[x].destino;
                    const codigo = `
                        <span id="subalmacen_${idSubalmacen}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" onclick="actualizaUsuarioOpciones(${configuracionIdUsuario}, 'acceso_sa', ${idSubalmacen});">
                            ${nombre + ' (' + fase + ') ' + destino}
                        </span>
                    `;
                    dataSubalmacenes.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(function () {
            fetch(URL2)
                .then(array => array.json())
                .then(array => {
                    if (array.length > 0) {
                        datosComplementariosUsuario.classList.remove('hidden');
                        for (let x = 0; x < array.length; x++) {
                            const idUsuario = array[x].idUsuario;
                            const usuario = array[x].usuario;
                            const contraseña = array[x].contraseña;
                            const nombre = array[x].nombre;
                            const apellido = array[x].apellido;
                            const correo = array[x].correo;
                            const telefono = array[x].telefono;
                            const fase = array[x].fase;
                            const idFase = array[x].idFase;
                            const idStatus = array[x].idStatus;
                            const status = array[x].status;
                            const idDestinoX = array[x].idDestino;
                            const destino = array[x].destino;
                            const idCargo = array[x].idCargo;
                            const cargo = array[x].cargo;
                            const idRol = array[x].idRol;
                            const rol = array[x].rol;
                            const entradas = array[x].entradas;
                            const salidas = array[x].salidas;
                            const importar = array[x].importar;
                            const subalmacenes = array[x].subalmacenes;
                            const secciones = array[x].secciones;


                            nombreX.value = nombre;
                            apellidoX.value = apellido;
                            correoX.value = correo;
                            telefonoX.value = telefono;
                            usuarioX.value = usuario;
                            contraseñaX.value = contraseña;

                            // SECCIONES
                            if (secciones.length > 0) {
                                for (let x = 0; x < secciones.length; x++) {
                                    const seccion = secciones[x].seccion;
                                    const valor = secciones[x].valor;

                                    if (valor == 1 && document.getElementById("seccion_" + seccion)) {
                                        document.getElementById("seccion_" + seccion).innerHTML = seccion + check;
                                    }
                                }
                            }

                            // FASE
                            if (document.getElementById("fase_" + idFase)) {
                                document.getElementById("fase_" + idFase).innerHTML = fase + check;
                            }

                            // DESTINO
                            if (document.getElementById("destino_" + idDestinoX)) {
                                document.getElementById("destino_" + idDestinoX).
                                    innerHTML = destino + check;
                            }

                            // CARGO
                            if (document.getElementById("cargo_" + idCargo)) {
                                document.getElementById("cargo_" + idCargo).
                                    innerHTML = cargo + check;
                            }

                            // ROL
                            if (document.getElementById("rol_" + idRol)) {
                                document.getElementById("rol_" + idRol).
                                    innerHTML = rol + check;
                            }

                            // STATUS
                            if (document.getElementById("status_" + idStatus)) {
                                document.getElementById("status_" + idStatus).
                                    innerHTML = status + check;
                            }

                            // PERMISOS SUBALMACENES
                            if (
                                entradas == 1 &&
                                document.getElementById("opcionSubalmacen_entradas_sa")
                            ) {
                                document.getElementById("opcionSubalmacen_entradas_sa").
                                    innerHTML = 'Entradas ' + check;
                            }

                            if (
                                salidas == 1 &&
                                document.getElementById("opcionSubalmacen_salidas_sa")
                            ) {
                                document.getElementById("opcionSubalmacen_salidas_sa").
                                    innerHTML = 'Salidas ' + check;
                            }

                            if (
                                importar == 1 &&
                                document.getElementById("opcionSubalmacen_importar_gastos")
                            ) {
                                document.getElementById("opcionSubalmacen_importar_gastos").
                                    innerHTML = 'Importar' + check;
                            }

                            if (subalmacenes.length > 0) {
                                for (let x = 0; x < subalmacenes.length; x++) {
                                    const idSubalmacen = subalmacenes[x].idSubalmacen;
                                    const subalmacen = subalmacenes[x].subalmacen;
                                    if (document.getElementById("subalmacen_" + idSubalmacen)) {
                                        document.getElementById("subalmacen_" + idSubalmacen).
                                            innerHTML = subalmacen + check;
                                    }
                                }
                            }
                        }
                    }
                })
                .catch(function (err) {
                    fetch(APIERROR + err + ` obtenerUsuariosX(${configuracionIdUsuario})`);
                })

        })
        .catch(function (err) {
            fetch(APIERROR + err + ` obtenerUsuariosX(${configuracionIdUsuario})`);
        })
}


// ACTUALIZA USUARIO
function actualizarUsuario(configuracionIdUsuario) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let modal = document.getElementById('modalEditarUsuario');

    // INPUTS
    let nombre = document.getElementById('nombreUsuario').value;
    let apellido = document.getElementById('apellidoUsuario').value;
    let correo = document.getElementById('correoUsuario').value;
    let telefono = document.getElementById('telefonoUsuario').value;
    let usuario = document.getElementById('usuarioUsuario').value;
    let contraseña = document.getElementById('contraseñaUsuario').value;
    // INPUTS

    const action = "actualizarUsuario";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&configuracionIdUsuario=${configuracionIdUsuario}&nombre=${nombre}&apellido=${apellido}&correo=${correo}&telefono=${telefono}&usuario=${usuario}&contraseña=${contraseña}`;
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array == "1") {
                alertaImg('Usuario Agregado', '', 'success', 1200);
                obtenerUsuarios(configuracionIdUsuario);
                modal.classList.remove('open');
            } else if (array == "EXISTENTE") {
                alertaImg('Usuario No Disponible', '', 'error', 1200);
            } else if (array == "2") {
                alertaImg('Usuario Actualizado', '', 'success', 1200);
                obtenerUsuarios(configuracionIdUsuario);
                modal.classList.remove('open');
            } else if (array == "3") {
                alertaImg('Compruebe los Datos', '', 'info', 1200);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
                obtenerUsuarios(configuracionIdUsuario);
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err + ` actualizarUsuario(${configuracionIdUsuario})`);
        })
}


// FUNCION PARA ACTUALIZAR OPCIONES ADICIONALES DE USUARIOX
function actualizaUsuarioOpciones(idUsuarioX, columna, valor) {

    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "actualizaUsuarioOpciones";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idUsuarioX=${idUsuarioX}&columna=${columna}&valor=${valor}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            obtenerUsuariosX(idUsuarioX);
            obtenerUsuarios(idUsuarioX);
            if (array == 1) {
                alertaImg('Fase Actualizada', '', 'success', 1200);
            } else if (array == 2) {
                alertaImg('Sección Actualizada', '', 'success', 1200);
            } else if (array == 3) {
                alertaImg('Destino Actualizado', '', 'success', 1200);
            } else if (array == 4) {
                alertaImg('Cargo Actualizado', '', 'success', 1200);
            } else if (array == 5) {
                alertaImg('Rol Actualizado', '', 'success', 1200);
            } else if (array == 6) {
                alertaImg('Status Actualizado', '', 'success', 1200);
            } else if (array == 7) {
                alertaImg('Opcion Subalmacen Actualizado', '', 'success', 1200);
            } else if (array == 8) {
                alertaImg('Permisos Subalmacen Actualizado', '', 'success', 1200);
            } else if (array == 9) {
                alertaImg('Subalmacen Actualizado', '', 'success', 1200);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err + ` actualizaUsuarioOpciones(${idUsuarioX}, ${columna}, ${valor})`);
        })
}


// FUNCIÓN PARA OBTENER LOS CARGOS
function obtenerCargos(idCargo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let tablaCargos = document.getElementById("dataTablaCargos");
    let load = document.getElementById("loadCargos");
    const action = "obtenerCargos";

    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idCargo=${idCargo}`;
    load.innerHTML = iconSpin;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            tablaCargos.innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const y = array[x];
                    const codigo = codigoCargo({ y });
                    tablaCargos.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(() => {
            load.innerHTML = '';
        })
        .catch(function (err) {
            fetch(APIERROR + err + ' URL: ' + URL);
            tablaCargos.innerHTML = '';
            load.innerHTML = '';
        })
}


// FUNCIÓN PARA OBTENER LOS CARGOS
function obtenerCargosX(idCargo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let cargo = document.getElementById("inputCargo");
    let status = document.getElementById("statusCargo");
    let btn = document.getElementById("btnGuardarCargo");
    const action = "obtenerCargos";
    btn.setAttribute("onclick", `actualizarCargo(${idCargo})`);
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idCargo=${idCargo}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array.length > 0) {
                cargo.value = array[0].cargo;
                status.value = array[0].status;
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err + ' URL: ' + URL);
        })
}


// ACTUALIZA CARGO O AGREGA SI EL PARAMETRO ES CERO 0
function actualizarCargo(idCargo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let cargo = document.getElementById("inputCargo").value;
    let status = document.getElementById("statusCargo").value;
    const action = "actualizarCargo";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idCargo=${idCargo}&cargo=${cargo}&status=${status}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            obtenerCargos(0);
            document.getElementById("modalEditarCargos").classList.remove("open");
            if (array == 1) {
                alertaImg('Cargo Actualizado', '', 'success', 1200);
            } else if (array == 2) {
                alertaImg('Cargo Agregado', '', 'success', 1200);
            } else if (array == 0) {
                alertaImg('Datos Incorrectos', '', 'info', 1200);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


// FUNCIÓN PARA MOSTRAR CONTRASEÑA
document.getElementById('contraseñaEyes').addEventListener('click', function () {
    if (document.getElementById("contraseñaUsuario")) {
        let contraseña = document.getElementById("contraseñaUsuario");
        let icon = document.getElementById("contraseñaEyes");

        if (contraseña.getAttribute("type") == "text") {
            contraseña.setAttribute("type", "password");
            icon.className = "fa far fa-eye-slash p-2 mx-2";
        } else {
            contraseña.setAttribute("type", "text");
            icon.className = "fa far fa-eye p-2 mx-2";
        }
    }
});


// FUNCIÓN PARA CHECK DE NOTIFICACIONES
document.getElementById('checkNotificaciones').addEventListener('click', function () {
    if (document.getElementById("checkNotificaciones")) {
        let icon = document.getElementById("checkNotificaciones");

        if (icon.classList.contains("fa-toggle-on")) {
            icon.className = "fad fa-toggle-off fa-2x px-2 mx-2 text-center text-red-400";
            alertaImg('Notificaciones Desactivadas', '', 'info', 1000);
        } else {
            icon.className = "fad fa-toggle-on fa-2x px-2 mx-2 text-center text-blue-400";
            alertaImg('Notificaciones Actividadas', '', 'success', 1000);
        }
    }
});


// COMPROBACIÓN DE CORREO
document.getElementById("correoUsuario").addEventListener('keyup', function () {
    let valor = document.getElementById("correoUsuario").value;
    let label = document.getElementById("labelCorreoUsuario");
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (regex.test(valor)) {
        label.innerText = '';
    } else {
        label.innerHTML = '<span class="text-red-500 text-sm">Correo No Valido</div>';
    }
})


function hotelRM() {

    alertify.Gift || alertify.dialog('Gift', function () {
        var iframe;
        return {
            // dialog constructor function, this will be called when the user calls alertify.Gift(videoId)
            main: function (videoId) {
                //set the videoId setting and return current instance for chaining.
                return this.set({
                    'videoId': videoId
                });
            },
            // we only want to override two options (padding and overflow).
            setup: function () {
                return {
                    options: {
                        //disable both padding and overflow control.
                        padding: !1,
                        overflow: !1,
                    }
                };
            },
            // This will be called once the DOM is ready and will never be invoked again.
            // Here we create the iframe to embed the video.
            build: function () {
                // create the iframe element
                iframe = document.createElement('iframe');
                iframe.frameBorder = "no";
                iframe.width = "100%";
                iframe.height = "100%";
                // add it to the dialog
                this.elements.content.appendChild(iframe);

                //give the dialog initial height (half the screen height).
                this.elements.body.style.minHeight = screen.height * .5 + 'px';
            },
            // dialog custom settings
            settings: {
                videoId: undefined
            },
            // listen and respond to changes in dialog settings.
            settingUpdated: function (key, oldValue, newValue) {
                switch (key) {
                    case 'videoId':
                        iframe.src = "www.google.com/";
                        break;
                }
            },
            hooks: {
                // triggered when the dialog is closed, this is seperate from user defined onclose
                onclose: function () {
                    iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                },
                // triggered when a dialog option gets update.
                // warning! this will not be triggered for settings updates.
                onupdate: function (option, oldValue, newValue) {
                    switch (option) {
                        case 'resizable':
                            if (newValue) {
                                this.elements.content.removeAttribute('style');
                                iframe && iframe.removeAttribute('style');
                            } else {
                                this.elements.content.style.minHeight = 'inherit';
                                iframe && (iframe.style.minHeight = 'inherit');
                            }
                            break;
                    }
                }
            }
        };
    });
    //show the dialog
    alertify.Gift('GODhPuM5cEE').set({ frameless: true });
}


// BUSCAR USUARIO EN LA TABLA
document.getElementById("palabraUsuario").addEventListener('keyup', function () {
    buscadorTabla('dataUsuarios', 'palabraUsuario', 1);
})


// BUSCAR CARGOS EN LA TABLA
document.getElementById("palabraCargos").addEventListener('keyup', function () {
    buscadorTabla('dataTablaCargos', 'palabraCargos', 1);
})


// OPCIÓN PARA AGREGAR UN NUEVO USUARIO
document.getElementById("btnNuevoUsuario").addEventListener('click', function () {
    document.getElementById("datosComplementariosUsuario").classList.add('hidden');
    abrirmodal('modalEditarUsuario');

    // INPUTS
    document.getElementById('nombreUsuario').value = '';
    document.getElementById('apellidoUsuario').value = '';
    document.getElementById('correoUsuario').value = '';
    document.getElementById('telefonoUsuario').value = '';
    document.getElementById('usuarioUsuario').value = '';
    document.getElementById('contraseñaUsuario').value = '';
    // INPUTS

    document.getElementById("btnGuardarUsuario").
        setAttribute('onclick', "actualizarUsuario(0);");
})


// OCULTAS TODAS LAS OPCIONES
function ocultarOpciones(elementoMostrar) {
    let array = ["gestionUsuarios", "cargosUsuarios"];

    for (let x = 0; x < array.length; x++) {
        const elementoOcultar = array[x];
        if (document.getElementById(elementoOcultar) && elementoOcultar != elementoMostrar) {
            document.getElementById(elementoOcultar).classList.add('hidden');
        } else {
            document.getElementById(elementoOcultar).classList.remove('hidden');
        }
    }
}


// FUNCIONES GENERICAS
function toggleHidden(elemento) {
    if (document.getElementById(elemento)) {
        document.getElementById(elemento).classList.toggle('hidden');
    }
}


// EVENTOS GENERALES
document.getElementById("btnConfiguraciones").addEventListener("click", () => {
    toggleHidden('menuConfiguraciones');

    let columna2 = document.getElementById("columna2");
    let menuConfiguraciones = document.getElementById("menuConfiguraciones");

    if (menuConfiguraciones.classList.contains('hidden')) {
        columna2.className = "mx-auto";
    } else {
        columna2.className = "w-10/12 mx-auto";
    }
})


// OPCIÓN GESTIÓN USUARIOS
document.getElementById("btnGestionUsuarios").addEventListener("click", async function () {
    await ocultarOpciones('gestionUsuarios');
    await obtenerUsuarios();
})

// OPCIÓN CARGOS
document.getElementById("btnGestionCargos").addEventListener("click", async function () {
    await ocultarOpciones('cargosUsuarios');
    await obtenerCargos(0);
})

// OPCIÓN PARA REGRESAR A WWW.MAPHG.COM
document.getElementById("btnSalir").addEventListener("click", function () {
    window.location = "https://www.maphg.com/beta/planner-cols.php";
})


// ASIGNA VALORES PARA CREAR UN NUEVO CARGO
document.getElementById("btnNuevoCargo").addEventListener("click", function () {
    let btn = document.getElementById("btnGuardarCargo")
    btn.setAttribute("onclick", 'actualizarCargo(0)');
    document.getElementById("modalEditarCargos").classList.add("open");
})


// MUESTRA DATOS DESPUES DE CARGA COMPLETA DE LA PAGINA
window.onload = function () {
    obtenerUsuarios(0);
}