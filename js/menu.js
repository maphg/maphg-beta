const obtenerMenu = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerMenu";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            console.log(array)

            if (array.NIVEL_1) {
                for (let x = 0; x < array.NIVEL_1.length; x++) {
                    const idOpcion = array.NIVEL_1[x].idOpcion;
                    const idPadre = array.NIVEL_1[x].idPadre;
                    const nivel = array.NIVEL_1[x].nivel;
                    const titulo = array.NIVEL_1[x].titulo;
                    const link = array.NIVEL_1[x].link;
                    const icono = array.NIVEL_1[x].icono;

                    console.log(titulo);

                }
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


obtenerMenu();