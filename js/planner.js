// CAMBIA LA VISTA DE OPCIONES SEGÚN LA OPCIÓN SELECCIONADA
selectMoverOpcion.addEventListener('change', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSeccionesPorDestino";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            selectMoverSeccion.innerHTML = '<option value="">Seleccione Sección</option>';
            selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
            selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
            selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';

            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idSeccion = array[x].idSeccion;
                    const seccion = array[x].seccion;
                    const codigo = `<option value="${idSeccion}">${seccion}</option>`;

                    selectMoverSeccion.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            selectMoverSeccion.innerHTML = '<option value="">Seleccione Sección</option>';
            selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
            selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
            selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';
            fetch(APIERROR + err);
        })

    opcionSelectsMover[0].classList.add('hidden');
    opcionSelectsMover[1].classList.add('hidden');
    opcionSelectsMover[2].classList.add('hidden');
    opcionSelectsMover[3].classList.add('hidden');
    opcionSelectsMover[4].classList.add('hidden');

    if (selectMoverOpcion.value === 'EQUIPO') {
        opcionSelectsMover[0].classList.remove('hidden');
        opcionSelectsMover[1].classList.remove('hidden');
        opcionSelectsMover[2].classList.remove('hidden');
        opcionSelectsMover[3].classList.add('hidden');
        opcionSelectsMover[4].classList.remove('hidden');
    } else if (selectMoverOpcion.value === "PROYECTO") {
        opcionSelectsMover[0].classList.remove('hidden');
        opcionSelectsMover[1].classList.remove('hidden');
        opcionSelectsMover[2].classList.add('hidden');
        opcionSelectsMover[3].classList.remove('hidden');
        opcionSelectsMover[4].classList.remove('hidden');
    } else {
        opcionSelectsMover[0].classList.remove('hidden');
        opcionSelectsMover[1].classList.remove('hidden');
        opcionSelectsMover[2].classList.add('hidden');
        opcionSelectsMover[3].classList.add('hidden');
        opcionSelectsMover[4].classList.remove('hidden');
    }

})


// OBTIENE LAS SUBSECCIONES SEGÚN SECCION
selectMoverSeccion.addEventListener('change', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSubseccionPorSeccion";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${selectMoverSeccion.value}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
            selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
            selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';

            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idSubseccion = array[x].idSubseccion;
                    const subseccion = array[x].subseccion;
                    const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;

                    selectMoverSubseccion.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
            selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
            selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';
            fetch(APIERROR + err);
        })
})


selectMoverSubseccion.addEventListener('change', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    if (selectMoverOpcion.value == "EQUIPO") {
        const action = "obtenerEquipoLocal";
        const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${selectMoverSeccion.value}&idSubseccion=${selectMoverSubseccion.value}&tipo=`;

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';

                return array;
            })
            .then(array => {
                if (array) {
                    for (let x = 0; x < array.length; x++) {
                        const idEquipo = array[x].idEquipo;
                        const equipo = array[x].equipo;
                        const codigo = `<option value="${idEquipo}">${equipo}</option>`;

                        selectMoverEquipo.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            })
            .catch(function (err) {
                selectMoverSeccion.innerHTML = '<option value="">Seleccione Sección</option>';
                selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
                selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';

                fetch(APIERROR + err);
            })
    } else if (selectMoverOpcion.value == "PROYECTO") {
        const action = "obtenerProyectosPorSeccionSubseccion";
        const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${selectMoverSeccion.value}&idSubseccion=${selectMoverSubseccion.value}&tipo=`;

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';
                return array;
            })
            .then(array => {
                if (array) {
                    for (let x = 0; x < array.length; x++) {
                        const idProyecto = array[x].idProyecto;
                        const proyecto = array[x].proyecto;
                        const codigo = `<option value="${idProyecto}">${proyecto}</option>`;

                        selectMoverProyecto.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            })
            .catch(function (err) {
                selectMoverSeccion.innerHTML = '<option value="">Seleccione Sección</option>';
                selectMoverSubseccion.innerHTML = '<option value="">Seleccione Subsección</option>';
                selectMoverEquipo.innerHTML = '<option value="">Seleccione Equipo</option>';
                selectMoverProyecto.innerHTML = '<option value="">Seleccione Proyecto</option>';

                fetch(APIERROR + err);
            })
    }
})


// MUEVE REGISTROS
const moverA = (id, tipo) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "moverA";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&id=${id}&tipo=${tipo}&opcion=${selectMoverOpcion.value}&idSeccion=${selectMoverSeccion.value}&idSubseccion=${selectMoverSubseccion.value}&idEquipo=${selectMoverEquipo.value}&idProyecto=${selectMoverProyecto.value}`;

    if (selectMoverOpcion.value != "" && selectMoverSeccion.value != "" && selectMoverSubseccion.value != "") {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg('Elimine la Actividad para Finalizar Proceso', '', 'success', 1400);
                } else if (array == 2) {
                    alertaImg('Proceso Completado con Exito', '', 'success', 1400);
                } else {
                    alertaImg('Verifique la Información', '', 'info', 1500);
                }
            })
            .catch(function (err) {
                fetch(APIERROR + err);
            })
    } else {
        alertaImg('Acomplete la Información Requerida', '', 'info', 1500);
    }
}