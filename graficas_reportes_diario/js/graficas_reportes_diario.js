
function cargarSeccionEstilosGraficas(idDestino, idSeccion) {
  document.getElementById("dataNombreSeccion").innerHTML =
    '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

  const action = "cargarSeccionEstilosGraficas";
  $.ajax({
    type: "GET",
    url: "php/graficas_reportes_diario_crud.php",
    data: {
      action: action,
      idDestino: idDestino,
      idSeccion: idSeccion
    },
    // dataType: "json",
    success: function (data) {
      let estiloSeccion = data.toLowerCase() + '-logo';
      document.getElementById("dataSeccion").classList.remove('zil-logo', 'zie-logo', 'auto-logo', 'dec-logo', 'dep-logo', 'zha-logo', 'zhc-logo', 'zhp-logo', 'zia-logo', 'zic-logo', 'zhh-logo');
      document.getElementById("dataSeccion").classList.add(estiloSeccion);
      document.getElementById("dataNombreSeccion").innerHTML = data;
    }
  });
}


function graficaHistorico(idDestino, idSeccion) {
  // Add data
  let dataHistorial = "php/graficas_reportes_diario_crud.php?action=graficaHistorico&idDestino=" + idDestino + "&idSeccion=" + idSeccion;

  fetch(dataHistorial)
    .then(res => res.json())
    .then(data => {
      generarGrafico(idDestino, idSeccion, data)
    });

  function generarGrafico(idDestino, idSeccion, data) {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("graficoManttos", am4charts.XYChart);


    chart.data = data;



    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;
    dateAxis.renderer.minGridDistance = 30;
    dateAxis.renderer.grid.template.disabled = false;
    dateAxis.renderer.labels.template.disabled = false;
    dateAxis.dateFormats.setKey("day", "MMM dd");

    //Poner un zoom inicial a las fechas
    chart.events.on("ready", function () {
      dateAxis.zoomToDates(
        new Date(2020, 08, 01),
        new Date(2020, 08, 08),
        console.log(3)
      );
    });

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.grid.template.disabled = true;
    valueAxis.renderer.labels.template.disabled = true;


    // Colores del chart
    chart.colors.list = [
      am4core.color("#FE3572"),
      am4core.color("#68d391"),
      am4core.color("#9C6BFF"),

    ];
    // Create series
    function createSeries(field, name) {
      var series = chart.series.push(new am4charts.LineSeries());
      series.dataFields.valueY = field;
      series.dataFields.dateX = "date";
      series.name = name;
      series.tooltipText = "{dateX}: [b]{valueY}[/]";
      series.strokeWidth = 2;
      series.tensionX = 0.7;
      series.tensionY = 1;
      //series.legendSettings.valueText = "{valueY.close}";
      series.legendSettings.itemValueText = "[bold]{valueY}[/bold]";


      //añadir un scrollbar
      chart.scrollbarX = new am4charts.XYChartScrollbar();
      chart.scrollbarX.series.push(series);
      chart.scrollbarX.parent = chart.bottomAxesContainer;
      chart.scrollbarX.minHeight = 40;
      chart.scrollbarX.thumb.minWidth = 50;

      chart.scrollbarX.background.fill = am4core.color("#F6F5FC");
      chart.scrollbarX.background.fillOpacity = 0.2;

      chart.scrollbarX.thumb.background.fill = am4core.color("#263238");
      chart.scrollbarX.thumb.background.fillOpacity = 0.2;

      chart.scrollbarX.unselectedOverlay.fill = am4core.color("#F6F5FC");
      chart.scrollbarX.unselectedOverlay.fillOpacity = 0.2;
      chart.scrollbarX.isHidden = true;
      //chart.scrollbarX.start=1


      chart.padding(0, 0, 0, 0);


      // Set up tooltip
      series.adapter.add("tooltipText", function (ev) {
        var text = "[bold]{dateX}[/]\n"
        chart.series.each(function (item) {
          text += "[" + item.stroke.hex + "]●[/] " + item.name + ": {" + item.dataFields.valueY + "}\n";
        });
        return text;
      });

      series.tooltip.getFillFromObject = false;
      series.tooltip.background.fill = am4core.color("#fff");
      series.tooltip.label.fill = am4core.color("#00");
      series.fillOpacity = 0.1;


      var bullet = series.bullets.push(new am4charts.CircleBullet());
      bullet.circle.stroke = am4core.color("#fff");
      bullet.circle.strokeWidth = 1;

      return series;
    }

    createSeries("Creado", "Creado");
    createSeries("Solucionado", "Solucionado");
    createSeries("Acumulado", "Acumulado");

    chart.legend = new am4charts.Legend();
    chart.legend.position = "top";
    chart.legend.useDefaultMarker = true;
    var marker = chart.legend.markers.template.children.getIndex(0);
    marker.cornerRadius(12, 12, 12, 12);
    var markerTemplate = chart.legend.markers.template;
    markerTemplate.width = 12;
    markerTemplate.height = 12;

    chart.cursor = new am4charts.XYCursor();
    chart.cursor.maxTooltipDistance = 0;

    chart.exporting.menu = new am4core.ExportMenu();
  }
}


function graficaUltimaSemana(idDestino, idSeccion) {
  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Themes end

  // Create chart instance
  var graficoUltimaSemana = am4core.create("graficoUltimaSemana", am4charts.XYChart);

  // Add data
  graficoUltimaSemana.dataSource.url = "php/graficas_reportes_diario_crud.php?action=graficaUltimaSemana&idDestino=" + idDestino + "&idSeccion=" + idSeccion;

  // Create axes
  var ejeFechas = graficoUltimaSemana.xAxes.push(new am4charts.DateAxis());
  ejeFechas.renderer.grid.template.location = 0;
  ejeFechas.renderer.minGridDistance = 30;
  ejeFechas.renderer.grid.template.disabled = false;
  ejeFechas.renderer.labels.template.disabled = false;
  ejeFechas.dateFormats.setKey("day", "MMM dd");
  ejeFechas.renderer.grid.template.disabled = true;

  var ejeValores = graficoUltimaSemana.yAxes.push(new am4charts.ValueAxis());
  ejeValores.renderer.grid.template.disabled = true;
  ejeValores.renderer.labels.template.disabled = true;

  // Colores del chart
  graficoUltimaSemana.colors.list = [
    am4core.color("#FE3572"),
    am4core.color("#68d391")

  ];
  // Create series
  function createSeries(field, name) {
    var series = graficoUltimaSemana.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = field;
    series.dataFields.dateX = "date";
    series.name = name;
    series.tooltipText = "{dateX}: [b]{valueY}[/]";
    series.strokeWidth = 2;
    series.tensionX = 0.7;
    series.tensionY = 1;
    //series.legendSettings.valueText = "{valueY.close}";
    series.legendSettings.itemValueText = "[bold]{valueY}[/bold]";

    graficoUltimaSemana.padding(0, 0, 0, 0);

    // Set up tooltip
    series.adapter.add("tooltipText", function (ev) {
      var text = "[bold]{dateX}[/]\n"
      graficoUltimaSemana.series.each(function (item) {
        text += "[" + item.stroke.hex + "]●[/] " + item.name + ": {" + item.dataFields.valueY + "}\n";
      });
      return text;
    });

    series.tooltip.getFillFromObject = false;
    series.tooltip.background.fill = am4core.color("#fff");
    series.tooltip.label.fill = am4core.color("#00");
    series.fillOpacity = 0.1;

    var bullet = series.bullets.push(new am4charts.CircleBullet());
    bullet.circle.stroke = am4core.color("#fff");
    bullet.circle.strokeWidth = 1;

    /* var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    labelBullet.label.text = "[bold]{valueY}[/]";
    labelBullet.label.dy = -20;
    labelBullet.label.fill = am4core.color("#000"); */

    return series;
  }

  createSeries("Creado", "Creado");
  createSeries("Solucionado", "Solucionado");

  graficoUltimaSemana.legend = new am4charts.Legend();
  graficoUltimaSemana.legend.position = "top";
  graficoUltimaSemana.legend.useDefaultMarker = true;
  var marker = graficoUltimaSemana.legend.markers.template.children.getIndex(0);
  marker.cornerRadius(12, 12, 12, 12);
  var markerTemplate = graficoUltimaSemana.legend.markers.template;
  markerTemplate.width = 12;
  markerTemplate.height = 12;

  graficoUltimaSemana.cursor = new am4charts.XYCursor();
  graficoUltimaSemana.cursor.maxTooltipDistance = 0;

  graficoUltimaSemana.exporting.menu = new am4core.ExportMenu();
}


function graficaSubsecciones(idDestino, idSeccion) {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Themes end

  // Create chart instance
  var graficosubsecciones = am4core.create("subsecciones", am4charts.XYChart);

  // Add percent sign to all numbers
  graficosubsecciones.numberFormatter.numberFormat = "#.#";



  // Add data
  graficosubsecciones.dataSource.url = "php/graficas_reportes_diario_crud.php?action=graficaSubsecciones&idDestino=" + idDestino + "&idSeccion=" + idSeccion;

  // Create axes
  var categoryAxis = graficosubsecciones.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "Subseccion";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.minGridDistance = 30;
  categoryAxis.renderer.grid.template.disabled = true;


  var valueAxis = graficosubsecciones.yAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.grid.template.disabled = true;
  valueAxis.renderer.labels.template.disabled = true;


  // Create series
  var series = graficosubsecciones.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = "Solucionado";
  series.dataFields.categoryX = "Subseccion";
  series.clustered = false;
  //series.tooltipText = "Solucionado en {categoryX}: [bold]{valueY}";
  series.fill = am4core.color("#68D391");
  series.stroke = am4core.color("#68D391");
  series.fillOpacity = 0.2;
  series.strokeWidth = 2;

  var bullet = series.bullets.push(new am4charts.CircleBullet());
  bullet.circle.stroke = am4core.color("#fff");
  bullet.circle.strokeWidth = 1;

  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "[bold]{valueY}[/]";
  labelBullet.label.dy = -20;
  labelBullet.label.fill = am4core.color("#68D391");

  var series2 = graficosubsecciones.series.push(new am4charts.ColumnSeries());
  series2.dataFields.valueY = "Pendientes";
  series2.dataFields.categoryX = "Subseccion";
  series2.clustered = false;
  series2.columns.template.width = am4core.percent(50);
  //series2.tooltipText = "Pendientes en {categoryX}: [bold]{valueY}";
  series2.fill = am4core.color("#EA4C89");
  series2.stroke = am4core.color("#EA4C89");
  series2.fillOpacity = 0.2;
  series2.strokeWidth = 2;

  var labelBullet2 = series2.bullets.push(new am4charts.LabelBullet());
  labelBullet2.label.text = "[bold]{valueY}[/]";
  labelBullet2.label.dy = -20;
  labelBullet2.label.fill = am4core.color("#EA4C89");

  var bullet2 = series2.bullets.push(new am4charts.CircleBullet());
  bullet2.circle.stroke = am4core.color("#fff");
  bullet2.circle.strokeWidth = 1;

  graficosubsecciones.cursor = new am4charts.XYCursor();
  graficosubsecciones.cursor.lineX.disabled = true;
  graficosubsecciones.cursor.lineY.disabled = true;


  graficosubsecciones.padding(10, 10, 10, 10);
}


function graficaResponsables(idDestino, idSeccion) {

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Themes end

  // Create chart instance
  var graficoResponsables = am4core.create("responsables", am4charts.XYChart);

  // Add percent sign to all numbers
  graficoResponsables.numberFormatter.numberFormat = "#.#";

  // Add data
  graficoResponsables.dataSource.url = "php/graficas_reportes_diario_crud.php?action=graficaResponsables&idDestino=" + idDestino + "&idSeccion=" + idSeccion;

  // Create axes
  var categoryAxis = graficoResponsables.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "Responsable";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.minGridDistance = 30;
  categoryAxis.renderer.grid.template.disabled = true;


  var valueAxis = graficoResponsables.yAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.grid.template.disabled = true;
  valueAxis.renderer.labels.template.disabled = true;


  // Create series
  var series = graficoResponsables.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = "Solucionado";
  series.dataFields.categoryX = "Responsable";
  series.clustered = false;
  //series.tooltipText = "Solucionado en {categoryX}: [bold]{valueY}";
  series.fill = am4core.color("#68D391");
  series.stroke = am4core.color("#68D391");
  series.fillOpacity = 0.2;
  series.strokeWidth = 2;

  var bullet = series.bullets.push(new am4charts.CircleBullet());
  bullet.circle.stroke = am4core.color("#fff");
  bullet.circle.strokeWidth = 1;

  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "[bold]{valueY}[/]";
  labelBullet.label.dy = -20;
  labelBullet.label.fill = am4core.color("#68D391");



  var series2 = graficoResponsables.series.push(new am4charts.ColumnSeries());
  series2.dataFields.valueY = "Pendientes";
  series2.dataFields.categoryX = "Responsable";
  series2.clustered = false;
  series2.columns.template.width = am4core.percent(50);
  //series2.tooltipText = "Pendientes en {categoryX}: [bold]{valueY}";
  series2.fill = am4core.color("#EA4C89");
  series2.stroke = am4core.color("#EA4C89");
  series2.fillOpacity = 0.2;
  series2.strokeWidth = 2;

  var labelBullet2 = series2.bullets.push(new am4charts.LabelBullet());
  labelBullet2.label.text = "[bold]{valueY}[/]";
  labelBullet2.label.dy = -20;
  labelBullet2.label.fill = am4core.color("#EA4C89");

  var bullet2 = series2.bullets.push(new am4charts.CircleBullet());
  bullet2.circle.stroke = am4core.color("#fff");
  bullet2.circle.strokeWidth = 1;

  graficoResponsables.cursor = new am4charts.XYCursor();
  graficoResponsables.cursor.lineX.disabled = true;
  graficoResponsables.cursor.lineY.disabled = true;

  graficoResponsables.padding(10, 10, 10, 10);
}


function CuadrosUltimaSemana(idDestino, idSeccion) {
  const action = "CuadrosUltimaSemana";
  $.ajax({
    type: "GET",
    url: "php/graficas_reportes_diario_crud.php",
    data: {
      action: action,
      idDestino: idDestino,
      idSeccion: idSeccion
    },
    dataType: "json",
    success: function (data) {
      document.getElementById("dataCreadosSemanal").innerHTML = (data.semanaCreados);
      document.getElementById("dataSolucionadosSemanal").innerHTML = (data.semanaSolucionados);
      document.getElementById("dataAcumuladosHoy").innerHTML = (data.totalAcumulado);
      document.getElementById("dataSinAsignar").innerHTML = (data.totalSinResponsable);
    }
  });
}


function recargarGraficasReportesDiario() {
  let idDestino = localStorage.getItem('idDestino');
  let idSeccion = localStorage.getItem('idSeccion');

  graficaHistorico(idDestino, idSeccion);
  cargarSeccionEstilosGraficas(idDestino, idSeccion);
  graficaUltimaSemana(idDestino, idSeccion);
  graficaSubsecciones(idDestino, idSeccion);
  graficaResponsables(idDestino, idSeccion);
  CuadrosUltimaSemana(idDestino, idSeccion);
}
recargarGraficasReportesDiario();
