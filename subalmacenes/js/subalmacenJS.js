// Ejemplo para llamar a la función de las alertas.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 3000)
//                      msj                         color-text  icon    time

const arrayDestino = { 1: "RM", 7: "CMU", 2: "PVR", 6: "MBJ", 5: "PUJ", 11: "CAP", 3: "SDQ", 4: "SSA", 10: "AME" };

function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass('open');
}


// Funciones Principales para el Menu, donde se selecciona el destino.
(function () {
    let idDestinoDefault = $("#inputIdDestinoSeleccionado").val();
    $("#destinoSeleccionado").html(arrayDestino[idDestinoDefault]);
    console.log(idDestinoDefault);
}());

function idDestinoSeleccionado(idDestinoSeleccionado) {
    $("#inputIdDestinoSeleccionado").val(idDestinoSeleccionado);
    $("#destinoSeleccionado").html(arrayDestino[idDestinoSeleccionado]);
    console.log(idDestinoSeleccionado);
}
// Fin de Funciones principales para seleccionar el menu.


function consultaSubalmacen() {
    let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
    const action = "consultaSubalmacen";

    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idDestinoSeleccionado: idDestinoSeleccionado
        },
        dataType: 'JSON',
        success: function (data) {
            $("#subalmacenGP").html(data.dataGP);
            $("#subalmacenTRS").html(data.dataTRS);
            $("#subalmacenZI").html(data.dataZI);
            console.log('Here', data);
        }
    });
}


function eliminarSubalmacen(idSubalmacen = 0, nombre = 'error') {
    // Cambiar la accion cuando se finalice (eliminarSubalmacen), porque hay otro metodo con el mismo nombre.
    const action = "eliminar_Subalmacen";

    Swal.fire({
        title: '¿Eliminar Subalmacén: ' + nombre + '?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Subalmacén Eliminado!',
                // 'Your file has been deleted.',
                'success',
                eliminarSubalmacenConfirmado()
            )
        }
    })
    function eliminarSubalmacenConfirmado() {

        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen
            },
            // dataType: "json",
            success: function (response) {
                console.log(response);
                consultaSubalmacen();
            }
        });
    }
}



// Función para obtener la fase donde se va agregar el subalmacén. 
function agregarSubalmacenFase(fase) {
    $("#inputFaseSubalmacen").val(fase);
    $("#faseSubalmacen").val(fase);
}


// Función para agregar el subalmacén.
function agregarSubalmacen() {
    var fase = $("#inputFaseSubalmacen").val();
    var titulo = $("#inputTituloSubalmacen").val();
    const action = "agregarSubalmacen";

    if (titulo.length > 1 && fase != "") {
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                fase: fase,
                titulo: titulo
            },
            // dataType: "json",
            success: function (response) {
                consultaSubalmacen();
                alertaImg(response, 'text-green-600', 'success', 3000);
                $("#inputTituloSubalmacen").val('');
                toggleModal('modalAgregarSubalmacen');
            }
        });
    } else {
        alertaImg('Información NO Valida', 'text-yellow-600', 'error', 3000);
    }
}


async function editarSubalmacen(idSubalmacen, nombre) {

    const { value: tituloSubalmacen } = await Swal.fire({
        title: 'Actualizar Subalmacén',
        text: nombre,
        input: 'text',
        inputValue: nombre,
        inputPlaceholder: 'Nuevo Título',
        // showCancelButton: true,
        allowOutsideClick: false
    })

    if (tituloSubalmacen !== "") {
        const action = "editarSubalmacen";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen,
                tituloSubalmacen: tituloSubalmacen
            },
            success: function (response) {
                console.log('--' + response + '--');
                consultaSubalmacen();
                alertaImg(response, 'text-green-300', 'success', 300000);
            }
        });
    }
}


// Función para buscar un Item de Subalmacén.
function busquedaExisenciaSubalmacen() {
    let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
    let palabraBuscar = $("#inputPalabraBuscarSubalmacen").val();

    if (palabraBuscar != "") {
        consultaExistenciasSubalmacen(idSubalmacen, palabraBuscar);
    } else {
        consultaExistenciasSubalmacen(idSubalmacen, '');
    }
}


function consultaExistenciasSubalmacen(idSubalmacen, palabraBuscar) {
    $("#modalExistenciasSubalmacen").addClass('open');
    $("#inputIdSubalmacenSeleccionado").val(idSubalmacen);
    const action = "consultaExistenciasSubalmacen";
    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idSubalmacen: idSubalmacen,
            palabraBuscar: palabraBuscar
        },
        dataType: "json",
        success: function (data) {
            // alertaImg(response, 'text-green-700', 'success', 3000);
            $("#dataExistenciasSubalmacen").html(data.dataExistenciaSubalmacen);
            console.log(data);
            console.log(data.dataExistenciaSubalmacen);
            alertaImg(' Resultados Obtenidos: ' + data.totalResultados, 'text-orange-300', 'success', 3000);

        }
    });
}


// Función por Default, para mostrar subalmacén según la session.
consultaSubalmacen();