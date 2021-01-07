function storageUsuario() {
    var idUsuario = localStorage.getItem('usuario');
    var idDestino = localStorage.getItem('idDestino');
    var superAdmin = localStorage.getItem('superAdmin');

    const action = "recuperarSession";
    $.ajax({
        type: "POST",
        url: "php/session_refresh_expire.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            superAdmin: superAdmin
        },
        // dataType: "json",
        success: function (data) {
        }
    });
}
// setInterval('storageUsuario()', 180000);
