function seguridad_session() {
    let idUsuario = localStorage.getItem('usuario');
    const URL = `php/seguridad_session.php?action=seguridad_session&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            if (resp == 0) {
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                localStorage.clear();
                location.href = "https://www.maphg.com/beta/login.php";
            }
        })
        .catch(function () {
            console.log(1);
        });
}
setInterval(seguridad_session, 60000);