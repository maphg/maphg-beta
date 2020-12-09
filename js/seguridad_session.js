function seguridad_session() {
    let idUsuario = localStorage.getItem('usuario');
    const URL = `php/seguridad_session.php?action=seguridad_session&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            if (resp == 0) {
                localStorage.clear();
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                location.href = "https://www.maphg.com/beta/login.php";
            }
        })
        .catch(function (err) {
        });
}
setInterval(seguridad_session, 300000);

// window.addEventListener('storage', () => {
//     window.location = "/";
//     alertaImg(' ¡Acceso Denegado! ', '', 'warning', 1000);
// });