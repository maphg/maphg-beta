console.log('%cSTOP!', 'color:red; font-weight: bold; font-size: 4.3rem');

function seguridad_session() {
    let idUsuario = localStorage.getItem('usuario');
    if (idUsuario == 'undefined' || idUsuario <= 0) {
        cerrarSessionX();
    } else {

        const URL = `php/seguridad_session.php?action=seguridad_session&idUsuario=${idUsuario}`;
        fetch(URL)
            .then(resp => resp.json())
            .then(resp => {
                if (resp == 0) {
                    localStorage.clear();
                    alertaImg('¡Usuario Denegado!', '', 'error', 1400);
                    cerrarSessionX();
                }
            })
            .catch(function (err) {
                cerrarSessionX();
            });
    }
}
setInterval(seguridad_session, 300000);

const cerrarSessionX = () => {
    fetch('login.php')
        .then(resp => {
            if (resp.status == 200) {
                location.href = 'login.php';
            }
        })
        .catch(() => {
            location.href = 'www.google.com';
        })

    fetch('../login.php')
        .then(resp => {
            if (resp.status == 200) {
                location.href = '../login.php';
            }
        })
        .catch(() => {
            location.href = 'www.google.com';
        })
}
seguridad_session();