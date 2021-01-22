'use strict';
const destinosSelecciona = document.createElement('destinosSelecciona');

const consultarStock = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "consultarStock";
    const URL = `php/stock.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            console.log(array)
        })
        .catch(function (err) {

        })
}

destinosSelecciona.addEventListener('click', consultarStock);

// INICIALIZA LA FUNCIÓN PRINCIPAL
window.onload(consultarStock());

