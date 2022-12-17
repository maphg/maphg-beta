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
        '<i class="fa fa-spinner fa-spin fa-lg"></i>';

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("dataServicios").innerHTML = '';
            if (array.length > 0) {
                alertaImg('Registros Obtenidos: ' + array.length, '', 'success', 1200);
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
                    document.getElementById("dataServicios").
                        insertAdjacentHTML('beforeend', codigo);
                }
            } else {
                alertaImg('Sin Registros', '', 'info', 1200);
            }
        })
        .then(function () {
            document.getElementById("load").innerHTML = '';
        })
        .catch(function (err) {
            fetch(APIERROR + err);
            document.getElementById("load").innerHTML = '';
            document.getElementById("dataServicios").innerHTML = '';
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
        '<i class="fa fa-spinner fa-spin fa-lg"></i>';

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("dataMateriales").innerHTML = '';
            if (array.length > 0) {
                alertaImg('Registros Obtenidos: ' + array.length, '', 'success', 1200);
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
                    document.getElementById("dataMateriales").
                        insertAdjacentHTML('beforeend', codigo);
                }
            } else {
                alertaImg('Sin Registros', '', 'info', 1200)
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


function powerbi() {
    let idDestino = localStorage.getItem('idDestino');
    let powerbiURL =
        [
            {
                "id": 11,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiNTUxM2E4MjktZWUxZS00ZWRlLTg0NTAtZDZmNTZjNTIxYzFiIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 1,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiYmZlNzRkMGQtOGMyYi00MmU1LThhNjYtNTU4NjY3MmJlZGQwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9",
                "descripcion": "NA"
            },

            {
                "id": 7,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiYTc5ODQzMDktNjZiNS00ZDJkLTllNDctOWU0ODU1YmNkZWI0IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 2,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiYjhkMWY3ZjItYzBmNS00M2UyLTg3ZWYtZWEwZDU5MTRlNTYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 6,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiMWNiMDM0NGUtYWQyNy00NmQ0LTgyN2ItNzE2NjBmY2FkZDBlIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 5,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiNjg0NTY2MjMtMWUwNy00MTYwLWE4NDctMmU0MTUxMjU2NzI3IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 4,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiMDZhMjA1YjYtYmQ2Ny00OTFkLWIwOTAtNTc3MTA4Yjk4ZGIwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            },

            {
                "id": 3,
                "URL": "https://app.powerbi.com/view?r=eyJrIjoiYzQ5MmQ1NTAtOTkwYS00OTNhLThlOGItNmQ4NTcwODE2NzcwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
            }
        ]

    let contenedor = document.getElementById('contenedorPowerbi');
    for (let x = 0; x < powerbiURL.length; x++) {
        const id = powerbiURL[x].id;
        if (document.getElementById("powerbi_" + id)) {
            document.getElementById("powerbi_" + id).classList.add("hidden");
            document.getElementById("powerbi_" + id).childNodes[1].setAttribute('src', '');
        }
    }

    for (let x = 0; x < powerbiURL.length; x++) {
        const id = powerbiURL[x].id;
        const URL = powerbiURL[x].URL;

        if (idDestino == 10) {
            contenedor.className = 'bg-red-100 rounded grid grid-cols-3 gap-1 p-2';
            if (document.getElementById("powerbi_" + id)) {
                document.getElementById("powerbi_" + id).classList.remove("hidden");
                document.getElementById("powerbi_" + id).childNodes[1].
                    setAttribute('src', URL);
            }
        } else {
            contenedor.className = 'bg-red-100 rounded grid grid-cols-1 gap-1 p-2';
            if (document.getElementById("powerbi_" + idDestino) && idDestino == id) {
                document.getElementById("powerbi_" + idDestino).classList.remove("hidden");
                document.getElementById("powerbi_" + idDestino).childNodes[1].
                    setAttribute('src', URL);
            }
        }
    }

}


// EVENTOS
document.getElementById("opcionServicios").addEventListener('click', obtenerServicios);
document.getElementById("opcionMateriales").addEventListener('click', obtenerMateriales);


// EVENTOS PARA EXPORTAR
document.getElementById("btnExportarServicios").addEventListener("click", () => {
    tableToExcel('tablaServicios', 'excel');
})

// EVENTOS PARA EXPORTAR
document.getElementById("btnExportarMateriales").addEventListener("click", () => {
    // tableToExcel('tablaMateriales', 'excel');
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    alertaImg('Exportando Datos...', '', 'info', 1500);
    location.href = `php/exportar_excel_GET.php?action=exportarExcelGastos&idDestino=${idDestino}&idUsuario=${idUsuario}`;
})

window.onload = function () {
    powerbi();

    document.getElementById("destinosSelecciona").addEventListener('click', () => {
        powerbi();
        document.getElementById("materiales").classList.add("hidden");
        document.getElementById("servicios").classList.add("hidden");
    })
}