function obtActivoXPagina(pagina){
     $.ajax({
        type: 'post',
        url: 'php/activosPHP.php',
        data: 'action=obtActivoXPagina&&pagina=' + pagina,
        success: function (data) {
            $("#sectionActivos").html("");
            $("#sectionActivos").html(data);
        }
    });
}

function obtActivoXBusqueda(pagina){
    var busqueda = $("#txtBusqueda").val();
     $.ajax({
        type: 'post',
        url: 'php/activosPHP.php',
        data: 'action=busqueda&pagina=' + pagina + '&busqueda=' + busqueda,
        success: function (data) {
            $("#sectionActivos").html("");
            $("#sectionActivos").html(data);
        }
    });
}

function obtActivoXBusquedaXPagina(pagina){
    var busqueda = $("#txtBusqueda").val();
     $.ajax({
        type: 'post',
        url: 'php/activosPHP.php',
        data: 'action=busqueda&pagina=' + pagina + '&busqueda=' + busqueda,
        success: function (data) {
            $("#sectionActivos").html("");
            $("#sectionActivos").html(data);
        }
    });
}