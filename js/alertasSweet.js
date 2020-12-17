function alertaConfirmar(informacion) {

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })
}
// Iconos: success, error, warning, info, question.

// ALERTA TOAST.
function alertInformacion(msj, icono) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: icono,
        title: msj
    })
}

function alertaMSJ(title, msj, icon) {
    Swal.fire(
        title,
        msj,
        icon
    )
}



// Función de StweetAlert, que recibe parametros, e incluye el logo de MAPHG.
function alertaImg(text, classColorText, icon, timeAlert) {
    duration = 4;
    if (timeAlert > 0) {
        duration = timeAlert / 1200;
    }

    alertify.set('notifier', 'position', 'top-right');
    alertify.set('notifier', 'delay', duration);

    if (icon == "success") {
        alertify.success(text);
    } else if (icon == "error") {
        alertify.error(text);
    } else if (icon == "warning") {
        alertify.warning(text);
    } else if (icon == "info") {
        alertify.message(text);
    } else if (icon == "question") {
        alertify.message(text);
    } else if (icon == "notify") {
        alertify.notify(text);
    }
}
// Ejemplo para llamar a la función.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 30000)