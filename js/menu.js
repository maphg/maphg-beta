class menuSidebar extends HTMLElement {

    constructor() {
        super();
        this.clases;
    }

    static get observedAttributes() {
        return ['clases'];
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        this.clases = newValue;
    }

    connectedCallback() {
        this.innerHTML = `
            <div class="w-full flex flex-col mt-0 pb-0 ${this.clases}">
                <header class="flex items-center h-16 px-6 sm:px-10 bg-white">
                    <div class="w-full max-w-md sm:-ml-2 flex">
                        <button id="btnAbrirMenu"
                            class="w-10 h-10 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full flex justify-center items-center">
                            <img src="svg/menu.svg" class="w-5" alt="">
                        </button>
                        <img src="svg/log.svg" class="w-20 ml-6" alt="">
                    </div>
                    <div class="flex flex-shrink-0 items-center ml-auto">
                        <div id="btnConfiguracionesUsuario">
                            <button class="inline-flex items-center px-2 mr-1 hover:bg-gray-100 focus:bg-gray-100 rounded-lg">
                                <span class="sr-only">User Menu</span>
                                <div class="hidden md:flex md:flex-col md:items-end md:leading-tight">
                                    <span id="nombreUsuario" class="font-semibold"></span>
                                    <span id="cargoUsuario" class="text-sm text-gray-600"></span>
                                </div>
                                <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden relative">
                                    <img id="avatarUsuario" src="planner/avatars/AVATAR_ID_0_0.svg" alt="user profile photo"
                                        class="h-full w-full object-cover">
                                        <input id="subirAvatarUsuario" type="file" class="opacity-0 h-12 w-full absolute top-0" style="left:-10px;">
                                </span>
                                <svg aria-hidden="true" viewBox="0 0 20 20" fill="currentColor"
                                    class="hidden sm:block h-6 w-6 text-gray-300">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div id="btnDestinosUsuario" class="border-l pl-3">
                            <button
                                class="relative px-2 h-8 bg-cyan-100 text-cyan-500 hover:bg-gray-100 rounded-md flex items-center">
                                <i class="fas fa-map-marker-alt fa-xs"></i>
                                <h1 id="destinoUsuario" class="font-bold text-sm ml-1"></h1>
                            </button>
                        </div>
                    </div>
                </header>

                <div class="w-full px-8">
                    <div class="relative">

                        <!-- Dropdown Configuraciones -->
                        <div id="configuracionesUsuario"
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-20 animated hidden">
                            <div class="py-2">
                                <a id="btnAbrirNotificaciones" href="#"
                                    class="flex items-center px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2">
                                    <div class="h-8 w-8  flex flex-none justify-center items-center "><img src="svg/campana.svg"
                                            class="w-full" alt=""></div>
                                    <p class="text-gray-600 dark:text-white text-sm mx-2">
                                        <span class="font-bold" href="#">Incidencias Asignadas</span> Usted tiene
                                        <span id="incidenciasAsignadasUsuario" class="font-bold text-blue-500" href="#">0</span>
                                        Incidencias aignadas.
                                    </p>
                                </a>
                                <a id="btnAbrirAgenda" href="#"
                                    class="flex items-center px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2">
                                    <div class="h-8 w-8 flex flex-none justify-center items-center "><img
                                            src="svg/calendario.svg" class="w-full" alt=""></div>
                                    <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold">
                                        Agenda Personal
                                    </p>
                                </a>
                                <a id="btnAbrirFavoritos" href="#"
                                    class="flex items-center px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2">
                                    <div class="h-8 w-8 flex flex-none justify-center items-center "><img
                                            src="svg/favoritos2.svg" class="w-full" alt=""></div>
                                    <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold">
                                        Favoritos
                                    </p>
                                </a>
                                <a id="btnAbrirTelegram" href="#" onclick="modalOpenClose('modalConfigurarTelegram')"
                                    class="flex items-center px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2">
                                    <div class="h-8 w-8 flex flex-none justify-center items-center "><img
                                            src="svg/logo_telegram.svg" class="w-full" alt=""></div>
                                    <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold">
                                        Configurar Notificaciones
                                    </p>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2">
                                    <div class="h-8 w-8 flex flex-none justify-center items-center "><img src="svg/ajustes.svg"
                                            class="w-full" alt=""></div>
                                    <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold">
                                        Mi cuenta
                                    </p>
                                </a>
                            </div>
                            <a href="#" onclick="cerrarSesion();" class="block bg-gray-800 dark:bg-gray-700 text-white text-center hover:underline font-bold py-2">Cerrar Sesión</a>
                        </div>
                    </div>

                    <!-- Dropdown Destinos -->
                    <div id="destinosUsuario" class="relative mt-80 animated hidden">
                        <!-- Dropdown menu -->
                        <div id="destinosSelecciona" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-20">
                            <div id="dataDestinosUsuario" class="py-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

class menu extends HTMLElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.innerHTML = `
            <div id="contenedorMenu" class="hidden w-full h-screen bg-white z-50 bg-gray-900 bg-opacity-50 absolute animated">
                <div class="w-64 h-full h-screen bg-white flex flex-col absolute opacity-100 z-50 shadow-md justify-start animated">

                    <div class="flex items-center justify-start relative p-2">
                        <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center">
                            <img id="avatarMenuUsuario" src="planner/avatars/AVATAR_ID_0_0.svg" _mstvisible="4">
                        </div>
                        <div class="flex flex-col leading-none ml-2">
                            <h1 class="text-gray-400 text-xs">Bienvenido,</h1>
                            <h1 id="nombreUsuarioMenu" class="font-bold text-gray-600"></h1>
                        </div>
                        <div id="btnCerrarMenu" class=" absolute top-0 right-0 text-gray-400 hover:text-cyan-200">
                            <button><i class="fal fa-times p-2 fa-lg"></i></button>
                        </div>
                    </div>

                    <div
                        class="w-full flex flex-col bg-gray-50 border-b border-gray-100 py-3 text-xs font-semibold text-gray-600 px-10">

                        <div class="flex hover:bg-gray-100 py-1 cursor-pointer px-2 rounded">
                            <div class="w-4 mr-1">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h1>Mis ajustes</h1>
                        </div>

                        <div class="flex hover:bg-gray-100 py-1 cursor-pointer px-2 rounded">
                            <div class="w-4 mr-1">
                                <i class="fas fa-bell"></i>
                            </div>
                            <h1>Mi pendientes</h1>
                        </div>
                        <div class="flex hover:bg-gray-100 py-1 cursor-pointer px-2 rounded">
                            <div class="w-4 mr-1">
                                <i class="fas fa-books"></i>
                            </div>
                            <h1>Documentación</h1>
                        </div>

                    </div>

                    <div class="overflow-y-auto scrollbar" style="height: 60vh;">
                        <div id="dataMenu" class="w-full flex flex-col bg-white border-b border-gray-100 py-3 text-xs font-semibold text-gray-600 px-10"></div>
                    </div>
                    
                    <div class="w-full flex flex-row items-center justify-center bg-gray-50 border-b border-gray-100 py-3">
                        <div
                            class="flex w-20 py-1 cursor-pointer px-1 rounded-full justify-center items-center bg-gray-900 text-white hover:shadow-md text-xxs">
                            <h1 class=" font-semibold">Soporte</h1>
                        </div>
                    </div>

                </div>
                <div id="menuBG" class="h-full h-screen animated"></div>
            </div>        
        `;
    }
}


class nofiticaciones extends HTMLElement {
    constructor() {
        super();
        this.clases;
    }

    static get observedAttributes() {
        return ['clases'];
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        this.clases = newValue;
    }
    connectedCallback() {
        this.innerHTML = `
            <div id="contenedorNotifiaciones" class="hidden w-full absolute top-0 right-0 z-50 bg-gray-900 bg-opacity-50 animated ${this.clases}">
                <div class="flex justify-end h-screen absolute top-0 right-0 animated">
                    <div class="w-72 p-2 flex flex-col" style="background-color: #5B30AD;">
                        <div class="p-2 mb-2 text-xs text-justify flex flex-col h-12 flex items-center justify-center relative overflow-hidden">
                            <img src="svg/noti.gif" class="w-24 absolute" alt="">
                            <div id="btnCerrarNotificaciones" class=" absolute top-0 right-0 text-gray-400 hover:text-cyan-200">
                                <button><i class="fal fa-times p-2 fa-lg"></i></button>
                            </div>
                        </div>

                        <div class="bg-white shadow p-2 rounded-r mb-2 text-xs text-justify flex flex-col border-l-2 border-red-500">
                            <div class="flex w-full items-center">
                                <div class="w-6 h-6 bg-red-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                    <h1 class="font-bold text-red-500">I</h1>
                                </div>
                                <p><span class="font-bold">Pedro rego</span> te asigno una <span class="font-bold">incidencia</span> tipo <span class="text-red-500 font-bold uppercase text-xxs">URGENCIA</span> "Lorem ipsum dolor sit "</p>
                            </div>
                            <div class="w-full flex mt-1 justify-evenly">
                                <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-yellow-500 rounded"><i class="fas fa-star"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                        <div class="bg-white shadow p-2 rounded-r mb-2 text-xs text-justify flex flex-col border-l-2 border-blue-500">
                            <div class="flex w-full items-center">
                                <div class="w-6 h-6 bg-blue-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                    <h1 class="font-bold text-blue-500">MP</h1>
                                </div>
                                <p><span class="font-bold">Pedro rego</span> te asigno una <span class="font-bold">OT MP</span> numero <span class="text-red-500 font-bold uppercase text-xxs">12312</span> "Lorem ipsum dolor sit "</p>
                            </div>
                            <div class="w-full flex mt-1 justify-evenly">
                                <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-yellow-500 rounded"><i class="fas fa-star"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                        <div class="bg-white shadow p-2 rounded-r mb-2 text-xs text-justify flex flex-col border-l-2 border-purple-500">
                            <div class="flex w-full items-center">
                                <div class="w-6 h-6 bg-purple-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                    <h1 class="font-bold text-purple-500">P</h1>
                                </div>
                                <p><span class="font-bold">Pedro rego</span> te asigno un <span class="font-bold">PROYECTO</span> "Lorem ipsum dolor sit" en <span class="font-bold">ZIA</span></p>
                            </div>
                            <div class="w-full flex mt-1 justify-evenly">
                                <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-yellow-500 rounded"><i class="fas fa-star"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                        <div class="bg-white shadow p-2 rounded-r mb-2 text-xs text-justify flex flex-col border-l-2 border-purple-500">
                            <div class="flex w-full items-center">
                                <div class="w-6 h-6 bg-purple-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                    <h1 class="font-bold text-purple-500 text-xxs">PDA</h1>
                                </div>
                                <p><span class="font-bold">Pedro rego</span> te asigno un <span class="font-bold">Plan de accion</span>"Lorem ipsum dolor sit" en el proyecto <span class="font-bold">NOMBRE DEL PORYECTO</span></p>
                            </div>
                            <div class="w-full flex mt-1 justify-evenly">
                                <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-yellow-500 rounded"><i class="fas fa-star"></i></button>
                                <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="notificacionesBG" class="h-screen animated"></div>
            </div>
        `;
    }
}

class telegram extends HTMLElement {
    constructor() {
        super();
        this.clases;
    }

    static get observedAttributes() {
        return ['clases'];
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        this.clases = newValue;
    }
    connectedCallback() {
        this.innerHTML = `
            <div id="contenedorTelegram" class="hidden w-full absolute top-0 z-50 bg-gray-900 bg-opacity-50 animated ${this.clases}">
                <div class="w-72 flex flex-col bg-white shadow-md animated absolute top-0 right-0 h-screen">
                    <div class=" w-72 p-2 flex flex-col bg-white shadow-md">
                        <div class="p-2 mb-2 text-xs text-justify flex flex-col h-12 flex items-center justify-center relative overflow-hidden">
                            <img src="svg/telegram.gif" class="absolute" alt="">
                            <div id="btnCerrarTelegram" class="absolute top-0 right-0 text-gray-400 hover:text-cyan-200">
                                <button><i class="fal fa-times p-2 fa-lg"></i></button>
                            </div>
                        </div>
                        <div class="bg-white rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer p-4">
                            <img src="svg/qr.svg" class="" alt="">
                            <h1 class="font-semibold text-justify mt-2">1) Escanea el codigo QR con la cámara de tu movil</h1>
                            <h1 class="font-semibold text-justify mt-2">2) Preciona iniciar en el BOT</h1>
                            <h1 class="font-semibold text-justify mt-2">3) Ingresa a continuacion tu código</h1>
                            <input id="codigoTelegram" type="text" placeholder="Ingresa tu codigo" class="p-2 mt-2 bg-blue-200 text-blue-500 rounded">
                            <button id="btnCodigoTelegram" class="bg-blue-300 mt-2 rounded text-white py-1">Vincular</button>
                        </div>
                    </div>
                </div>
                <div id="telegramBG" class="h-screen animated"></div>
            </div>
        `;
    }
}

class agenda extends HTMLElement {
    constructor() {
        super();
        this.clases;
    }

    static get observedAttributes() {
        return ['clases'];
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        this.clases = newValue;
    }
    connectedCallback() {
        this.innerHTML = `
            <div id="contenedorAgenda" class="hidden w-full absolute top-0 z-50 bg-gray-900 bg-opacity-50 animated ${this.clases}">
                <div class="w-72 flex flex-col bg-white shadow-md animated absolute top-0 right-0 h-screen">
                    <div class=" w-72 p-2 flex flex-col bg-white shadow-md" >
                        <div class="p-2 mb-2 text-xs text-justify flex flex-col h-12 flex items-center justify-center relative overflow-hidden">
                            <img src="svg/agenda.gif" class="absolute w-20" alt="">
                            <div id="btnCerrarAgenda" class=" absolute top-0 right-0 text-gray-400 hover:text-cyan-200">
                                <button><i class="fal fa-times p-2 fa-lg"></i></button>
                            </div>
                        </div>
                        <div class="bg-white rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer p-2 ">
                        <div class="bg-gray-100 p-2">
                            <h1>Nada para hoy...</h1>
                        </div>
                        </div>
                    </div>
                </div>
                <div id="agendaBG" class="h-screen animated"></div>
            </div>
        `;
    }
}

class favoritos extends HTMLElement {
    constructor() {
        super();
        this.clases;
    }

    static get observedAttributes() {
        return ['clases'];
    }

    attributeChangedCallback(nameAtr, oldValue, newValue) {
        this.clases = newValue;
    }
    connectedCallback() {
        this.innerHTML = `
            <div id="contenedorFavoritos" class="hidden w-full absolute top-0 z-50 bg-gray-900 bg-opacity-50 animated ${this.clases}">
                <div class="w-72 p-2 flex flex-col bg-white shadow-md animated absolute top-0 right-0 h-screen">
                    <div class="p-2 mb-2 text-xs text-justify flex flex-col h-12 flex items-center justify-center relative overflow-hidden">
                        <img src="svg/favo.gif" class="absolute" alt="">
                        <div id="btnCerrarFavoritos" class="absolute top-0 right-0 text-gray-400 hover:text-cyan-200">
                            <button><i class="fal fa-times p-2 fa-lg"></i></button>
                        </div>
                    </div>

                    <div class="bg-white shadow p-2 rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer">
                        <div class="flex w-full items-center">
                            <div class="w-6 h-6 bg-red-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                <h1 class="font-bold text-red-500">I</h1>
                            </div>
                            <div>
                                <p><span>"fuga en piscina principal"</span> tipo <span class="font-bold">ALARMA</span> </p>
                                <p class="font-sans text-center">ZHP/ALBERCAS GP</p>
                            </div>
                        </div>
                        <div class="w-full flex mt-1 justify-evenly">
                            <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                            <button class="w-20 py-1 text-yellow-500 hover:text-gray-200 rounded"><i class="fas fa-star"></i></button>
                            <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <div class="bg-white shadow p-2 rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer">
                        <div class="flex w-full items-center">
                            <div class="w-6 h-6 bg-blue-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                <h1 class="font-bold text-blue-500">MP</h1>
                            </div>
                            <div>
                                <p><span>"Lavadora principal 01"</span> <span class="font-bold">OT-2136523</span> </p>
                                <p class="font-sans text-center">ZIL/LAVADORAS</p>
                            </div>
                        </div>

                        <div class="w-full flex mt-1 justify-evenly">
                            <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                            <button class="w-20 py-1 text-yellow-500 hover:text-gray-200 rounded"><i class="fas fa-star"></i></button>
                            <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <div class="bg-white shadow p-2 rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer">
                        <div class="flex w-full items-center">
                            <div class="w-6 h-6 bg-purple-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                <h1 class="font-bold text-purple-500">P</h1>
                            </div>
                            <div>
                                <p><span>"Proyecto cambio de chiller"</span> <span class="font-bold">INICIAR</span> </p>
                                <p class="font-sans text-center">ZIC/CHILLERS/PROYECTOS</p>
                            </div>
                        </div>
                        <div class="w-full flex mt-1 justify-evenly">
                            <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                            <button class="w-20 py-1 text-yellow-500 hover:text-gray-200 rounded"><i class="fas fa-star"></i></button>
                            <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>

                    <div class="bg-white shadow p-2 rounded-md mb-2 text-xs text-justify flex flex-col cursor-pointer">
                        <div class="flex w-full items-center">
                            <div class="w-6 h-6 bg-green-200 flex-none rounded-full mr-2 flex items-center justify-center">
                                <h1 class="font-bold text-green-500 text-xxs">DOC</h1>
                            </div>
                            <div>
                                <p><span>"Ficha tecnica"</span> <span class="font-bold">PDF</span> </p>
                                <p class="font-sans text-center">ARCHIVO ADJUNTO</p>
                            </div>
                        </div>
                        <div class="w-full flex mt-1 justify-evenly">
                            <button class="w-20 py-1 text-gray-200 hover:text-blue-500 rounded"><i class="fas fa-eye"></i></button>
                            <button class="w-20 py-1 text-yellow-500 hover:text-gray-200 rounded"><i class="fas fa-star"></i></button>
                            <button class="w-20 py-1 text-gray-200 hover:text-red-500 rounded"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div id="favoritosBG" class="h-screen animated"></div>
            </div>
        `;
    }
}



window.customElements.define("menu-sidebar", menuSidebar);
window.customElements.define("menu-menu", menu);
window.customElements.define("configuracion-telegram", telegram);
window.customElements.define("menu-notificaciones", nofiticaciones);
window.customElements.define("menu-favoritos", favoritos);
window.customElements.define("menu-agenda", agenda);


const btnAbrirMenu = document.querySelector('#btnAbrirMenu');
const btnCerrarMenu = document.querySelector('#btnCerrarMenu');
const contenedorMenu = document.querySelector('#contenedorMenu');
const configuracionesUsuario = document.querySelector('#configuracionesUsuario');
const destinosUsuario = document.querySelector('#destinosUsuario');
const btnConfiguracionesUsuario = document.querySelector('#btnConfiguracionesUsuario');
const btnDestinosUsuario = document.querySelector('#btnDestinosUsuario');
const dataDestinosUsuario = document.querySelector('#dataDestinosUsuario');
const dataMenu = document.querySelector('#dataMenu');
const destinoUsuario = document.querySelector('#destinoUsuario');
const nombreUsuario = document.querySelector('#nombreUsuario');
const nombreUsuarioMenu = document.querySelector('#nombreUsuarioMenu');
const cargoUsuario = document.querySelector('#cargoUsuario');
const avatarUsuario = document.querySelector('#avatarUsuario');
const subirAvatarUsuario = document.querySelector('#subirAvatarUsuario');
const incidenciasAsignadasUsuario = document.querySelector('#incidenciasAsignadasUsuario');
const avatarMenuUsuario = document.querySelector('#avatarMenuUsuario');
const codigoTelegram = document.querySelector('#codigoTelegram');
const menuBG = document.querySelector('#menuBG');
const contenedorNotifiaciones = document.querySelector('#contenedorNotifiaciones');
const notificacionesBG = document.querySelector('#notificacionesBG');
const btnCerrarNotificaciones = document.querySelector('#btnCerrarNotificaciones');
const btnAbrirNotificaciones = document.querySelector('#btnAbrirNotificaciones');
const btnAbrirAgenda = document.querySelector('#btnAbrirAgenda');
const btnAbrirFavoritos = document.querySelector('#btnAbrirFavoritos');
const btnAbrirConfiguracionesTelegram = document.querySelector('#btnAbrirConfiguracionesTelegram');
const contenedorFavoritos = document.querySelector('#contenedorFavoritos');
const btnCerrarFavoritos = document.querySelector('#btnCerrarFavoritos');
const favoritosBG = document.querySelector('#favoritosBG');
const telegramBG = document.querySelector('#telegramBG');
const btnCerrarTelegram = document.querySelector('#btnCerrarTelegram');
const contenedorTelegram = document.querySelector('#contenedorTelegram');
const btnAbrirTelegram = document.querySelector('#btnAbrirTelegram');


// MENU
btnCerrarMenu.addEventListener('click', () => {
    contenedorMenu.classList.remove('fadeIn');
    contenedorMenu.children[0].classList.remove('fadeInLeft');
    contenedorMenu.classList.add('fadeOut');
    contenedorMenu.children[0].classList.add('fadeOutLeft');

    setTimeout(() => {
        contenedorMenu.classList.add('hidden');
    }, 1200);
})

// ABRIR MENU
btnAbrirMenu.addEventListener('click', () => {
    contenedorMenu.classList.remove('hidden');
    contenedorMenu.classList.remove('fadeOut');
    contenedorMenu.children[0].classList.remove('fadeOutLeft');
    contenedorMenu.classList.add('fadeIn');
    contenedorMenu.children[0].classList.add('fadeInLeft');
})

menuBG.addEventListener('click', () => {
    btnCerrarMenu.click();
})


// NOTIFICACIONES
btnCerrarNotificaciones.addEventListener('click', () => {
    contenedorNotifiaciones.classList.remove('fadeIn');
    contenedorNotifiaciones.children[0].classList.remove('fadeInRight');
    contenedorNotifiaciones.classList.add('fadeOut');
    contenedorNotifiaciones.children[0].classList.add('fadeOutRight');

    setTimeout(() => {
        contenedorNotifiaciones.classList.add('hidden');
    }, 1000);
})

// ABRIR NOTIFICACIONES
btnAbrirNotificaciones.addEventListener('click', () => {
    contenedorNotifiaciones.classList.remove('hidden');
    contenedorNotifiaciones.classList.remove('fadeOut');
    contenedorNotifiaciones.children[0].classList.remove('fadeOutRight');
    contenedorNotifiaciones.classList.add('fadeIn');
    contenedorNotifiaciones.children[0].classList.add('fadeInRight');
})

notificacionesBG.addEventListener('click', () => {
    btnCerrarNotificaciones.click();
})


// FAVORITOS
btnCerrarFavoritos.addEventListener('click', () => {
    contenedorFavoritos.classList.remove('fadeIn');
    contenedorFavoritos.children[0].classList.remove('fadeInRight');
    contenedorFavoritos.classList.add('fadeOut');
    contenedorFavoritos.children[0].classList.add('fadeOutRight');

    setTimeout(() => {
        contenedorFavoritos.classList.add('hidden');
    }, 1000);
})

// ABRIR FAVORITOS
btnAbrirFavoritos.addEventListener('click', () => {
    contenedorFavoritos.classList.remove('hidden');
    contenedorFavoritos.classList.remove('fadeOut');
    contenedorFavoritos.children[0].classList.remove('fadeOutRight');
    contenedorFavoritos.classList.add('fadeIn');
    contenedorFavoritos.children[0].classList.add('fadeInRight');
})

favoritosBG.addEventListener('click', () => {
    btnCerrarFavoritos.click();
})


// TELEGRAM
btnCerrarTelegram.addEventListener('click', () => {
    contenedorTelegram.classList.remove('fadeIn');
    contenedorTelegram.children[0].classList.remove('fadeInRight');
    contenedorTelegram.classList.add('fadeOut');
    contenedorTelegram.children[0].classList.add('fadeOutRight');

    setTimeout(() => {
        contenedorTelegram.classList.add('hidden');
    }, 1000);
})

// ABRIR TELEGRAM
btnAbrirTelegram.addEventListener('click', () => {
    contenedorTelegram.classList.remove('hidden');
    contenedorTelegram.classList.remove('fadeOut');
    contenedorTelegram.children[0].classList.remove('fadeOutRight');
    contenedorTelegram.classList.add('fadeIn');
    contenedorTelegram.children[0].classList.add('fadeInRight');
})

telegramBG.addEventListener('click', () => {
    btnCerrarTelegram.click();
})


// TELEGRAM
btnCerrarAgenda.addEventListener('click', () => {
    contenedorAgenda.classList.remove('fadeIn');
    contenedorAgenda.children[0].classList.remove('fadeInRight');
    contenedorAgenda.classList.add('fadeOut');
    contenedorAgenda.children[0].classList.add('fadeOutRight');

    setTimeout(() => {
        contenedorAgenda.classList.add('hidden');
    }, 1000);
})

// ABRIR AGENDA
btnAbrirAgenda.addEventListener('click', () => {
    contenedorAgenda.classList.remove('hidden');
    contenedorAgenda.classList.remove('fadeOut');
    contenedorAgenda.children[0].classList.remove('fadeOutRight');
    contenedorAgenda.classList.add('fadeIn');
    contenedorAgenda.children[0].classList.add('fadeInRight');
})

agendaBG.addEventListener('click', () => {
    btnCerrarAgenda.click();
})


// OBTIENE LAS OPCIONES DE CONFIGURACIONES DEL USUARIO
btnConfiguracionesUsuario.addEventListener('click', () => {
    destinosUsuario.classList.add('hidden');

    configuracionesUsuario.classList.contains('hidden') ?
        configuracionesUsuario.classList.remove('hidden') :
        configuracionesUsuario.classList.add('hidden');
})


// OBTIENE LAS OPCIONES DE DESTINOS DEL USUARIO
btnDestinosUsuario.addEventListener('click', () => {
    configuracionesUsuario.classList.add('hidden');

    destinosUsuario.classList.contains('hidden') ?
        destinosUsuario.classList.remove('hidden') :
        destinosUsuario.classList.add('hidden');
})


btnCodigoTelegram.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "comprobarCodigoTelegram";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&chatID=${codigoTelegram.value}`;

    if (codigoTelegram.value.length == 9) {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg('Código Actualizado', '', 'success', 1500);
                    codigoTelegram.value = '';
                    modalOpenClose('modalConfigurarTelegram');
                } else {
                    alertaImg('Escannea de Nuevo', '', 'info', 1500);
                }
            })
            .catch(function (err) {
                alertaImg('Código No Valido', '', 'error', 1500);
            })
    } else {
        alertaImg('Código No Valido', '', 'info', 1500);
        codigoTelegram.value = '';
    }
})


subirAvatarUsuario.addEventListener('change', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "subirAvatarUsuario";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    if (subirAvatarUsuario.files) {
        for (let x = 0; x < subirAvatarUsuario.files.length; x++) {
            const formData = new FormData();
            formData.append('file', subirAvatarUsuario.files[x]);
            const tipo = subirAvatarUsuario.files[x].type;
            if (tipo == "image/svg+xml" || tipo == "image/jpeg" || tipo == "image/png" || tipo == "image/gif" || tipo == "image/jpg") {
                fetch(URL, {
                    method: "POST",
                    body: formData
                })
                    .then(array => array.json())
                    .then(array => {
                        obtenerInformacionUsuario();
                        if (array == 1) {
                            alertaImg('Avatar Actualizado', '', 'success', 1500);
                        } else {
                            alertaImg('Intente de Nuevo', '', 'info', 1500);
                        }
                    })
                    .then(() => {
                        subirAvatarUsuario.value = '';
                    })
                    .catch(function (err) {
                        alertaImg('Intente de Nuevo', '', 'info', 1500);
                        subirAvatarUsuario.value = '';
                    })
            } else {
                alertaImg('Adjunto No Permitido', '', 'info', 1500);
            }
        }
    }
})


const obtenerMenu = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerMenu";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataMenu.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const titulo = array[x].titulo;
                    const menu2 = array[x].menu2;
                    const link = array[x].link;
                    let codigo = '';

                    const fMenu = array[x].menu2.length > 0 ? `onclick="toggleMenu('menu_${x}')"` : '';
                    const fMenuIcono = array[x].menu2.length > 0 ?
                        `<i id="menu_${x}" class="fas fa-angle-right"></i>` : '';

                    codigo += `
                            <a href="${link}" class="flex hover:bg-gray-100 mt-2 pb-1 cursor-pointer px-2 rounded" ${fMenu}>
                                <div class="w-4 mr-1 ">
                                    ${fMenuIcono}
                                </div>
                                <h1>${titulo}</h1>
                            </a>
                    `;

                    if (menu2) {
                        for (let y = 0; y < menu2.length; y++) {
                            const titulo2 = menu2[y].titulo;
                            const link2 = menu2[y].link;
                            const menu3 = menu2[y].menu3;

                            const fExtra = titulo2 == 'Inventarios' ? `onclick="abrirEnlace('MENUGESTIONINVENTARIO');"`
                                : titulo2 == 'Presupuestos' ? `onclick="abrirEnlace('MENUPRESUPUESTOS');"`
                                    : '';

                            codigo += `
                                <!-- NIVEL 2 -->
                                <a href="${link2}" class="ml-6 border-l-2 hidden menu_${x}" ${fExtra}>
                                    <div class="flex hover:bg-gray-100 py-1 cursor-pointer px-2 rounded">
                                        <h1>${titulo2}</h1>
                                    </div>
                                </a>
                                <!-- NIVEL 2 -->  
                            `;

                            if (menu3) {
                                for (let z = 0; z < menu3.length; z++) {
                                    const titulo3 = menu3[z].titulo;
                                    const link3 = menu3[z].link;

                                    codigo += `
                                        <!-- NIVEL 3 -->
                                        <a href="${link3}"class="ml-12 border-l-2 hidden menu_${x}">
                                            <div class="flex hover:bg-gray-100 py-1 cursor-pointer px-2 rounded">
                                                <h1>${titulo3}</h1>
                                            </div>
                                        </a>
                                        <!-- NIVEL 3 -->
                                    `;
                                }
                            }
                        }
                    }
                    dataMenu.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            dataMenu.innerHTML = '';
            fetch(APIERROR + err);
        })
}


const obtenerDestinosUsuario = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerDestinosUsuario";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataDestinosUsuario.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idDestinoX = array[x].idDestinoX;
                    const destino = array[x].destino;
                    const ubicacion = array[x].ubicacion;
                    const codigo = `
                        <a href="#" class="flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 -mx-2 flex-col" onclick="actualizarDestino('${destino}', ${idDestinoX})">
                            <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold leading-none font-bold">
                                ${ubicacion}
                            </p>
                            <p class="text-gray-600 dark:text-white text-sm mx-2 font-semibold leading-none text-xs">
                                ${destino}
                            </p>
                        </a>            
                    `;
                    dataDestinosUsuario.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            dataDestinosUsuario.innerHTML = '';
            fetch(APIERROR + err);
        })
}


const obtenerInformacionUsuario = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerInformacionUsuario";
    const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                destinoUsuario.innerText = array.destino;
                nombreUsuario.innerText = array.nombre + ' ' + array.apellido;
                nombreUsuarioMenu.innerText = array.nombre;
                cargoUsuario.innerText = array.cargo;
                avatarUsuario.setAttribute('src', `planner/avatars/${array.avatar}`);
                avatarMenuUsuario.setAttribute('src', `planner/avatars/${array.avatar}`);
                incidenciasAsignadasUsuario.innerText = array.incidencias;
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


// CERRAR SESSIÓN
const cerrarSesion = () => {
    localStorage.clear();
    location.href = 'login.php';
}

const toggleMenu = menu => {
    if (array = document.getElementsByClassName(menu)) {
        for (let x = 0; x < array.length; x++) {
            document.getElementsByClassName(menu)[x].classList.toggle('hidden');
        }

        const icono = document.getElementById(menu);

        if (icono.classList.contains('fa-angle-down')) {
            icono.classList.replace('fa-angle-down', 'fa-angle-right');
        } else {
            icono.classList.replace('fa-angle-right', 'fa-angle-down');
        }
    }
}

const actualizarDestino = (destino, idDestino) => {
    localStorage.setItem('idDestino', idDestino);
    destinoUsuario.innerText = destino;
    destinosUsuario.classList.add('hidden');
}

// FUNCION EXTRA PARA LIMITAR ENLACES
const abrirEnlace = tipoEnlace => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const URL = `php/select_REST_planner.php?action=abrirEnlace&idDestino=${idDestino}&idUsuario=${idUsuario}&tipoEnlace=${tipoEnlace}`;
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                window.open(array.url, "Inventarios", "witdh=900, height=800")
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


const modalOpenClose = idElemento => {
    if (modal = document.getElementById(idElemento)) {
        modal.classList.toggle('open');
    }
}

obtenerMenu();
obtenerDestinosUsuario();
obtenerInformacionUsuario();