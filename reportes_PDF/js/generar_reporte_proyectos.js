
function obtenerProyecto(idProyecto) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "obtenerProyecto";
    const URL = `php/generar_reporte_proyectos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;
    console.log(URL);
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let destino = array.proyecto.destino;
            let seccion = array.proyecto.seccion;
            let proyecto = array.proyecto.proyecto;
            let totalActividades = array.proyecto.actividades;

            document.getElementById("destino").innerHTML = destino;
            document.getElementById("seccion").innerHTML = seccion;
            document.getElementById("proyecto").innerHTML = proyecto;
            document.getElementById("cantidadActividades").innerHTML = totalActividades + " Actividades";
            document.getElementById("claseSeccion").className = '';
            document.getElementById("claseSeccion").classList.add(seccion.toLowerCase() + '-logo', 'relative');
            var code = "";
            for (let i = 0; i < array.actividades.length; i++) {
                const idActividad = array.actividades[i].idActividad;
                const actividad = array.actividades[i].actividad;
                const coste = array.actividades[i].coste;
                const comentario = array.actividades[i].comentario;

                code += `
                    <div class="text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full h-auto mt-4 flex flex-col">
                        <div class="font font-semibold text-bluegray-700 p-2 flex uppercase text-justify justify-center">
                            <div class="flex justify-center items-center">
                                <h1>${actividad}</h1>
                            </div>
                            <div class="bg-red-200 text-red-500 flex justify-center items-center p-2 rounded-md ml-2">
                                <h1>$ ${coste} </h1>
                            </div>
                        </div>
                        <div class="p-2 text-justify font-medium text-bluegray-700">
                            <h1>${comentario}</h1>
                        </div>
                        <div class="flex flex-wrap">
                `;

                for (let x = 0; x < array.actividades[i].imagenes.length; x++) {
                    const url = array.actividades[i].imagenes[x].url;

                    code += `
                            <div class="w-40 h-40 rounded-md overflow-hidden flex-none m-2">
                                <img src="${url}" class="w-full h-full" alt="">
                            </div>
                    `;
                }

                code += `
                            </div>
                    </div>
                `;
            }
            document.getElementById("dataActividades").innerHTML = code;
        });
}

function obtenerIdUrl() {
    let url = window.location.search.split('=');
    let idProyecto = url[1];
    obtenerProyecto(idProyecto);
}
onload = obtenerIdUrl;
