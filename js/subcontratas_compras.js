const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

function obtenerServicios() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerServicios";
    const URL = `php/subcontratas_compras.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    document.getElementById("opcionServicios").classList.add("bg-gray-200");
    document.getElementById("opcionServicios").classList.remove("hover:bg-gray-200");
    document.getElementById("opcionMateriales").classList.add("hover:bg-gray-200");
    document.getElementById("opcionMateriales").classList.remove("bg-gray-200");
    document.getElementById("materiales").classList.add("hidden");
    document.getElementById("servicios").classList.remove("hidden");

    document.getElementById("load").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-lg"></i>';

    alertaImg('Obteniendo Registros...', '', 'info', 500);

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            console.log(array)
            document.getElementById("dataServicios").innerHTML = '';
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const fecha = array[x].fecha;
                    const importe = array[x].importe;
                    const cc = array[x].cc;
                    const asignacion = array[x].asignacion;
                    const texto = array[x].texto;
                    const nombreProveedorAF = array[x].nombreProveedorAF;
                    const nombre_1 = array[x].nombre_1;
                    const textoCeco = array[x].textoCeco;

                    const codigo = `
                        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">
                            
                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold fecha-servicio">
                            ${fecha}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-semibold ceco-servicio">
                            ${textoCeco}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold asignacion-servicio">
                            ${asignacion}
                            </td>

                            <td class="px-2 border-b border-gray-200 text-left py-1 font-semibold whitespace-wrap text-servicio" style="max-width: 170px; text-align: left;">
                            ${texto}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-left py-1 font-semibold proveedor-servicio">
                            ${nombreProveedorAF}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold importe-servicio">
                            ${'$' + importe}
                            </td>
                            
                            <td class="px-2 whitespace-wrap border-b border-gray-200 text-left py-1 font-semibold nombre-servicio">
                            ${nombre_1}
                            </td>

                        </tr>
                    `;
                    document.getElementById("dataServicios").insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(function () {
            document.getElementById("load").innerHTML = '';
            alertaImg('Carga Completada', '', 'success', 1000);
        })
        .catch(function (err) {
            fetch(APIERROR + err);
            document.getElementById("load").innerHTML = '';
            document.getElementById("load").innerHTML = '';
        })
}


function obtenerMateriales() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerMateriales";
    const URL = `php/subcontratas_compras.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
    document.getElementById("opcionServicios").classList.remove("bg-gray-200");
    document.getElementById("opcionServicios").classList.add("hover:bg-gray-200");
    document.getElementById("opcionMateriales").classList.remove("hover:bg-gray-200");
    document.getElementById("opcionMateriales").classList.add("bg-gray-200");
    document.getElementById("materiales").classList.remove("hidden");
    document.getElementById("servicios").classList.add("hidden");

    document.getElementById("load").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-lg"></i>';

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            console.log(array);
            document.getElementById("dataMateriales").innerHTML = '';
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const fecha = array[x].fecha;
                    const importe = array[x].importe;
                    const cc = array[x].cc;
                    const asignacion = array[x].asignacion;
                    const texto = array[x].texto;
                    const nombreProveedorAF = array[x].nombreProveedorAF;
                    const nombre_1 = array[x].nombre_1;
                    const documentoCompras = array[x].documentoCompras;
                    const textoCeco = array[x].textoCeco;

                    const codigo = `
                        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">
                            
                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold">
                            ${fecha}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-semibold">
                            ${textoCeco}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold">
                            ${asignacion}
                            </td>

                            <td class="px-2 border-b border-gray-200 text-left py-1 font-semibold whitespace-wrap" style="max-width: 170px; text-align: left;">
                            ${texto}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-left py-1 font-semibold">
                            ${nombreProveedorAF}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-1 font-bold">
                            ${'$' + importe}
                            </td>
                            
                            <td class="px-2 whitespace-wrap border-b border-gray-200 text-left py-1 font-semibold">
                            ${nombre_1}
                            </td>

                        </tr>
                    `;
                    document.getElementById("dataMateriales").insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(function () {
            document.getElementById("load").innerHTML = '';
        })
        .catch(function (err) {
            fetch(APIERROR + err);
            document.getElementById("load").innerHTML = '';
            document.getElementById("dataMateriales").innerHTML = '';
        })
}


// EVENTO PARA BUSCAR EN TABLA #dataProyectos
document.getElementById("palabraServicios").addEventListener('keyup', function () {
    let columna = document.getElementById("columnaServicio").value;
    buscadorTabla('dataServicios', 'palabraServicios', columna);
});

// EVENTO PARA BUSCAR EN TABLA #dataProyectos
document.getElementById("palabraMateriales").addEventListener('keyup', function () {
    let columna = document.getElementById("columnaMateriales").value;
    buscadorTabla('dataMateriales', 'palabraMateriales', columna);
});

document.getElementById("opcionServicios").addEventListener('click', obtenerServicios);
document.getElementById("opcionMateriales").addEventListener('click', obtenerMateriales);