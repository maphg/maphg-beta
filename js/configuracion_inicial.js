// VARIABLES GLOBALES
const iconoLoader = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

// INPUTS
const inputTipoActivoLocal = document.getElementById("inputTipoActivoLocal");
const inputTipoActivoEquipo = document.getElementById("inputTipoActivoEquipo");
const palabraUsuario = document.getElementById("palabraUsuario");
const inputSubalmacenGP = document.getElementById("inputSubalmacenGP");
const inputSubalmacenTRS = document.getElementById("inputSubalmacenTRS");
const inputSubalmacenZI = document.getElementById("inputSubalmacenZI");
const inputTipoSubalmacenGP = document.getElementById("inputTipoSubalmacenGP");
const inputTipoSubalmacenTRS = document.getElementById("inputTipoSubalmacenTRS");
const inputTipoSubalmacenZI = document.getElementById("inputTipoSubalmacenZI");
// INPUTS

// BTNS
const btnSeccionSubseccion = document.getElementById("btnSeccionSubseccion");
const btnTiposActivos = document.getElementById("btnTiposActivos");
const btnAgregarTipoActivoLocal = document.getElementById("btnAgregarTipoActivoLocal");
const btnAgregarTipoActivoEquipo = document.getElementById("btnAgregarTipoActivoEquipo");
const btnGestionUsuarios = document.getElementById("btnGestionUsuarios");
const btnNuevoUsuario = document.getElementById("btnNuevoUsuario");
const contraseñaEyes = document.getElementById("contraseñaEyes");
const btnSubalmacenes = document.getElementById("btnSubalmacenes");
const btnAgregarSubalmacenGP = document.getElementById("btnAgregarSubalmacenGP");
const btnAgregarSubalmacenTRS = document.getElementById("btnAgregarSubalmacenTRS");
const btnAgregarSubalmacenZI = document.getElementById("btnAgregarSubalmacenZI");
// BTNS

// DIVs
const nombreDestino = document.getElementById("nombreDestino");
const totalUsuarios = document.getElementById("totalUsuarios");
const totalSubsecciones = document.getElementById("totalSubsecciones");
const totalTipos = document.getElementById("totalTipos");
const totalBodegas = document.getElementById("totalBodegas");
const totalMateriales = document.getElementById("totalMateriales");
const totalEquipos = document.getElementById("totalEquipos");
const totalPlanes = document.getElementById("totalPlanes");
// DIVs

// CONTENEDORES
const contenedorUsuarios = document.getElementById("contenedorUsuarios");
const dataSubalmacenesGP = document.getElementById("dataSubalmacenesGP");
const dataSubalmacenesTRS = document.getElementById("dataSubalmacenesTRS");
const dataSubalmacenesZI = document.getElementById("dataSubalmacenesZI");
// CONTENEDORES

// DATA CONTENEDORES
const dataSeccionesSubsecciones = document.getElementById("dataSeccionesSubsecciones");
const dataTiposActivosEquipos = document.getElementById("dataTiposActivosEquipos");
const dataTiposActivosLocales = document.getElementById("dataTiposActivosLocales");
// DATA CONTENEDORES


// FUNCION PARA ABRIR MODAL
const abrirmodal = idModal => {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.add('open');
    }
}


// FUNCION PARA ABRIR MODAL
const cerrarmodal = idModal => {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.remove('open');
    }
}


// FUNCIONES GENERICAS
const toggleHidden = elemento => {
    if (document.getElementById(elemento)) {
        document.getElementById(elemento).classList.toggle('hidden');
    }
}


// OBTIENE DATOS DE INFORMACIÓN INICIAL
const datosIniciales = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    // FUNCIONALIDADES INICIALES
    nombreDestino.innerHTML = iconoLoader;
    totalUsuarios.innerHTML = iconoLoader;
    totalSubsecciones.innerHTML = iconoLoader;
    totalTipos.innerHTML = iconoLoader;
    totalBodegas.innerHTML = iconoLoader;
    totalMateriales.innerHTML = iconoLoader;
    totalEquipos.innerHTML = iconoLoader;
    totalPlanes.innerHTML = iconoLoader;

    const action = "datosIniciales";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            const classRemove = ['border-dashed', 'border-purple-100', 'border-purple-300'];
            const classadd = ['border-purple-700'];
            const contenedores = ['contenedor-usuarios', 'contenedor-subsecciones', 'contenedor-tipos', 'contenedor-subalmacenes', 'contenedor-materiales', 'contenedor-equipos', 'contenedor-planes'];

            const ok = `
                <p class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 -mt-4 -mr-4 font-bold rounded-full bg-purple-400 sm:-mt-5 sm:-mr-5 sm:w-10 sm:h-10">
                    <svg class="text-white w-7" stroke="currentColor" viewBox="0 0 24 24">
                        <polyline fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            stroke-miterlimit="10" points="6,12 10,16 18,8"></polyline>
                    </svg>
                </p>            
            `;

            if (array) {
                nombreDestino.innerHTML = array.destino;

                // USUARIOS
                if (array.usuarios >= 0) {
                    totalUsuarios.innerHTML = array.usuarios;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[0]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-usuarios')[x];
                        if (array.usuarios > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // SUBSECCIONES
                if (array.subsecciones >= 0) {
                    totalSubsecciones.innerHTML = array.subsecciones;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[1]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-subsecciones')[x];
                        if (array.subsecciones > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // TIPOS
                if (array.tipos >= 0) {
                    totalTipos.innerHTML = array.tipos;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[2]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-tipos')[x];
                        if (array.tipos > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // BODEGAS
                if (array.bodegas >= 0) {
                    totalBodegas.innerHTML = array.bodegas;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[3]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-subalmacenes')[x];
                        if (array.bodegas > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // MATERIALES
                if (array.materiales >= 0) {
                    totalMateriales.innerHTML = array.materiales;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[4]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-materiales')[x];
                        if (array.materiales > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // EQUIPOS
                if (array.equipos >= 0) {
                    totalEquipos.innerHTML = array.equipos;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[5]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-equipos')[x];
                        if (array.equipos > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

                // PLANES
                if (array.planes >= 0) {
                    totalPlanes.innerHTML = array.planes;
                    for (let x = 0; x < document.getElementsByClassName(contenedores[6]).length; x++) {
                        const element = document.getElementsByClassName('contenedor-planes')[x];
                        if (array.planes > 0) {
                            element.classList.remove(classRemove[0], classRemove[1], classRemove[2]);
                            element.classList.add(classadd[0]);
                        } else {
                            element.classList.add(classRemove[0], classRemove[1]);
                            element.classList.remove(classadd[0]);
                        }
                    }
                }

            }
        })
        .catch(function (err) {
            nombreDestino.innerHTML = '';
            totalSubsecciones.innerText = 0;
            totalTipos.innerText = 0;
            totalBodegas.innerText = 0;
            totalMateriales.innerText = 0;
            totalEquipos.innerText = 0;
            totalPlanes.innerText = 0;
        })

}


// EVENTO PARA MOSTRAR MODAL DE SECCIONES SUBSECCIONES
btnSeccionSubseccion.addEventListener("click", () => {
    abrirmodal('modalSeccionesSubsecciones');
    obtenerSeccionesSubsecciones();
})


// OBTIENE LAS SECCIONES Y SUBSECCIONES RELACIONADAS POR DESTINO
const obtenerSeccionesSubsecciones = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSeccionesSubsecciones";
    const URL =
        `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSeccionesSubsecciones.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array.secciones) {
                for (let x = 0; x < array.secciones.length; x++) {
                    const idRelSeccion = array.secciones[x].idRelSeccion;
                    const idSeccion = array.secciones[x].idSeccion;
                    const destino = array.secciones[x].destino;
                    const seccion = array.secciones[x].seccion;
                    const codigo = `
                        <div class="bg-white m-3 flex flex-col justify-start items-center rounded-lg w-48 shadow-sm relative" style="max-height:270px; height: 250px">

                            <div class="w-full font-bold text-center text-xl bg-black text-white rounded-t-md tracking-widest">
                            ${seccion}
                        </div>
                        <div class="divide-y divide-gray-300 w-full text-xxs relative">
                            <div class="flex flex-row items-center justify-center px-1 py-2 bg-blue-200">
                                <input id="inputSeccionSubseccion_${idSeccion}" type="text" placeholder="Nueva Subsección (${seccion})"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md px-1 py-1" autocomplete="off">
                                    <i class="fa fas fa-plus-circle fa-3x text-blue-400 hover:text-blue-700 ml-1 cursor-pointer" onclick="agregarSeccionSubseccion(${idRelSeccion}, ${idSeccion})"></i>
                                                        </div>
                                <div id="dataSeccionesSubsecciones_${idSeccion}" class="w-full overflow-y-auto scrollbar" style="max-height: 170px;"></div>
                            </div>
                        </div>
                            `;
                    dataSeccionesSubsecciones.insertAdjacentHTML('beforeend', codigo);
                }
            }

            if (array.subsecciones) {
                for (let x = 0; x < array.subsecciones.length; x++) {
                    const idRelSubseccion = array.subsecciones[x].idRelSubseccion;
                    const idSeccion = array.subsecciones[x].idSeccion;
                    const subseccion = array.subsecciones[x].subseccion;

                    const codigo = `
                        <div class="p-2 w-full cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                            <h1 class="truncate mr-2">${subseccion}</h1>
                            <div class="flex flex-row justify-center"
                                onclick="eliminarSeccionSubseccion(${idRelSubseccion});">
                                <i class="fa fas fa-trash-alt fa-2x text-red-300 hover:text-red-500"></i>
                            </div>
                        </div>
                    `;
                    if (document.getElementById("dataSeccionesSubsecciones_" + idSeccion)) {
                        document.getElementById("dataSeccionesSubsecciones_" + idSeccion).
                            insertAdjacentHTML('beforeend', codigo);
                    }
                }
            }
        })
        .catch(function (error) {
            dataSeccionesSubsecciones.innerHTML = '';
            const pagina = 'configuracion_inicial';
            fetch(
                `php/reporteError.php?action=reporteError&error=${error}&pagina=${pagina}&funcion=obtenerSeccionesSubsecciones`
            )
        })
}


// ELIMINA LA RELACION DE SECCION SUBSECCIONES
const eliminarSeccionSubseccion = idRelSubseccion => {
    alertify.confirm('MAPHG', '¿Desea Eliminar Subsección?', function () {
        let idDestino = localStorage.getItem('idDestino');
        let idUsuario = localStorage.getItem('usuario');

        const action = "eliminarSeccionSubseccion";
        const URL =
            `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idRelSubseccion=${idRelSubseccion}`;

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                obtenerSeccionesSubsecciones();
                if (array == 1) {
                    alertaImg('Subseccion Eliminada', '', 'success', 1400)
                    datosIniciales()
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1400)
                }
            })
            .catch(function (err) {
            })
    }, function () {
        alertaImg('Proceso Cancelado', '', 'info', 1400)
    })
}


// AGREGA LA RELACION DE SECCION SUBSECCIONES
const agregarSeccionSubseccion = (idRelSeccion, idSeccion) => {
    alertify.confirm('MAPHG', '¿Desea Agregar Subsección?', function () {

        let idDestino = localStorage.getItem('idDestino');
        let idUsuario = localStorage.getItem('usuario');

        let subseccion = document.getElementById("inputSeccionSubseccion_" + idSeccion).value;
        const action = "agregarSeccionSubseccion";
        const URL =
            `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idRelSeccion=${idRelSeccion}&idSeccion=${idSeccion}&subseccion=${subseccion}`;

        if (subseccion != "") {
            fetch(URL)
                .then(array => array.json())
                .then(array => {
                    obtenerSeccionesSubsecciones();
                    if (array == 1) {
                        alertaImg('Subseccion Agregada', '', 'success', 1400)
                        document.getElementById("inputSeccionSubseccion_" + idSeccion).value = '';
                        datosIniciales()
                    } else {
                        alertaImg('Intente de Nuevo', '', 'info', 1400)
                    }
                })
                .catch(function (err) {
                })
        }
    }, function () {
        alertaImg('Proceso Cancelado', '', 'info', 1400)
    });
}


// EVENTO PARA MOSTRAR MODAL DE TIPOS DE ACTIVOS
btnTiposActivos.addEventListener("click", () => {
    abrirmodal('modalTiposActivos');
    obtenerTiposActivos();
})


// OBTIENE LOS TIPOS ACTIVOS
const obtenerTiposActivos = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerTiposActivos";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataTiposActivosEquipos.innerHTML = '';
            dataTiposActivosLocales.innerHTML = '';
            btnAgregarTipoActivoLocal.setAttribute("onclick", "agregarTipoActivo('LOCAL')");
            btnAgregarTipoActivoEquipo.setAttribute("onclick", "agregarTipoActivo('EQUIPO')");

            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idTipo = array[x].idTipo;
                    const tipo = array[x].tipo;
                    const tipoActivo = array[x].tipoActivo;
                    const codigo = `
                        <div class="p-2 w-full cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                            <h1 class="truncate mr-2">${tipo}</h1>
                            <div class="flex flex-row justify-center"
                                onclick="eliminarTipoActivo(${idTipo});">
                                <i class="fa fas fa-trash-alt fa-2x text-red-300 hover:text-red-500"></i>
                            </div>
                        </div>
                    `;

                    if (tipoActivo == "EQUIPO") {
                        dataTiposActivosEquipos.insertAdjacentHTML('beforeend', codigo);
                    } else {
                        dataTiposActivosLocales.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


// AGREGA TIPO ACTIVO LOCAL
const agregarTipoActivo = tipoActivo => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    let tipo = '';
    if (tipoActivo == "LOCAL") {
        tipo = inputTipoActivoLocal.value;
    } else {
        tipo = inputTipoActivoEquipo.value;
    }

    const action = "agregarTipoActivo";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&tipoActivo=${tipoActivo}&tipo=${tipo}`;

    alertify.confirm('MAPHG', `¿Desea Agregar, Tipo de Activo (${tipoActivo})?`, function () {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                obtenerTiposActivos();
                if (array == 1) {
                    alertaImg('Tipo Activo, Agregado', '', 'success', 1400);
                    datosIniciales()
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1400);
                }
                if (tipoActivo == "LOCAL") {
                    inputTipoActivoLocal.value = '';
                } else {
                    inputTipoActivoEquipo.value = '';
                }
            })
            .catch(function (err) {
            })
    }, function () {
        alertaImg('Proceso Cancelado', '', 'info', 1400)
    });
}


// ELIMINA LOS TIPOS DE ACTIVOS
const eliminarTipoActivo = idTipo => {

    alertify.confirm('MAPHG', '¿Desea Eliminar, Tipo de Activo?', function () {
        let idDestino = localStorage.getItem('idDestino');
        let idUsuario = localStorage.getItem('usuario');

        const action = "eliminarTipoActivo";
        const URL =
            `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTipo=${idTipo}`;

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                obtenerTiposActivos();
                if (array == 1) {
                    alertaImg('Tipo Activo Eliminado', '', 'success', 1400)
                    datosIniciales()
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1400)
                }
            })
            .catch(function (err) {
            })
    }, function () {
        alertaImg('Proceso Cancelado', '', 'info', 1400)
    });
}


// GESTION DE USUARIOS
btnGestionUsuarios.addEventListener("click", () => {
    obtenerUsuarios();
    abrirmodal('modalUsuarios');
})


// GENERA HTML FILA DE USUARIO
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


// FUNCIÓN PARA OBTENER TODOS LOS USUARIOS SEGÚN DESTINO
const obtenerUsuarios = configuracionIdUsuario => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerUsuarios";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&configuracionIdUsuario=${configuracionIdUsuario}`;

    let load = document.getElementById("load");

    load.innerHTML = iconoLoader;
    if (configuracionIdUsuario > 0) {
        tablaUsuarios = document.getElementById("usuario_" + configuracionIdUsuario);
    } else {
        tablaUsuarios = document.getElementById("dataUsuarios");
    }
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            tablaUsuarios.innerHTML = "";
            if (array) {
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
                palabraUsuario.value = '';
            }, 1200);
        })
        .catch(function (err) {
            // fetch(APIERROR + err + ' obtenerUsuarios(0)');
            load.innerHTML = '';
            palabraUsuario.value = '';
        })
}


// OPCIÓN PARA AGREGAR UN NUEVO USUARIO
btnNuevoUsuario.addEventListener('click', () => {
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


// ACTUALIZA USUARIO
const actualizarUsuario = configuracionIdUsuario => {
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
                datosIniciales();
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


// OBTIENE CONFIGURACIONES DEL USUARIO SELECCIONADO
const obtenerUsuariosX = configuracionIdUsuario => {
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
    contraseñaEyes.className = "fa far fa-eye-slash p-2 mx-2";
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
            if (array.fases) {
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
            if (array.secciones) {
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
            if (array.destinos) {
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
            if (array.cargos) {
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
            if (array.roles) {
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
            if (array.status) {
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
            if (array.opcionSubalmacenes) {
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
            if (array.subalmacenes) {
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
                    if (array) {
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
                            if (secciones) {
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

                            if (subalmacenes) {
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


// FUNCION PARA ACTUALIZAR OPCIONES ADICIONALES DE USUARIOX
const actualizaUsuarioOpciones = (idUsuarioX, columna, valor) => {

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


// FUNCIÓN PARA MOSTRAR CONTRASEÑA
contraseñaEyes.addEventListener('click', () => {
    if (document.getElementById("contraseñaUsuario")) {
        let contraseña = document.getElementById("contraseñaUsuario");

        if (contraseña.getAttribute("type") == "text") {
            contraseña.setAttribute("type", "password");
            contraseñaEyes.className = "fa far fa-eye-slash p-2 mx-2";
        } else {
            contraseña.setAttribute("type", "text");
            contraseñaEyes.className = "fa far fa-eye p-2 mx-2";
        }
    }
})


// BUSCAR USUARIO EN LA TABLA
palabraUsuario.addEventListener('keyup', function () {
    buscadorTabla('dataUsuarios', 'palabraUsuario', 1);
})


// OBTIENES LOS SUBALMACENES Y BODEGAS
btnSubalmacenes.addEventListener('click', () => {
    abrirmodal('modalSubalmacenes');

    btnAgregarSubalmacenGP.setAttribute('onclick', `agregarSubalmacen('GP')`);
    btnAgregarSubalmacenTRS.setAttribute('onclick', `agregarSubalmacen('TRS')`);
    btnAgregarSubalmacenZI.setAttribute('onclick', `agregarSubalmacen('ZI')`);

    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSubalmacenes";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSubalmacenesGP.innerHTML = '';
            dataSubalmacenesTRS.innerHTML = '';
            dataSubalmacenesZI.innerHTML = '';

            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idSubalmacen = array[x].idSubalmacen;
                    const nombre = array[x].nombre;
                    const tipo = array[x].tipo;
                    const fase = array[x].fase;

                    const estiloTipo = tipo == "BODEGA" ? 'text-blue-500 text-xs hover:text-black'
                        : tipo == 'SUBALMACEN' ? 'text-gray-500 text-xs hover:text-black'
                            : 'text-red-500 text-xs hover:text-black';

                    const codigo = `
                        <div class="p-2 w-full cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                            <h1 class="truncate mr-2 font-semibold ${estiloTipo}">${nombre}</h1>
                            <div class="flex flex-row justify-center" onclick="eliminarSubalmacen(${idSubalmacen});">
                                <i class="fa fas fa-trash-alt fa-2x text-red-300 hover:text-red-500"></i>
                            </div>
                        </div>
                    `;

                    fase === "GP" ?
                        dataSubalmacenesGP.insertAdjacentHTML('beforeend', codigo)
                        : fase === "TRS" ?
                            dataSubalmacenesTRS.insertAdjacentHTML('beforeend', codigo)
                            : fase === "ZI" ?
                                dataSubalmacenesZI.insertAdjacentHTML('beforeend', codigo)
                                : '';
                }
            }
        })
        .catch(function (err) {
            // fetch(APIERROR + err);
            dataSubalmacenesGP.innerHTML = '';
            dataSubalmacenesTRS.innerHTML = '';
            dataSubalmacenesZI.innerHTML = '';
        })
})


// ELIMINA LAS SUBALMACENES Y BODEGAS
const eliminarSubalmacen = idSubalmacen => {

    alertify.confirm('MAPHG', '¿Desea Eliminar Subalmacen?', function () {
        let idDestino = localStorage.getItem('idDestino');
        let idUsuario = localStorage.getItem('usuario');

        const action = "eliminarSubalmacen";
        const URL =
            `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSubalmacen=${idSubalmacen}`;

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                obtenerTiposActivos();
                if (array == 1) {
                    alertaImg('Subalmacen Eliminado', '', 'success', 1400)
                    btnSubalmacenes.click();
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1400)
                }
            })
            .catch(function (err) {
            })
    }, function () {
        alertaImg('Proceso Cancelado', '', 'info', 1400)
    });
}

// AGREGAR SUBALMACENES
const agregarSubalmacen = fase => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const subalmacen =
        fase === 'GP' ? inputSubalmacenGP.value
            : fase === 'TRS' ? inputSubalmacenTRS.value
                : fase === 'ZI' ? inputSubalmacenZI.value
                    : '';
    const tipo =
        fase === 'GP' ? inputTipoSubalmacenGP.value
            : fase === 'TRS' ? inputTipoSubalmacenTRS.value
                : fase === 'ZI' ? inputTipoSubalmacenZI.value
                    : '';

    const action = "agregarSubalmacen";
    const URL = `php/gestion_configuraciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&fase=${fase}&subalmacen=${subalmacen}&tipo=${tipo}`;

    if (tipo.length > 1 && subalmacen.length > 1 && fase.length > 1) {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg(`${tipo}, Agregado`, '', 'success', 1400);
                    btnSubalmacenes.click();
                    inputSubalmacenGP.value = '';
                    inputSubalmacenTRS.value = '';
                    inputSubalmacenZI.value = '';
                    inputTipoSubalmacenGP.value = '';
                    inputTipoSubalmacenTRS.value = '';
                    inputTipoSubalmacenZI.value = '';
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1400);
                }
            })
            .catch(function (err) {
                inputSubalmacenGP.value = '';
                inputSubalmacenTRS.value = '';
                inputSubalmacenZI.value = '';
                inputTipoSubalmacenGP.value = '';
                inputTipoSubalmacenTRS.value = '';
                inputTipoSubalmacenZI.value = '';
            })
    } else {
        alertaImg('Acomplete la Información Requerida', '', 'info', 1400);
    }
}


window.addEventListener('load', () => {
    datosIniciales();
})