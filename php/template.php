<?php

Class Template {

    public function menu($destino) {
        if ($destino == "AME") {
            $destino = "";
            $urlPedidos = "file-explorer.php?p=";
            $urlSeguridad = "file-explorer.php?p=";
            $urlNormativas = "file-explorer.php?p=";
            $urlAuditorias = "file-explorer.php?p=";
            $urlCertificaciones = "file-explorer.php?p=";
            $urlCotizaciones = "file-explorer.php?p=";
            $urlPlanos = "file-explorer.php?p=";
            $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EYjYlh0HZ-FCiruFihcKP_kBNJ_UDlRGrm2T5G6RcTWWJA";
        } else {
            $urlPedidos = "pedidos/#maphg/$destino";
            $urlSeguridad = "file-explorer.php?p=/$destino/SEGURIDAD";
            $urlNormativas = "file-explorer.php?p=/$destino/NORMATIVAS";
            $urlAuditorias = "tinyfilemanager.php?p=$destino/AUDITORIAS"; //"file-explorer.php?p=/$destino/AUDITORIAS";
            $urlCertificaciones = "file-explorer.php?p=/$destino/CERTIFICACIONES";
            $urlCotizaciones = "file-explorer.php?p=/$destino/COTIZACIONES";
            $urlPlanos = "file-explorer.php?p=/$destino/PLANOS";

            switch ($destino) {
                case 'RM':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EYjYlh0HZ-FCiruFihcKP_kBNJ_UDlRGrm2T5G6RcTWWJA";
                    break;
                case 'CMU':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EeKYuXc6N39AhgroZ1toiEkBetWHhpJ3kIUmTqhJhqxkLA";
                    break;
                case 'PVR':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EW07u350JqtPpbqb_5HIfHwBoFGwGB4ra6TgvOZG18o9bA";
                    break;
                case 'SSA':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/ERJE7_wJGCtLkQ7jIhP9rXIBHs4kBA1eLC_YxFGGVQEhrQ";
                    break;
                case 'PUJ':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/ESoF-LIzDh5LtlPzlJpBH7wB7b66U8FJVXu3nqasWdNOVg";
                    break;
                case 'MBJ':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EQ2UDswNisBJpLlnqH2rSLcBbLm9d0IIrJk7e-xkVz407A";
                    break;
                case 'CAP':
                    $urlLavanderia = "";
                    break;
            }
        }
        $salida = "<nav id=\"sidebar\" class=\"active\">"
                . "<div class=\"mt-0 text-center\">"
                . "<span class=\"\"><img src=\"svg/mmnlogo2.svg\" width=\"100%\"></span>"
                . "</div>"
                . "<ul class=\"list-unstyled components\">"
                //Dashboard
                . "1<li class=\"\">"
                . "<a href=\"#cm\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span><img src=\"svg/inicio.svg\" width=\"22\"></span>"
                . "<span class=\"spdisplaysemibold align-text-top ml-2 \">CM</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"cm\">"
                . "<li>"
                . "<a href=\"cuadro-mando.php\">"
                . "<span><img src=\"svg/inicio.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Tablero de resultados</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlLavanderia\">"
                . "<span><img src=\"svg/mantenimiento.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Lavanderia</span>"
                . "</a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Planner
                . "<li>"
                . "<a href=\"#planner\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span><img src=\"svg/planner.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold \">Planner</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"planner\">"
                . "<li>"
                . "<a href=\"index.php\">"
                . "<span><img src=\"svg/planner.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Planner 2.0</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<a href=\"#gift\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/entregas.svg\" width=\"22\"></span><span class=\"align-text-top ml-2 spdisplaysemibold\">GIFT</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"gift\">"
                . "<li>"
                . "<a href=\"https://amgift.palladiumhotelgroup.com/\" target=\"_blank\"><span class=\"ml-4\" ><img src=\"svg/pendiente.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">GIFT</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"gift/\"><span class=\"ml-4\" ><img src=\"svg/resumenentregas.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Depurador GIFT</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"sa/index.php\"><span><img src=\"svg/stock.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Subalmacenes</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li>"
                . "<a href=\"reporte-pendientes.php\">"
                . "<span><img src=\"svg/informes.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Reporte pendientes planner</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<a href=\"reporte-pendientes-mp.php\">"
                . "<span><img src=\"svg/informes.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Reporte MP</span>"
                . "</a>"
                . "</li>"
                //Planner - Agenda personal
                . " <li>"
                . "<a href=\"agenda.php\">"
                . "<span><img src=\"svg/agenda.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Agenda Personal</span>"
                . "</a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Mantenimientos
                . "<li>"
                . "<a href=\"#mantenimiento\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/mantenimiento.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Mantenimiento</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"mantenimiento\">"
                . "<a href=\"#\"><span><img src=\"svg/bitacoras.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Bitacoras</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"procesos.php\"><span><img src=\"svg/operacion.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Procesos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"mp-anual.php\"><span><img src=\"svg/mantenimiento.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">MP Anual</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Materiales
                . "<li>"
                . "<a href=\"#materiales\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/almaceninterno.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Gestion de Materiales y Servicios</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"materiales\">"
                . "<li>"
                . "<a href=\"pedidos-entregar.php\"><span><img src=\"svg/pedidos.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Pedidos</span></a>"
                . "</li>"
//                . "<li>"
//                . "<a href=\"stock/stock.php\"><span><img src=\"svg/existencias.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Stock - Existencias</span></a>"
//                . "</li>"
                . "<li>"
                . "<a href=\"stock/stock-necesario.php\"><span><img src=\"svg/stock.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Stock</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"sa/index.php\"><span><img src=\"svg/stock.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Subalmacenes</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"gastos/gastos.php\"><span><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Gastos (Control Interno)</span></a>"
                . "</li>"
                //Instalaciones - Empresas y proveedores
                . "<li>"
                . "<a href=\"empresas.php\"><span><img src=\"svg/empresas.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Empresas y Proveedores</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlCotizaciones\" ><span><img src=\"svg/cotizaciones.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Cotizaciones</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"activos.php\"><span><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Activos</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Gasto
                //Energeticos
                . "<li>"
                . "<a href=\"energeticos.php\"><span><img src=\"svg/energeticos.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Energéticos</span></a>"
                . "</li>"
                //Lavanderia Nueva opcion 2020 
                . "<li>"
                . "<a href=\"lavanderia.php\"><span><img src=\"svg/lavanderia.jpg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Lavanderia <span class='badge badge-secondary'>New</span></span></a>"
                . "</li>"
                //Instalaciones
                . "<li>"
                . "<a href=\"#instalaciones\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span><img src=\"svg/instalaciones.svg\" width=\"22\"></span>"
                . "<span class=\"align-text-top ml-2 spdisplaysemibold\">Instalaciones</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"instalaciones\">"
                //Instalaciones - Equipos
                . "<li>"
                . "<a href=\"mantenimiento/equipos.php\" aria-expanded=\"false\"><span><img src=\"svg/equipos.svg\" width=\"22\"></span><span class=\"align-text-top ml-2 spdisplaysemibold\">Equipos</span></a>"
                . "</li>"
                //Instalaciones - Entregas
                . "<li>"
                . "<a href=\"#entregas\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/entregas.svg\" width=\"22\"></span><span class=\"align-text-top ml-2 spdisplaysemibold\">Entregas</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"entregas\">"
                . "<li>"
                . "<a href=\"entregas/entregas.php\"><span class=\"ml-4\" ><img src=\"svg/pendiente.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Pendientes</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"pruebas-instalaciones.php\"><span class=\"ml-4\" ><img src=\"svg/pruebas.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Pruebas de instalaciones</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"entregas/resumen-entregas.php\"><span class=\"ml-4\" ><img src=\"svg/resumenentregas.svg\" width=\"22\"></span><span class=\"ml-2 spdisplaysemibold align-text-top\">Resumen de entregas</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"

                //Instalaciones - CAPIN y CAPEX
                . "<li>"
                . "<a href=\"#proyectos\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/inicio.svg\" width=\"22\"></span><span class=\"align-text-top ml-2 spdisplaysemibold\">Proyectos</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"proyectos\">"
                . "<li>"
                . "<a href=\"cap.php?tipo=proyecto\" ><span class=\"ml-4\" ><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Proyectos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"cap.php?tipo=capex\" ><span class=\"ml-4\" ><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">CapEx</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"cap.php?tipo=capin\" ><span class=\"ml-4\" ><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">CapIn</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"cap.php?tipo=mae\" ><span class=\"ml-4\" ><img src=\"svg/gastos.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">MAE's</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //DOCUMENTOS 
                . "<li>"
                . "<a href=\"$urlPlanos\" ><span><img src=\"svg/plano.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Planos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlNormativas\" ><span><img src=\"svg/normativa.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Normativas</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlAuditorias\" ><span><img src=\"svg/auditorias.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Auditorias</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlSeguridad\" ><span><img src=\"svg/seguridad.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Seguridad</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlCertificaciones\" ><span><img src=\"svg/certificaciones.svg\" width=\"22\"></span><span class=\"spdisplaysemibold align-text-top ml-2\">Certificaciones</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Personal
                //"<li>"
                //. "<a href=\"personal.php\"><span><img src=\"svg/personal.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Personal y formación</span></a>"
                //"</li>"
                //aplicaciones
                . "<li>"
                . "<a href=\"under-construction.php\"><span><img src=\"svg/aplicaciones.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Aplicaciones</span></a>"
                . "</li>"
                //Reportes
                . "<li>"
                . "<a href=\"#reportes\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/informes.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Reportes</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"reportes\">"
                . "<li>"
                . "<a href=\"avance-mantto-prev.php\"><span><img src=\"svg/mp.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Avance Mantenimiento Preventivo</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"evolutivo.php\"><span><img src=\"svg/evolutivo.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Evolutivo de Quejas ACS y A/C</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"reporte-gift.php\"><span><img src=\"svg/evolutivo.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Reportes GIFT</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li>"
                . "<a href=\"#consultoria\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/consultoria.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Consultoria</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"consultoria\">"
                . "<li>"
                . "<a href=\"consultoria/consultoria-dec.php\"><span><img src=\"svg/dec.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">DEC</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-zhh.php\"><span><img src=\"svg/zha.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">ZHA</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-zia.php\"><span><img src=\"svg/zia.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">ZIA</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-zic.php\"><span><img src=\"svg/zic.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">ZIC</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-zie.php\"><span><img src=\"svg/zie.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">ZIE</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-soporte.php\"><span><img src=\"svg/consultoria.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Soporte y Ayuda</span></a>"
//
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li class=\"\">"
                . "<a href=\"videos.php\">"
                . "<span><img src=\"svg/nuevovideo2.svg\" width=\"22\"></span>"
                . "<span class=\"spdisplaysemibold align-text-top ml-2 \">Videos</span>"
                . "</a>"
                . "</li>"

                //Coronavirus Nueva opcion 2020 

                . "<li>"
                . "<a href=\"#demo\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span><img src=\"svg/Coronavirus.png\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Coronavirus</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"demo\">"
                . "<li>"
                . "<a href=\"staff.html\"><span><img src=\"svg/Coronavirus.png\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Staff</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"cierre-apertura.php\"><span><img src=\"svg/Coronavirus.png\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Tareas Cierre</span></a>"
                . "</li>"
			     . "<li>"
                . "<a href=\"personalyformacion.html\"><span><img src=\"svg/Coronavirus.png\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\"> Personal y Funciones </span></a>"
                . "</li>"
			     . "<li>"
                . "<a href=\"consumo-energetico.html\"><span><img src=\"svg/Coronavirus.png\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\"> Consumo Energético </span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"	
			
                //Fin de ul
                . "</ul>"

	
                //opciones
                . "<ul class=\"list-unstyled CTAs\">"
                . "<li>"
                . "<a href=\"task.php\"><span><img src=\"svg/pendiente.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Pendientes</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"consultoria/consultoria-soporte.php\"><span><img src=\"svg/ayuda.svg\" width=\"22\"></span><span class=\"spdisplaysemibold ml-2 align-text-top\">Ayuda</span></a>"
                . "</li>"
                . "</ul>"
                . "</nav>";
        return $salida;
    }

    public function menuinside($destino) {
        if ($destino == "AME") {
            $destino = "";
            $urlPedidos = "../pedidos";
            $urlSeguridad = "../file-browser";
            $urlNormativas = "../file-browser";
            $urlAuditorias = "../file-browser";
            $urlCertificaciones = "../file-browser";
            $urlCotizaciones = "../file-browser";
            $urlPlanos = "../file-browser";
        } else {
            $urlPedidos = "../pedidos/#maphg/$destino";
            $urlSeguridad = "../file-browser/#maphg/$destino/SEGURIDAD";
            $urlNormativas = "../file-browser/#maphg/$destino/NORMATIVAS";
            $urlAuditorias = "../file-browser/#maphg/$destino/AUDITORIAS";
            $urlCertificaciones = "../file-browser/#maphg/$destino/CERTIFICACIONES";
            $urlCotizaciones = "../file-browser/#maphg/$destino/COTIZACIONES";
            $urlPlanos = "../file-browser/#maphg/$destino/PLANOS";

            switch ($destino) {
                case 'RM':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EYjYlh0HZ-FCiruFihcKP_kBNJ_UDlRGrm2T5G6RcTWWJA";
                    break;
                case 'CMU':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EeKYuXc6N39AhgroZ1toiEkBetWHhpJ3kIUmTqhJhqxkLA";
                    break;
                case 'PVR':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EW07u350JqtPpbqb_5HIfHwBoFGwGB4ra6TgvOZG18o9bA";
                    break;
                case 'SSA':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/ERJE7_wJGCtLkQ7jIhP9rXIBHs4kBA1eLC_YxFGGVQEhrQ";
                    break;
                case 'PUJ':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/ESoF-LIzDh5LtlPzlJpBH7wB7b66U8FJVXu3nqasWdNOVg";
                    break;
                case 'MBJ':
                    $urlLavanderia = "https://palladiumhotelgroup-my.sharepoint.com/:x:/p/asismantenimiento_america/EQ2UDswNisBJpLlnqH2rSLcBbLm9d0IIrJk7e-xkVz407A";
                    break;
            }
        }
        $salida = "
		       <div class=\"bg-gray-800 h-auto w-90 list-unstyled components\">
            <ul class=\"\">
                <li class=\"px-2 mb-1\"><a href=\"cuadro-mando_v1.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">TR</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cuadro-mando_v1.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>tr mantto</a></li>
                <li class=\"px-2 mb-1\"><a href=\"bitacora_mantto.php\" target=\"_blank\"cclass=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>bitacora diaria</a></li>
                <li class=\"px-2 mb-1\"><a href=\"php/lavanderia.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>lavanderia</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>satisfaccion</a></li>
                <li class=\"px-2 mb-1\"><a href=\"evolutivo.php\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>quejas acs</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>reportes de gift</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">MP/MC</a></li>
                <li class=\"px-2 mb-1\"><a href=\"index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>planner</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>gift</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>bitacora</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>temperatura restaurantes</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>temperatura piscinas</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>parámetros del agua</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>gp</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>trs</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>zi</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>procesos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>agenda personal</a></li>
                <li class=\"px-2 mb-1\"><a href=\"energeticos.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">EQUIPOS/LOCALES</a></li>
                <li class=\"px-2 mb-1\"><a href=\"index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Equipos/Despiece</a></li>
                <li class=\"px-2 mb-1\"><a href=\"index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Locales</a></li>
                <li class=\"px-2 mb-1\"><a href=\"index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Consumibles/Herramientas</a></li>
                <li class=\"px-2 mb-1\"><a href=\"energeticos.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">ENERGETICOS</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">GEST. DE MAT. Y SERV.</a></li>
                <li class=\"px-2 mb-1\"><a href=\"sa/index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>subalmacenes</a></li>
                <li class=\"px-2 mb-1\"><a href=\"stock/stock-necesario.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>stock</a></li>
                <li class=\"px-2 mb-1\"><a href=\"pedidos-entregar.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>pedidos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"gastos/gastos.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>gastos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>empresas y proveedores</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>cotizaciones</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>activos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">INSTALACIONES</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>proyectos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cap.php?tipo=proyecto\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>PROYECTOS</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cap.php?tipo=capex\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>CAPEX</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cap.php?tipo=capin\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>CAPIN</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cap.php?tipo=mae\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>MAE´S</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>entregas</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Equipos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"file-explorer.php?p=/RM/PLANOS\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>planos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"file-explorer.php?p=/RM/NORMATIVAS\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>normativas</a></li>
                <li class=\"px-2 mb-1\"><a href=\"tinyfilemanager.php?p=RM/AUDITORIAS\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>auditorias</a></li>
                <li class=\"px-2 mb-1\"><a href=\"file-explorer.php?p=/RM/SEGURIDAD\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>seguridad</a></li>
                <li class=\"px-2 mb-1\"><a href=\"file-explorer.php?p=/RM/CERTIFICACIONES\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>certificaciones</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">CONSULTORIA</a></li>
                <li class=\"px-2 mb-1\"><a href=\"consultoria/consultoria-dec.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>dec</a></li>
                <li class=\"px-2 mb-1\"><a href=\"consultoria/consultoria-zia.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>zia</a></li>
                <li class=\"px-2 mb-1\"><a href=\"consultoria/consultoria-zic.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>zic</a></li>
                <li class=\"px-2 mb-1\"><a href=\"consultoria/consultoria-zie.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>zie</a></li>
                <li class=\"px-2 mb-1\"><a href=\"consultoria/consultoria-zhh.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>zhh</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">PERSONAL</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>gestion</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">APLICACIONES</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>gift</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>2bend</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>abril</a></li>
            </ul>
        </div>
		";
        return $salida;
    }

    public function styles() {
        $salida = "<!-- Bootstrap CSS CDN 1 -->"
                . "<link rel=\"stylesheet\" href=\"css/bootstrap.css\">"
                . "<!-- Our Custom CSS -->"
                . "<link rel=\"stylesheet\" href=\"css/style.css?v=2.3.3\">"
                . "<link rel=\"stylesheet\" href=\"segoe/style.css\">"
                . "<link rel=\"stylesheet\" href=\"fonts/Maison-Neue/fonts.css\">"
                . "<link rel=\"icon\" href=\"svg/mmnlogo.png\">"
                . "<!--CSS Hover-->"
                . "<link href=\"css/hover.css\" rel=\"stylesheet\" media=\"all\">"
                . "<link href=\"themify-icons/themify-icons.css\" rel=\"stylesheet\">"
                . "<link rel=\"stylesheet\" href=\"themify-icons/ie7/ie7.css\">"
                . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\">"
                . "<!-- Scrollbar Custom CSS -->"
                . "<link rel=\"stylesheet\" href=\"css/jquery.mCustomScrollbar.css\">"
                //. "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css\">"
                . "<!-- Font Awesome JS -->"
                . "<link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.8.2/css/all.css\" integrity=\"sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay\" crossorigin=\"anonymous\">"
				."<link rel=\"stylesheet\" href=\"../css/clasesproyectosypendientes.css\">"
			    . "<link rel=\"stylesheet\" href=\"../css/megamenu.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/hover.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/styles_beta.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/tailwind.css\">"
				;
        return $salida;
    }

    public function stylesinside() {
        $salida = "<!-- Bootstrap CSS CDN 2-->"
                . "<link rel=\"stylesheet\" href=\"../css/bootstrap.css\">"
                . "<!-- Our Custom CSS -->"
                . "<link rel=\"stylesheet\" href=\"../css/style.css?v=2.3.3\">"
                . "<link rel=\"stylesheet\" href=\"../segoe/style.css\">"
                . "<link rel=\"stylesheet\" href=\"../fonts/Maison-Neue/fonts.css\">"
                . "<link rel=\"icon\" href=\"../svg/mmnlogo.png\">"
                
				. "<!--CSS Hover-->"
                . "<link href=\"../css/hover.css\" rel=\"stylesheet\" media=\"all\">"
                . "<link href=\"../themify-icons/themify-icons.css\" rel=\"stylesheet\">"
                . "<link rel=\"stylesheet\" href=\"../themify-icons/ie7/ie7.css\">"
                . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\">"
                . "<!-- Scrollbar Custom CSS -->"
                . "<link rel=\"stylesheet\" href=\"../css/jquery.mCustomScrollbar.css\">"
                . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css\">"
                
			. "<!--CSS Hover-->"
                . "<link href=\"../css/hover.css\" rel=\"stylesheet\" media=\"all\">"
                . "<!-- Font Awesome JS -->"
                . "<link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.8.2/css/all.css\" integrity=\"sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay\" crossorigin=\"anonymous\">"
				."<link rel=\"stylesheet\" href=\"../css/clasesproyectosypendientes.css\">"
			    . "<link rel=\"stylesheet\" href=\"../css/megamenu.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/hover.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/styles_beta.css\">"
			    . "<link rel=\"stylesheet\" href=\"../css/all.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/style3.css\">"
				."<link rel=\"stylesheet\" href=\"../css/bulma.css\">"
				 ."<link rel=\"stylesheet\" href=\"../css/clases.css\">"
			;

        return $salida;
    }

    public function scripts() {
        $salida = "<!-- jQuery CDN 3-->"
                . "<script src=\"https://code.jquery.com/jquery-3.3.1.js\" integrity=\"sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=\" crossorigin=\"anonymous\"></script>"
                . "<!-- Popper.JS -->"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js\" integrity=\"sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ\" crossorigin=\"anonymous\"></script>"
                . "<!-- Bootstrap JS -->"
                . "<script src=\"js/bootstrap.js?v=2.3.3\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>"
                . "<!-- jQuery Custom Scroller CDN -->"
                . "<script src=\"js/jquery.mCustomScrollbar.concat.min.js?v=2.3.3\"></script>"
                //. "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js\"></script>"
                . "<!--Custom Scripts-->"
                . "<script src=\"js/agendaJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/bitacorasJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/configuracionJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/empresasJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/entregasJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/equiposJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/evolutivoJS.js?v=2.3.3\"></script> "
                . "<script src=\"js/gastosJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/general.js?v=2.3.3\"></script>"
                . "<script src=\"js/mpJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/materialesJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/mantenimientoJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/tareasJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/usuariosJS.js?v=2.3.3\"></script>"
                . "<script src=\"js/plannerJS.js?v=2.3.3\"></script>"
			. "<script src=\"../js/bulmajs.js?v=4.0\"></script>"
			;


        return $salida;
    }

    public function scriptsinside() {
        $salida = "<!-- jQuery CDN 4-->"
                . "<script src=\"https://code.jquery.com/jquery-3.3.1.js\" integrity=\"sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=\" crossorigin=\"anonymous\"></script>"
                . "<!-- Popper.JS -->"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js\" integrity=\"sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ\" crossorigin=\"anonymous\"></script>"
                . "<!-- Bootstrap JS -->"
                . "<script src=\"../../js/bootstrap.js?v=2.3.3\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>"
                . "<!-- jQuery Custom Scroller CDN -->"
                . "<script src=\"../../js/jquery.mCustomScrollbar.concat.min.js?v=2.3.3\"></script>"
                . "<!--Custom Scripts-->"
                . "<script src=\"../../js/agendaJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/bitacorasJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/configuracionJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/empresasJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/entregasJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/equiposJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/evolutivoJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/gastosJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/general.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/mpJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/materialesJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/mantenimientoJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/tareasJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/usuariosJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/plannerJS.js?v=2.3.3\"></script>"
                . "<script src=\"../../js/validarSesion_1.js\"></script>";

        return $salida;
    }

}

?>
