$(function () {

    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        showWeekNumbers: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto",
                "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ],
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YY') + ' - ' + picker.endDate.format(
            'DD/MM/YY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

});


function expandir(id) {
    idtoggle = id + 'toggle';
    var toggle = document.getElementById(idtoggle);
    toggle.classList.toggle("hidden");
}

function expandirpapa(idpapa) {
    var expandeapapa = document.getElementById(idpapa);
    expandeapapa.classList.toggle("h-40");
}



/* document.getElementById("abremodal").click();
expandir("equipo123"); */
