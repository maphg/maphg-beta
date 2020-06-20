// Ejemplo para llamar a la función de las alertas.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 3000)
//                      msj                         color-text  icon    time


function toggleModal(idModal) {
    $("#" + idModal).toggleClass('hidden');
}


function eliminarSubalmacen(idAlmacen) {
    console.log('Eliminado');
    alertaImg('Subalmacén Eliminado', 'has-text-info', 'success', '3000');
    const action = "eliminarSubalmacen";
    $.ajax({
        type: "POST",
        url: "libs/crud_subalmacen.php",
        data: {
            action: action
        },
        // dataType: "json",
        success: function (response) {
            console.log('Eliminado');
        }
    });
}