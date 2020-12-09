// let idUsuario = localStorage.getItem('usuario');
let idDestino = localStorage.getItem('idDestino');

// Función principal.
function comprobarSession() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    // Comprueba que exista la session.
    if (idUsuario == '' || idDestino == '') {
        location.replace("https://www.maphg.com/beta/login.php");
        // location.replace("http://localhost/maphg-beta/login.php");
    }
}

function obtenerDatosUsuario(idDestino) {
    localStorage.setItem('idDestino', idDestino);
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerDatosUsuario";
    const URL = `../php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(array => array.json())
        .then(data => {
            document.getElementById("avatarUsuario").innerHTML = '<img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=' + data.nombre + ' % ' + data.apellido + '"' + 'alt="avatar" class="menu-contenedor-6">';
            document.getElementById("nombreUsuarioNavBarTop").innerHTML = data.nombre + ' ' + data.apellido;
            document.getElementById("nombreUsuarioMenu").innerHTML = data.nombre + ' ' + data.apellido;
            document.getElementById("cargoUsuarioMeu").innerHTML = data.cargo;
            document.getElementById("destinoNavBarTop").innerHTML = data.destino;
            document.getElementById("destinosSelecciona").innerHTML = data.destinosOpcion;

            // alertaImg('Destino Seleccionado: ' + data.destino, '', 'success', 2000);

        })
        .then(function () {
            comprobarSession();
        })
        .catch(function (err) {
            // fetch( err);
        })
}


document.getElementById("destinosSelecciona").addEventListener('click', () => {
    botonDestino();
});


// Función para comprobar session.
comprobarSession();
obtenerDatosUsuario(idDestino);