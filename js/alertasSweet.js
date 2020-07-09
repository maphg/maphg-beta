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
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timeAlert,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        // title: 'Sweet!',
        text: text,
        icon: icon,
        background: '#e2e8f0',
        height: '0px',
        customClass: {
            container: 'm-1 w-30 text-red-400',
            content: 'mt-3 text-red-400',
            icon: 'mt-3 mx-2 w-5'
        }
    })
}
// Ejemplo para llamar a la función.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 30000)