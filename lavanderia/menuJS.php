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
<!-- INICIO MENU -->
<dav id="sidemenu" class="animated fadeOutUp menu-contenedor-1 hidden">
</dav>
<!-- FIN MENU -->

<!-- INICIO DESTINO -->
<dav id="sidedestino" class="animated fadeOutUp invisible d1">
    <!-- d1 -->
    <dav class="d2">
        <!-- d2 -->
        <dav class="d3">
            <!-- d3 -->
            <dav class="d4">
                <!-- d4 -->
                <i class="fad fa-map-marker-alt"></i>
            </dav>
        </dav>
        <!-- Padre -->
        <dav id="destinosSelecciona" class="hidden">
            <a href="#" onclick="cambiarDestino(10)" class="hover:text-white d6 m-0 p-2 mb-2">AME</a>
            <a href="#" onclick="cambiarDestino(11)" class="hover:text-white d6 m-0 p-2 mb-2"> CAP </a>
            <a href="#" onclick="cambiarDestino(7)" class="hover:text-white d6 m-0 p-2 mb-2"> CMU </a>
            <a href="#" onclick="cambiarDestino(6)" class="hover:text-white d6 m-0 p-2 mb-2"> MBJ </a>
            <a href="#" onclick="cambiarDestino(5)" class="hover:text-white d6 m-0 p-2 mb-2"> PUJ </a>
            <a href="#" onclick="cambiarDestino(2)" class="hover:text-white d6 m-0 p-2 mb-2"> PVR </a>
            <a href="#" onclick="cambiarDestino(1)" class="hover:text-white d6 m-0 p-2 mb-2"> RM </a>
            <a href="#" onclick="cambiarDestino(3)" class="hover:text-white d6 m-0 p-2 mb-2"> SDQ </a>
            <a href="#" onclick="cambiarDestino(4)" class="hover:text-white d6 m-0 p-2 mb-2"> SSA </a>
        </dav>
    </dav>
</dav>
<!-- FIN DESTINO -->

<script>
    function botonMenu() {
        var element = document.getElementById("sidemenu");
        if (element.classList.contains('fadeOutUp')) {
            element.classList.replace('fadeOutUp', 'fadeInDown');
            element.classList.remove('invisible');
        } else {
            element.classList.replace('fadeInDown', 'fadeOutUp');
            setTimeout(function() {
                element.classList.add('invisible');
            }, 1000);
        }
    };

    function botonDestino() {
        var element = document.getElementById("sidedestino");
        if (element.classList.contains('fadeOutUp')) {
            element.classList.replace('fadeOutUp', 'fadeInDown');
            element.classList.remove('invisible');

        } else {
            element.classList.replace('fadeInDown', 'fadeOutUp');
            setTimeout(function() {
                element.classList.add('invisible');
            }, 1000);
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