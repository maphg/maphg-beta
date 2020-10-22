function seguridad_session() {
    let idUsuario = localStorage.getItem('usuario');
    const URL = `php/seguridad_session.php?action=seguridad_session&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            if (resp == 0) {
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                location.href = "https://www.maphg.com/beta/login.php";
                localStorage.clear();
            }
        })
        .catch(function () {
            console.log()
        });
}
setInterval(seguridad_session, 60000);