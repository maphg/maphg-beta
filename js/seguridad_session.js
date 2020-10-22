function seguridad_session() {
    console.log('ok');
    let idUsuario = localStorage.getItem('usuario');
    const URL = `php/seguridad_session.php?action=seguridad_session&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            console.log(resp);
            if (resp == 0) {
                alertaImg('¡Usuario Denegado!', '', 'error', 1200);
                location.href = "https://www.maphg.com/beta/login.php";
                localStorage.clear();
            }
        })
        .catch(function () {
            alertaImg('¡Usuario Denegado!', '', 'error', 1200);
        });
}
setInterval(seguridad_session, 5000);