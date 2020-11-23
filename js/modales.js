document.addEventListener('click', function (e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    if (target.hasAttribute('data-toggle') && target.getAttribute('data-toggle') == 'modal') {
        if (target.hasAttribute('data-target')) {
            var m_ID = target.getAttribute('data-target');
            // document.getElementById(m_ID).classList.add('open');
            e.preventDefault();
        }
    }


}, false);

// CIERRA EN MODAL CON LA CLASE "OPEN"
function cerrarmodal(idmodal) {
    var cerrarr = document.getElementById(idmodal);
    cerrarr.classList.remove('open');

    // OPCION PARA CERRAR VENTANAS SECUNDARIAS
    if (idmodal == "modalPendientesX") {
        const ventanasSecundarias = [
            "tooltipEditarEliminarSolucionar",
            "tooltipActividadesGeneral",
        ];

        ventanasSecundarias.forEach(function (x) {
            if (document.getElementById(x)) {
                document.getElementById(x).classList.add('hidden');
            }
        })
    }
};

function abrirmodal(idModal) {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.add('open')
    }

}