// Ejemplo para llamar a la función de las alertas.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 3000)
//                      msj                         color-text  icon    time


function toggleModal(idModal) {
    $("#" + idModal).toggleClass('hidden');
}


function consultaSubalmacen() {
    const action = "consultaSubalmacen";
    $.ajax({
        type: "POST",
        url: "libs/crud_subalmacen.php",
        data: {
            action: action
        },
        dataType: "json",
        success: function (data) {
            $("#subalmacenGP").html(data.dataGP);
            $("#subalmacenTRS").html(data.dataTRS);
            $("#subalmacenZI").html(data.dataZI);
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
            url: "libs/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen
            },
            // dataType: "json",
            success: function (response) {
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
            url: "libs/crud_subalmacen.php",
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
            url: "libs/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen,
                tituloSubalmacen: tituloSubalmacen
            },
            success: function (response) {
                consultaSubalmacen();
                // Swal.fire(`Subalamcen Actualizado: ${tituloSubalmacen}`)
                alertaImg(response, 'text-green-600', 'success', 3000);

            }
        });
    }
}


consultaSubalmacen();