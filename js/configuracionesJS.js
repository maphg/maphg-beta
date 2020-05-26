function destinos(){
    $("#contenido-principal").html("<h1 class=\"title\">Destinos</h1>");
}

function secciones(){
    $("#contenido-principal").html("<h1 class=\"title\">Secciones</h1>");
}

function subsecciones(){
    $("#contenido-principal").html("<h1 class=\"title\">Subsecciones</h1>");
}

function categorias(){
    $("#contenido-principal").html("<h1 class=\"title\">Categorias</h1>");
}

function subcategorias(){
    $("#contenido-principal").html("<h1 class=\"title\">Subcategorias</h1>");
}

function equipos(){
    $.ajax({
        type: 'post',
        url: 'php/configuracionesPHP.php',
        data: 'action=equipos',
        beforeSend: function(){
          $("#divLoader").show();  
        },
        success: function(data){
            $("#divLoader").hide();
            $("#contenido-principal").html(data);
            $("#tablaEquipos").dataTable().fnDestroy();
                var tablaMC = $('#tablaEquipos').DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    "scrollY": "40vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "paging": false,
                    "autoWidth": true,
                    'dom': 'Rlfrtip',
                    'colReorder': {
                        'allowReorder': false
                    },
                    "columnDefs": [
                        {"width": "100%", "targets": 2}
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Reporte de pendientes de Usuarios',
                            className: 'button is-primary is-small'
                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );
                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });
                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }

                });
        }
    });
    
}