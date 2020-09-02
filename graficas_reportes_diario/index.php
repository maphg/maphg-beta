<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/fontawesome/css/all.css">
  <link rel="stylesheet" href="../css/tailwindproduccion.css">
  <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
</head>

<body class="p-8">

  <div class="w-full h-auto flex flex-col items-center justify-start text-bluegray-700">

    <div class="flex items-center justify-center my-10">
      <div onclick="recargarGraficasReportesDiario();" id="dataSeccion" class="zie-logo">
        <h1 id="dataNombreSeccion" class="">--</h1>
      </div>
      <div class="ml-10 font-bold text-2xl uppercase">
        <h1>Reporte de Fallas y Tareas</h1>
      </div>
    </div>

    <div class="ml-10 font-bold text-2xl uppercase self-start">
      <h1>Histórico</h1>
    </div>

    <div class="w-full mb-10">
      <div id="graficoManttos" class=" w-full h-84  bg-white"></div>
    </div>

    <div class="ml-10 font-bold text-2xl uppercase self-start">
      <h1>Última Semana</h1>
    </div>

    <div class="flex flex-col flex-wrap items-center justify-center mb-10 w-full">
      <div id="graficoUltimaSemana" class="bg-white sm:w-full h-84 rounded-lg mr-2 overflow-hidden"></div>
      <div class="w-full flex flex-row justify-center items-center text-bluegray-800">
        <div class="rounded-md w-40 h-48 uppercase text-center p-3 flex flex-col items-center justify-center mr-10 font-bold border-2 border-red-400">
          <h1 id="dataCreadosSemanal" class="text-5xl text-red-400">0</h1>
          <h1 class="text-sm">creados</h1>
          <h1 class="text-xs">Esta semana</h1>
        </div>
        <div class="rounded-md w-40 h-48 uppercase text-center p-3 flex flex-col items-center justify-center mr-10 font-bold border-2 border-green-400">
          <h1 id="dataSolucionadosSemanal" class="text-5xl text-green-400">0</h1>
          <h1 class="text-sm">Solucionados</h1>
          <h1 class="text-xs">Esta semana</h1>
        </div>
        <div class="rounded-md w-40 h-48 uppercase text-center p-3 flex flex-col items-center justify-center mr-10 font-bold border-2 border-orange-400">
          <h1 id="dataAcumuladosHoy" class="text-5xl text-orange-400">0</h1>
          <h1 class="text-sm">Acumulado</h1>
          <h1 class="text-xs">Hasta hoy</h1>
        </div>
        <div class="rounded-md w-40 h-48 uppercase text-center p-3 flex flex-col items-center justify-center mr-10 font-bold border-2 border-red-500">
          <h1 id="dataSinAsignar" class="text-5xl text-red-500">0</h1>
          <h1 class="text-sm">Sin asignar</h1>
        </div>
      </div>
    </div>

    <div class="ml-10 font-bold text-2xl uppercase self-start">
      <h1>Fallas y Tareas por Subsección</h1>
    </div>
    <div class="w-full mb-10">
      <div id="subsecciones" class=" w-full h-108  bg-white"></div>
    </div>

    <div class="ml-10 font-bold text-2xl uppercase self-start">
      <h1>Fallas y Tareas por Responsables asignados</h1>
    </div>
    <div class="w-full mb-10">
      <div id="responsables" class=" w-full h-108  bg-white"></div>
    </div>


  </div>
  <script src="../js/jquery-3.3.1.js"></script>
  <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script> -->
  <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
  <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
  <script src="js/graficas_reportes_diario.js"></script>
</body>

</html>