<style>
.CI {
    width: 5px;
}

.CA {
    width: calc(99% - 5px);
}

a {
    color: white;
}

a:hover {
    color: white;
}
</style>
<!-- <style>
* {
    border: solid red 1px;
}
</style> -->
<!-- INICIO MENU -->
<dav id="sidemenu" class="animated fadeOutLeft menu-contenedor-1">
    <dav class="menu-contenedor-2">
        <dav class="menu-contenedor-3">
            <dav class="menu-contenedor-logo">
                <img src="../svg/logo-white.svg" alt="" class="menu-contenedor-logo-imagen">
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo1" data-toggle="hijo" href="" class="CA">TR</o>
                <i class="fal fa-angle-down CI"></i>
            </dav>
        </dav>
        <dav id="hijo1" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <a href="bitacora_mantto.php" target="_blanck" class="menu-hijo-3 CA">TR Mantto.</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="bitacora_mantto.php" target="_blanck" class="menu-hijo-3 CA">Bitácora diaria</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="lavanderia.php" target="_blanck" class="menu-hijo-3 CA">Lavanderiá</a>
            </dav>
            <dav class="menu-hijo-2">
                <o data-target="nieto1" data-toggle="hijo" href="#" class="menu-hijo-3 CA">Satisfacción</o>
                <i class="fal fa-angle-down menu-hijo-4"></i>
            </dav>
            <dav id="nieto1" class="menu-nieto-1 ocultalo">
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">Quejas ACS</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">Reportes de GIFT</o>
                </dav>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo2" data-toggle="hijo" href="" class="CA">MP/MC</o>
                <i class="fal fa-angle-down"></i>
            </dav>
        </dav>
        <dav id="hijo2" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <a href="index.php" class="menu-hijo-3 CA">Planner</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="https://amgift.palladiumhotelgroup.com/" target="_blanck" class="menu-hijo-3 CA">GIFT</a>
            </dav>
            <dav class="menu-hijo-2">
                <a data-target="nieto2" data-toggle="hijo" href="bitacora_mantto.php" target="_blanck"
                    class="menu-hijo-3 CA">Bitácora</a>
                <i class="fal fa-angle-down menu-hijo-4"></i>
            </dav>
            <dav id="nieto2" class="menu-nieto-1 ocultalo">
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">Temp. restaurantes</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">Temp. piscinas</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">Parametros del agua</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">GP</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">TRS</o>
                </dav>
                <dav class="menu-nieto-2">
                    <o href="#" class="menu-nieto-3 CA">ZI</o>
                </dav>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Procesos</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Agenda Personal</o>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <a href="energeticos.php" target="_blank" class="CA hover:text-black">Energéticos</a>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo3" data-toggle="hijo" href="#" class="CA">Gestion Mat. y Serv.</o>
                <i class="fal fa-angle-down"></i>
            </dav>
        </dav>
        <dav id="hijo3" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <a href="../sa/index.php" target="_blanck" class="menu-hijo-3 CA">Sub almacenes</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="../stock/stock-beta.php" target="_blanck" class="menu-hijo-3 CA">Stock</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="../pedidos-entregar-beta.php" target="_blanck" class="menu-hijo-3 CA">Pedidos</a>
            </dav>
            <dav class="menu-hijo-2">
                <a href="../gastos/gastos-beta.php" target="_blanck" class="menu-hijo-3 CA">Gastos</a>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Empresas y proveedores</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Cotizaciones</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Activos</o>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo4" data-toggle="hijo" href="#" class="CA">Instalaciones</o>
            </dav>
        </dav>
        <dav id="hijo4" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Proyectos</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Entregas</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Planos</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Normativas</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Auditorias</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Seguridad</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Certificaciones</o>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo5" data-toggle="hijo" href="#" class="CA">Consultoria</o>
            </dav>
        </dav>
        <dav id="hijo5" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">DEC</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">ZIA</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">ZIC</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">ZHA</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">SOPORTE</o>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo6" data-toggle="hijo" href="#">Personal</o>
            </dav>
        </dav>
        <dav id="hijo6" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Gestion</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Organigrama</o>
            </dav>
        </dav>
        <dav class="menu-contenedor-padre-1">
            <dav class="menu-contenedor-padre-2">
                <o data-target="hijo7" data-toggle="hijo" href="#" class="CA">Aplicaciones</o>
                <i class="fal fa-angle-down CI"></i>
            </dav>
        </dav>
        <dav id="hijo7" class="menu-hijo-1 ocultalo">
            <dav class="menu-hijo-2">
                <a href="https://amgift.palladiumhotelgroup.com/" target="_blanck" class="menu-hijo-3 CA">GIFT</a>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">2bend</o>
            </dav>
            <dav class="menu-hijo-2">
                <o href="#" class="menu-hijo-3 CA">Abril</o>
            </dav>
        </dav>
    </dav>
    <dav class="menu-contenedor-4 relative">
        <dav class="menu-contenedor-5">
            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=<?= $nombreUsuario ?>"
                alt="avatar" class="menu-contenedor-6">
        </dav>
        <dav class="menu-contenedor-7">
            <h99 class="menu-contenedor-8">Eduardo</h99>
            <pe class="menu-contenedor-10">Developer</pe>
            <o class="menu-contenedor-9" href="" onclick="logout();"><i class="fas fa-cog "></i></o>
        </dav>
    </dav>

</dav>
<!-- FIN MENU -->

<!-- INICIO DESTINO -->
<dav id="sidedestino" class="animated fadeOutRight d1">
    <!-- d1 -->
    <dav id="sideDestinoHijo" class="d2">
        <!-- d2 -->
        <dav class="d3">
            <!-- d3 -->
            <dav class="d4">
                <!-- d4 -->
                <i class="fad fa-map-marker-alt"></i>
            </dav>
        </dav>
        <!-- Padre -->
        <dav class="">
            <!-- d5 -->
            <?php

            if ($destinoT != 10) {
                echo "<a href=\"#\" class=\"hover:text-white d6 m-0 p-2 mb-2\" onclick=\" idDestinoSeleccionado($destinoT); consultaSubalmacen(); botonDestino();\">$arrayDestino[$destinoT]</a>";
            } else {
                $query = "SELECT * FROM c_destinos ORDER BY destino";
                $result = mysqli_query($conn_2020, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $idDestino = $row['id'];
                    $nombreDest = $row['destino'];
                    echo "<a href=\"#\" class=\"hover:text-white d6 m-0 p-2 mb-2\" onclick=\" idDestinoSeleccionado($idDestino); consultaSubalmacen(); botonDestino();\">$nombreDest</a>";
                }
            }
            ?>


        </dav>
    </dav>
</dav>
<!-- FIN DESTINO -->

<script>
function botonMenu() {
    var element = document.getElementById("sidemenu");
    if (element.classList.contains('fadeOutLeft')) {
        element.classList.replace('fadeOutLeft', 'fadeInLeft');
    } else {
        element.classList.replace('fadeInLeft', 'fadeOutLeft');
    }
};

function botonDestino() {
    // $("#sideDestinoHijo").toggleClass('absolute');
    var element = document.getElementById("sidedestino");
    if (element.classList.contains('fadeOutRight')) {
        element.classList.replace('fadeOutRight', 'fadeInRight');
    } else {
        element.classList.replace('fadeInRight', 'fadeOutRight');
    }
};
/* SCRIPT PARA GENERA ID Y OCULTAR HIJOS Y NIETOS */
document.addEventListener('click', function(e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    if (target.getAttribute('data-toggle') == 'hijo') {
        if (target.hasAttribute('data-target')) {
            var m_ID = target.getAttribute('data-target');
            document.getElementById(m_ID).classList.toggle('ocultalo');
            e.preventDefault();
        }
    }
});
</script>