const tooltip = document.querySelector('#tooltip');
const contenedorTooltip = document.querySelector('#contenedorTooltip');
const btnActualizar = document.querySelector('#btnActualizar');
const btnAgregar = document.querySelector('#btnAgregar');
const contenedorOpciones = document.querySelector('#contenedorOpciones');
const btnOpcion = document.querySelector('#btnOpcion');
const inputNombre = document.querySelector('#inputNombre');
const inputCargo = document.querySelector('#inputCargo');
const inputAvatar = document.querySelector('#inputAvatar');
const dataOrganigrama = document.querySelector('#dataOrganigrama');
const destino = document.querySelector('#destino');


// MUESTRA TOOLTIP DE OPCIONES
const opciones = idItem => {
    const popcorn = document.querySelector('#item_organigrama_' + idItem);
    contenedorTooltip.classList.toggle('hidden');
    Popper.createPopper(popcorn, tooltip);
    btnActualizar.setAttribute('onclick', `opcion('actualizar',${idItem})`)
    btnAgregar.setAttribute('onclick', `opcion('agregar',${idItem})`)
    contenedorOpciones.classList.add('hidden');
}


// CIERRA TOOLTIP DE OPCIONES
const cerrarOpciones = () => {
    contenedorTooltip.classList.add('hidden');
    contenedorOpciones.classList.add('hidden');
}


// OPCIONES
const opcion = (opcion, idItem) => {
    if (opcion === "actualizar") {
        obtenerItem(idItem);
        btnOpcion.innerText = 'Actualizar';
        btnOpcion.setAttribute('onclick', `actualizarItem(${idItem})`);
        contenedorOpciones.classList.remove('hidden');
    } else if (opcion === "agregar") {
        inputNombre.value = '';
        inputCargo.value = '';
        btnOpcion.setAttribute('onclick', `agregarItem(${idItem})`);
        btnOpcion.innerText = 'Agregar';
        contenedorOpciones.classList.remove('hidden');
    }
}


// AGREGAR ITEM
const agregarItem = idItem => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const data = new FormData();
    data.append('file', inputAvatar.files[0]);
    data.append('nombre', inputNombre.value);
    data.append('cargo', inputCargo.value);

    const action = "agregarItemOrganigrama";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idItem=${idItem}`;

    if (inputAvatar.files[0] && inputNombre.value.length && inputCargo.value.length) {
        fetch(URL, {
            method: "POST",
            body: data
        })
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg('Item Agregado al Organigrama', '', 'success', 1500);
                    obtenerOrganigrama();
                    contenedorTooltip.classList.add('hidden');
                    contenedorOpciones.classList.add('hidden');
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1500);
                }
            })
            .catch(function (err) {
                console.log(err);
            })
    } else {
        alertaImg('Agrega la Información Requerida', '', 'info', 1500);
    }
}


// ACTUALIZAR ITEM
const actualizarItem = idItem => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const data = new FormData();
    data.append('file', inputAvatar.files[0]);
    data.append('nombre', inputNombre.value);
    data.append('cargo', inputCargo.value);

    const action = "actualizarItem";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idItem=${idItem}`;

    if (inputNombre.value.length && inputCargo.value.length) {
        fetch(URL, {
            method: "POST",
            body: data
        })
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg('Item Actualizado', '', 'success', 1500);
                    obtenerOrganigrama();
                    contenedorTooltip.classList.add('hidden');
                    contenedorOpciones.classList.add('hidden');
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1500);
                }
            })
            .catch(function (err) {
                console.log(err);
            })
    } else {
        alertaImg('Agrega la Información Requerida', '', 'info', 1500);
    }
}


// ACTUALIZAR ITEM
const obtenerItem = idItem => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerItem";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idItem=${idItem}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                inputNombre.value = array.nombre;
                inputCargo.value = array.cargo;
                inputAvatar.setAttribute("src", arra.avatar);
            }
        })
        .catch(function (err) {
        })
}


// RENDERIZAR ORGANIGRAMA
const obtenerOrganigrama = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerOrganigrama";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataOrganigrama.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const nivel = array[x].nivel;
                    const idPadre = array[x].idPadre;
                    const hijos = array[x].hijos;
                    const nombre = array[x].nombre;
                    const cargo = array[x].cargo;
                    const avatar = array[x].avatar;
                    const nivelPadre = array[x].nivelPadre;

                    if (idPadre == 0) {
                        const codigo = `
                            <div class="flex flex-col justify-center items-center">
                                <div class="w-16">
                                    <img id="item_organigrama_${idItem}" class="block rounded-full m-auto shadow-md"
                                        src="${avatar}" onclick="opciones(${idItem})">
                                </div>
                                <div class="text-gray-600">
                                    <p>${nombre}</p>
                                    <div class="bg-gray-800 text-xs font-semibold uppercase px-2 py-1 rounded text-gray-400">
                                        <p>${cargo}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        dataOrganigrama.insertAdjacentHTML('beforeend', codigo);

                        if (hijos >= 1) {
                            dataOrganigrama.insertAdjacentHTML('beforeend',
                                `<ul id="nivel_${idItem}" class="flex flex-row mt-10 justify-center relative">
                                    <div class="-mt-10 border-l-2 absolute h-10 border-gray-400"></div>
                                </ul>`);
                        }
                    } else {

                        const contenedorHijos = hijos >= 1 ?
                            `
                                <ul id="nivel_${idItem}" class="flex flex-row mt-10 justify-center">
                                    <div class="-mt-10 border-l-2 absolute h-10 border-gray-400"></div>
                                </ul>
                            `
                            : '';

                        if (item = document.querySelector('#nivel_' + idPadre)) {
                            item.insertAdjacentHTML('beforeend', `
                                <li class="relative p-6 flex-none">
                                    <div class="border-t-2 absolute h-8 border-gray-400 top-0 rediseño_${idPadre}">
                                    </div>
                                    <div class="relative flex justify-center">
                                        <div class="-mt-6 border-l-2 absolute h-6 border-gray-400 top-0"></div>
                                        <div class="text-center">
                                            <div class="flex flex-col justify-center items-center">
                                                <div class="w-16">
                                                    <img id="item_organigrama_${idItem}" class="block rounded-full m-auto shadow-md cursor-pointer"
                                                        src="./planner/avatars/${avatar}" onclick="opciones(${idItem})">
                                                </div>
                                                <div class="text-gray-600">
                                                    <p>${nombre}</p>
                                                    <div
                                                        class="bg-gray-800 text-xs font-semibold uppercase px-2 py-1 rounded text-gray-400">
                                                        <p>${cargo}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            ${contenedorHijos}
                                        </div>
                                    </div>
                                </li>
                            `)
                        }
                        rediseño(idPadre);
                    }
                }
            }
        })
        .catch(function (err) {
            console.log(err);
        })
}


const rediseño = idPadre => {
    if (itemClass = document.getElementsByClassName("rediseño_" + idPadre)) {
        if (itemClass.length >= 2) {
            for (let x = 0; x < itemClass.length; x++) {
                if (x == 0) {
                    itemClass[x].setAttribute('style', 'left: 50%; right: 0%;');
                    itemClass[x].classList.add('animated', 'fadeIn');
                } else if ((x + 1) == itemClass.length) {
                    itemClass[x].setAttribute('style', 'left: 0%; right: 50%;');
                    itemClass[x].classList.add('animated', 'fadeIn');
                } else {
                    itemClass[x].setAttribute('style', 'left: 0%; right: 0%;');
                    itemClass[x].classList.add('animated', 'fadeIn');
                }
            }
        }
    }
}


const obtenerDestino = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerDestino";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                destino.innerHTML = array.destino;
            }
        })
        .catch(function (err) {
        })
}


// INICIA FUNCIÓN PRINCIPAL
window.addEventListener('load', () => {
    obtenerOrganigrama();
    obtenerDestino();
    document.getElementById("destinosSelecciona").addEventListener('click', () => {
        obtenerOrganigrama();
        obtenerDestino();
    })
});