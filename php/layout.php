<?php

/* /Clase con las funciones para crear los menus, agregar los estilos y los scripts que son comunes
 * para todas ventanas de la aplicacion.
 */

Class Layout {
    /*
     * Crea las las etiquedas que van en el header
     * importa las clases CSS necesarias.
     */

    public function styles() {
        $salida = "<meta charset=\"utf-8\">"
                . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">"
                . "<title>MAPHG</title>"
                . "<link rel=\"stylesheet\" href=\"css/lightbox.css\">"
                . "<link rel=\"stylesheet\" href=\"css/bulma.css\">"
                . "<link rel=\"stylesheet\" href=\"css/bulma-docs.min.css\">"
                . "<link rel=\"stylesheet\" href=\"css/bulma-pageloader.min.css\">"
                . "<link rel=\"stylesheet\" href=\"css/bulma-tooltip.css\">"
                . "<link rel=\"stylesheet\" href=\"css/bulma-popover.css\">"
                . "<link rel=\"stylesheet\" href=\"css/clases.css?v=4.0\">"
                . "<link rel=\"stylesheet\" href=\"css/selectize.css\">"
                . "<link rel=\"stylesheet\" href=\"css/all.css\">"
                . "<link rel=\"stylesheet\" href=\"css/style3.css\">"
                . "<link rel=\"icon\" href=\"svg/logo6.png\">"
                . "<script defer src=\"https://use.fontawesome.com/releases/v5.3.1/js/all.js\"></script>"
                . "<link rel=\"stylesheet\" href=\"https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css\">"
                . "<!--CustomScrollbar-->"
                . "<link rel=\"stylesheet\" href=\"css/jquery.mCustomScrollbar.css\">"
                . "<link href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\" rel=\"stylesheet\" />"
                . "<link href=\"css/jquery.multiselect.css\" rel=\"stylesheet\" />"
                . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\">"
                . "<!--CALENDAR-->"
                . "<link href=\"css/bulma-calendar.min.css\" rel=\"stylesheet\">"
                . "<link href=\"css/datepicker.css\" rel=\"stylesheet\" type=\"text/css\">"
                . "<link rel=\"stylesheet\" href=\"css/megamenu.css\">"
                . "<link rel=\"stylesheet\" href=\"css/hover.css\">"
                . "<link rel=\"stylesheet\" href=\"css/styles_beta.css\">"
                . "<link rel=\"stylesheet\" href=\"css/tailwind.css\">"
                . "<link rel=\"stylesheet\" href=\"css/fontawesome/css/all.css\">"
                . "<style>"
                . ".container-scroll{"
                . "overflow-x: auto !important;}"
                . "</style>";

        return $salida;
    }
 
    public function stylesWithin() {
        $salida = "<meta charset=\"utf-8\">"
                . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">"
                . "<title>MAPHG</title>"
                . "<link rel=\"stylesheet\" href=\"../css/lightbox.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/bulma.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/bulma-docs.min.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/bulma-pageloader.min.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/bulma-tooltip.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/bulma-popover.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/clases.css?v=4.0\">"
                . "<link rel=\"stylesheet\" href=\"../css/selectize.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/all.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/style3.css\">"
                . "<link rel=\"icon\" href=\"../svg/logo6.png\">"
                . "<script defer src=\"https://use.fontawesome.com/releases/v5.3.1/js/all.js\"></script>"
                . "<link rel=\"stylesheet\" href=\"https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css\">"
                . "<!--CustomScrollbar-->"
                . "<link rel=\"stylesheet\" href=\"../css/jquery.mCustomScrollbar.css\">"
                . "<link href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\" rel=\"stylesheet\" />"
                . "<link href=\"../css/jquery.multiselect.css\" rel=\"stylesheet\" />"
                . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\">"
                . "<!--CALENDAR-->"
                . "<link href=\"../css/bulma-calendar.min.css\" rel=\"stylesheet\">"
                . "<link href=\"../css/datepicker.css\" rel=\"stylesheet\" type=\"text/css\">"
                . "<link rel=\"stylesheet\" href=\"../css/megamenu.css\">"
                . "<link rel=\"stylesheet\" href=\"../css/hover.css\">"
                . "<link rel=\"stylesheet\" href=\"css/styles_beta.css\">"
                . "<link rel=\"stylesheet\" href=\"css/tailwind.css\">"
                . "<link rel=\"stylesheet\" href=\"css/fontawesome/css/all.css\">"
                . "<style>"
                . ".container-scroll{"
                . "overflow-x: auto !important;}"
                . "</style>";

        return $salida;
    }

    /*
     * Importa los scripts necesarios, asi como el jquery y las librerias JS necesarias.
     */

    public function scripts() {
        $salida = "<script src=\"https://code.jquery.com/jquery-3.3.1.js\" integrity=\"sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=\" crossorigin=\"anonymous\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js\" integrity=\"sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ\" crossorigin=\"anonymous\"></script>"
                . "<script src=\"js/lightbox-plus-jquery.min.js\"></script>"
                . "<script src=\"js/bulmajs.js?v=4.0\"></script>"
                . "<script src=\"js/bootstrap.js\"></script>"
                . "<script src=\"js/usuariosJS.js\"></script>"
                . "<script src=\"js/main.js\"></script>"
                . "<script src=\"js/selectize.js\"></script>"
                . "<script src=\"https://code.jquery.com/jquery-1.12.4.js\"></script>"
                . "<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>"
                . "<script src=\"js/jquery.multiselect.js\"></script>"
                . "<script src=\"js/jquery.mCustomScrollbar.concat.min.js?v=2.1.2\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>"
                . "<script src=\"js/bulma-calendar.min.js\"></script>"
                . "<script src=\"js/datepicker.min.js\"></script>"
                . "<!-- Include English language -->"
                . "<script src=\"js/i18n/datepicker.es.js\"></script>";

        return $salida;
    }

    public function scriptsWithin() {
        $salida = "<script src=\"https://code.jquery.com/jquery-3.3.1.js\" integrity=\"sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=\" crossorigin=\"anonymous\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js\" integrity=\"sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ\" crossorigin=\"anonymous\"></script>"
                . "<script src=\"../js/lightbox-plus-jquery.min.js\"></script>"
                . "<script src=\"../js/bulmajs.js?v=4.0\"></script>"
                . "<script src=\"../js/bootstrap.js\"></script>"
                . "<script src=\"../js/usuariosJS.js\"></script>"
                . "<script src=\"../js/main.js\"></script>"
                . "<script src=\"../js/selectize.js\"></script>"
                . "<script src=\"https://code.jquery.com/jquery-1.12.4.js\"></script>"
                . "<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>"
                . "<script src=\"../js/jquery.multiselect.js\"></script>"
                . "<script src=\"../js/jquery.mCustomScrollbar.concat.min.js?v=2.1.2\"></script>"
                . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>"
                . "<script src=\"../js/bulma-calendar.min.js\"></script>"
                . "<script src=\"../js/datepicker.min.js\"></script>"
                . "<!-- Include English language -->"
                . "<script src=\"../js/i18n/datepicker.es.js\"></script>";

        return $salida;
    }

    /*
     * Crea el menu de la aplicacion, para que si una ruta es modificada sea mas facil la actualizacion del codigo.
     */

    public function menu2() {
        $salida = "<div id=\"navMenuPpal\" class=\"navbar-menu\">"
                . "<div class=\"navbar-start\">"
                //********MENU PRINCIPAL - MEGA MENU**********
                . "<div class=\"navbar-item has-dropdown is-hoverable is-mega\">"
                . "<div class=\"navbar-link\">"
                . "Menu"
                . "</div>"
                . "<div class=\"navbar-dropdown\">"
                . "<div class=\"container is-fluid\">"
                . "<div class=\"columns\">"
                //********PLANNER**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Planner</h1>"
                . "<a class=\"navbar-item\" href=\"index.php\">"
                . "Planner"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Reporte de pendientes"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Agenda personal"
                . "</a>"
                . "</div>"
                //********MANTENIMIENTO**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Mantenimiento</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Bitacoras"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Procesos"
                . " </a>"
                . "</div>"
                //********GESTION DE MATERIALES**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Gestion Mat. y Serv.</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Pedidos por entregar"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"stock.php\">"
                . "Stock"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"gastos/gastos.php\">"
                . "Gastos (control interno)"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Empresas y Proveedores"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Cotizaciones"
                . "</a>"
                . "</div>"
                //********INSTALACIONES**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Instalaciones</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Equipos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Entregas"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"proyectos.php\">"
                . "Proyectos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . " Planos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Normativas"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Auditorias"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Seguridad"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Certificados"
                . "</a>"
                . "</div>"
                //********REPORTES**************
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Reportes</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Avance mantto prev."
                . "</a>"
                . "<a class=\"navbar-item\" href=\"evolutivo.php\">"
                . "Evolutivo quejas ACS y A/C"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Reportes GIFT"
                . "</a>"
                . "</div>"
                //USUARIO
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Usuario</h1>"
                . "<a class=\"navbar-item\" href=\"perfil.php\">"
                . "Perfil"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"configuraciones.php\">"
                . "Configuraciones"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\" onClick=\"showModal('modalLogout');\">"
                . "Cerrar sesión"
                . " </a>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                //********CM**********
                . "<a class=\"navbar-item\" href=\"#\">"
                . "CM"
                . "</a>"
                //********ENERGETICOS**********
                . "<a class=\"navbar-item\" href=\"energeticos.php\">"
                . "Energéticos"
                . "</a>"
                //********CUENTAS DE USUARIO Y PERSONAL**********
                . "<a class=\"navbar-item\" href=\"personal.php\">"
                . "Personal"
                . "</a>"
                //************CONSULTORIA*********
                . "<a class=\"navbar-item\" href=\"\">"
                . "Consultoria"
                . "</a>"
                //********VIDEOS Y TUTORIALES**********
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Videos"
                . "</a>"
                . "</div>"
                . "</div>";

        return $salida;
    }

    public function menuWithin2() {
        $salida = "<div id=\"navMenuPpal\" class=\"navbar-menu\">"
                . "<div class=\"navbar-start\">"
                //********MENU PRINCIPAL - MEGA MENU**********
                . "<div class=\"navbar-item has-dropdown is-hoverable is-mega\">"
                . "<div class=\"navbar-link\">"
                . "Menu"
                . "</div>"
                . "<div class=\"navbar-dropdown\">"
                . "<div class=\"container is-fluid\">"
                . "<div class=\"columns\">"
                //********PLANNER**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Planner</h1>"
                . "<a class=\"navbar-item\" href=\"../index.php\">"
                . "Planner"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Reporte de pendientes"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Agenda personal"
                . "</a>"
                . "</div>"
                //********MANTENIMIENTO**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Mantenimiento</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Bitacoras"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Procesos"
                . " </a>"
                . "</div>"
                //********GESTION DE MATERIALES**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Gestion Mat. y Serv.</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Pedidos por entregar"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"../stock.php\">"
                . "Stock"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"../gastos/gastos.php\">"
                . "Gastos (control interno)"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Empresas y Proveedores"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Cotizaciones"
                . "</a>"
                . "</div>"
                //********INSTALACIONES**********
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Instalaciones</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Equipos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Entregas"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"../proyectos.php\">"
                . "Proyectos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . " Planos"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Normativas"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Auditorias"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Seguridad"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Certificados"
                . "</a>"
                . "</div>"
                //********REPORTES**************
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Reportes</h1>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Avance mantto prev."
                . "</a>"
                . "<a class=\"navbar-item\" href=\"../evolutivo.php\">"
                . "Evolutivo quejas ACS y A/C"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Reportes GIFT"
                . "</a>"
                . "</div>"
                //USUARIO
                . "<div class=\"column\">"
                . "<h1 class=\"title is-6 is-mega-menu-title\">Usuario</h1>"
                . "<a class=\"navbar-item\" href=\"../perfil.php\">"
                . "Perfil"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"../configuraciones.php\">"
                . "Configuraciones"
                . "</a>"
                . "<a class=\"navbar-item\" href=\"#\" onClick=\"showModal('modalLogout');\">"
                . "Cerrar sesión"
                . " </a>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                //********CM**********
                . "<a class=\"navbar-item\" href=\"#\">"
                . "CM"
                . "</a>"
                //********ENERGETICOS**********
                . "<a class=\"navbar-item\" href=\"../energeticos.php\">"
                . "Energéticos"
                . "</a>"
                //********CUENTAS DE USUARIO Y PERSONAL**********
                . "<a class=\"navbar-item\" href=\"../personal.php\">"
                . "Personal"
                . "</a>"
                //************CONSULTORIA*********
                . "<a class=\"navbar-item\" href=\"\">"
                . "Consultoria"
                . "</a>"
                //********VIDEOS Y TUTORIALES**********
                . "<a class=\"navbar-item\" href=\"#\">"
                . "Videos"
                . "</a>"
                . "</div>"
                . "</div>";

        return $salida;
    }

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
                case 'SDQ':
                    $urlLavanderia = "";
            }
        }
        // "<ul class=\"list-unstyled components\">"
        $salida =
            "
        <div class=\"bg-gray-800 h-auto w-90 list-unstyled components\">
            <ul class=\"\">
                <li class=\"px-2 mb-1\"><a href=\"cuadro-mando_v1.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">TR</a></li>
                <li class=\"px-2 mb-1\"><a href=\"cuadro-mando_v1.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>tr mantto</a></li>
                <li class=\"px-2 mb-1\"><a href=\"bitacora_mantto.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Bitacora diaria</a></li>
                <li class=\"px-2 mb-1\"><a href=\"php/lavanderia.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>lavanderia</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>satisfaccion</a></li>
                <li class=\"px-2 mb-1\"><a href=\"evolutivo.php\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>quejas acs</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize  pl-6 pr-2 rounded-md block py-1 text-gray-100 font-normal hover:bg-gray-500\"><i class=\"fad fa-dot-circle mr-2 fa-sm\"></i>reportes de gift</a></li>
                <li class=\"px-2 mb-1\"><a href=\"#\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-bold bg-gray-900\">MP/MC</a></li>
                <li class=\"px-2 mb-1\"><a href=\"index.php\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>planner</a></li>
                <li class=\"px-2 mb-1\"><a href=\"https://amgift.palladiumhotelgroup.com\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>gift</a></li>
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
                <li class=\"px-2 mb-1\"><a href=\"../stock/stock-beta.php\" target=\"blanck_\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>stock</a></li>
                <li class=\"px-2 mb-1\"><a href=\"../pedidos-entregar-beta.php\" target=\"blanck_\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>pedidos</a></li>
                <li class=\"px-2 mb-1\"><a href=\"../gastos/gastos-beta.php\" target=\"blanck_\" class=\"capitalize rounded-md block p-1 pl-2 text-gray-100 font-medium hover:bg-gray-700\"><i class=\"fad fa-angle-right mr-2\"></i>Gastos</a></li>
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

    public function menuWithin($destino) {
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
                case 'CAP':
                    $urlLavanderia = "";
                    break;
                case 'SDQ':
                    $urlLavanderia = "";
            }
        }

        $salida = "<ul class=\"list-unstyled components\">"
                //Dashboard
                . "<li class=\"\">"
                . "<a href=\"#cm\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span class=\"t-normal-menu align-text-top  \">TR</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"cm\">"
                . "<li>"
                . "<a href=\"../cuadro-mando.php\">"
                . "<span class=\"align-text-top  t-normal-menu\">Ingenieria y Servicios Técnicos</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<li>"
                . "<a href=\"$urlLavanderia\">"
                . "<span class=\"align-text-top  t-normal-menu\">Lavanderia</span>"
                . "</a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Planner
                . "<li>"
                . "<a href=\"#planner\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span class=\"t-normal-menu align-text-top \">Planner</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"planner\">"
                . "<li>"
                . "<a href=\"../index.php\">"
                . "<span class=\"align-text-top  t-normal-menu\">Planner</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<a href=\"#gift\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"align-text-top  t-normal-menu\">GIFT</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"gift\">"
                . "<li>"
                . "<a href=\"https://amgift.palladiumhotelgroup.com/\" target=\"_blank\"><span class=\" t-normal-menu align-text-top\">GIFT</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../gift/\"><span class=\" t-normal-menu align-text-top\">Depurador GIFT</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../sa/index.php\"><span class=\" t-normal-menu align-text-top\">Subalmacenes</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li>"
                . "<a href=\"../reporte-pendientes.php\">"
                . "<span class=\"align-text-top  t-normal-menu\">Reporte pendientes planner</span>"
                . "</a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../reporte-pendiente-mps.php\">"
                . "<span class=\"align-text-top  t-normal-menu\">Reporte MP</span>"
                . "</a>"
                . "</li>"
                //Planner - Agenda personal
                . " <li>"
                . "<a href=\"../agenda.php\">"
                . "<span class=\"t-normal-menu align-text-top \">Agenda Personal</span>"
                . "</a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Mantenimiento
                . "<li>"
                . "<a href=\"#mantenimiento\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"t-normal-menu  align-text-top\">Mantenimiento</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"mantenimiento\">"
                . "<li>"
                . "<a href=\"#\"><span class=\" t-normal-menu align-text-top\">Bitacoras</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../procesos.php\"><span class=\" t-normal-menu align-text-top\">Procesos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../mp-anual.php\"><span class=\" t-normal-menu align-text-top\">MP Anual</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Materiales
                . "<li>"
                . "<a href=\"#materiales\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"t-normal-menu  align-text-top\">Gestion Materiales y Servicios</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"materiales\">"
                . "<li>"
                . "<a href=\"../pedidos-entregar.php\"><span class=\"t-normal-menu  align-text-top\">Pedidos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../stock/stock-necesario.php\"><span class=\"t-normal-menu  align-text-top\">Stock</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../sa/index.php\"><span class=\" t-normal-menu align-text-top\">Subalmacenes</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../gastos/gastos.php\"><span class=\"t-normal-menu  align-text-top\">Gastos (Control Interno)</span></a>"
                . "</li>"
                //Instalaciones - Empresas y proveedores
                . "<li>"
                . "<a href=\"../empresas.php\"><span class=\"t-normal-menu align-text-top \">Empresas y Proveedores</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlCotizaciones\" ><span class=\"t-normal-menu align-text-top \">Cotizaciones</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../activos.php\"><span class=\" t-normal-menu align-text-top\">Activos</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Gastos
                //Energeticos
                . "<li>"
                . "<a href=\"../energeticos.php\"><span class=\"t-normal-menu  align-text-top\">Energéticos</span></a>"
                . "</li>"
                //Instalaciones
                . "<li>"
                . "<a href=\"#instalaciones\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\">"
                . "<span class=\"t-normal-menu align-text-top \">Instalaciones</span>"
                . "</a>"
                . "<ul class=\"collapse list-unstyled\" id=\"instalaciones\">"
                //Instalaciones - Equipos
                . "<li>"
                . "<a href=\"../mantenimiento/equipos.php\"  aria-expanded=\"false\"><span class=\"t-normal-menu align-text-top \">Equipos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"#entregas\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"align-text-top  t-normal-menu\">Entregas</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"entregas\">"
                . "<li>"
                . "<a href=\"../entregas/entregas.php\"><span class=\" t-normal-menu align-text-top\">Pendientes</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../pruebas-instalaciones.php\"><span class=\" t-normal-menu align-text-top\">Pruebas de instalaciones</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../entregas/resumen-entregas.php\"><span class=\" t-normal-menu align-text-top\">Resumen de entregas</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"

                //Instalaciones - CAPIN y CAPEX
                . "<li>"
                . "<a href=\"#proyectos\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"align-text-top  t-normal-menu\">Proyectos</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"proyectos\">"
                . "<li>"
                . "<a href=\"../cap.php?tipo=proyecto\" ><span class=\"t-normal-menu align-text-top \">Proyectos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../cap.php?tipo=capex\" ><span class=\"t-normal-menu align-text-top \">CapEx</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../cap.php?tipo=capin\" ><span class=\"t-normal-menu align-text-top \">CapIn</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"

                //DOCUMENTOS
                . "<li>"
                . "<a href=\"$urlPlanos\"><span class=\"t-normal-menu align-text-top \">Planos</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlNormativas\"><span class=\"t-normal-menu align-text-top \">Normativas</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlAuditorias\"><span class=\"t-normal-menu align-text-top \">Auditorias</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlSeguridad\"><span class=\"t-normal-menu align-text-top \">Seguridad</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"$urlCertificaciones\"><span class=\"t-normal-menu align-text-top \">Certificaciones</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                //Personal
                . "<li>"
                . "<a href=\"../personal.php\"><span class=\"t-normal-menu  align-text-top\">Personal y formación</span></a>"
                . "</li>"
                //aplicaciones
                . "<li>"
                . "<a href=\"../under-construction.php\"><span class=\"t-normal-menu  align-text-top\">Aplicaciones</span></a>"
                . "</li>"
                //Reportes
                . "<li>"
                . "<a href=\"#reportes\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"t-normal-menu align-text-top\">Reportes</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"reportes\">"
                . "<li>"
                . "<a href=\"../avance-mantto-prev.php\"><span class=\"t-normal-menu  align-text-top\">Avance Mantenimiento Preventivo</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../evolutivo.php\"><span class=\"t-normal-menu  align-text-top\">Evolutivo de Quejas ACS y A/C</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../reporte-gift.php\"><span class=\"t-normal-menu  align-text-top\">Reportes GIFT</span></a>"
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li>"
                . "<a href=\"#consultoria\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle\"><span class=\"t-normal-menu  align-text-top\">Consultoria</span></a>"
                . "<ul class=\"collapse list-unstyled\" id=\"consultoria\">"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-dec.php\"><span class=\"t-normal-menu  align-text-top\">DEC</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-zhh.php\"><span class=\"t-normal-menu  align-text-top\">ZHA</span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-zia.php\"><span class=\"t-normal-menu  align-text-top\">ZIA</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-zic.php\"><span class=\"t-normal-menu  align-text-top\">ZIC</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-zie.php\"><span class=\"t-normal-menu  align-text-top\">ZIE</span></a>"
//
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-soporte.php\"><span class=\"t-normal-menu  align-text-top\">Soporte y Ayuda</span></a>"
//
                . "</li>"
                . "</ul>"
                . "</li>"
                . "<li class=\"\">"
                . "<a href=\"../videos.php\">"
                . "<span class=\"t-normal-menu align-text-top  \">Videos</span>"
                . "</a>"
                . "</li>"
                //Fin de ul
                . "</ul>"
                //opciones
                . "<ul class=\"list-unstyled CTAs\">"
                . "<li>"
                . "<a href=\"../task.php\"><span class=\"t-normal-menu  align-text-top\">Pendientes</span></span></a>"
                . "</li>"
                . "<li>"
                . "<a href=\"../consultoria/consultoria-soporte.php\"><span class=\"t-normal-menu  align-text-top\">Ayuda</span></a>"
                . "</li>"
                . "</ul>";
        return $salida;
    }

    public function dropDownDestinos() {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<div class=\"navbar-dropdown\">";

        $query = "SELECT * FROM c_destinos ORDER BY destino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDest = $dts['id'];
                    $nombreDest = $dts['destino'];
                    $salida .= "<a href=\"#\" onclick=\"cargarTareasDestino(0, $idDest);\" class=\"navbar-item\">$nombreDest</a>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $salida .= "</div>";
        $conn->cerrar();
        return $salida;
    }
    
    public function dropDownDestinosWithin() {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<div class=\"navbar-dropdown\">";

        $query = "SELECT * FROM c_destinos ORDER BY destino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDest = $dts['id'];
                    $nombreDest = $dts['destino'];
                    $salida .= "<a href=\"#\" onclick=\"cargarTareasDestino(1, $idDest);\" class=\"navbar-item\">$nombreDest</a>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $salida .= "</div>";
        $conn->cerrar();
        return $salida;
    }
    
    public function pageLoader(){
        $salida = "<div id=\"loader\" class=\"pageloader is-active\"><span class=\"title\">Cargando...</span></div>";
    }

}

?>