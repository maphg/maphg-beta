function consultaSubsecciones(idDestino) {
    const action = "consultaSubsecciones";

    $.ajax({
        type: "POST",
        url: "/php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
        }
    });
}

consultaSubsecciones(1);