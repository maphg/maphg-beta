document.addEventListener('click', function (e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    if (target.hasAttribute('data-toggle') && target.getAttribute('data-toggle') == 'modal') {
        if (target.hasAttribute('data-target')) {
            var m_ID = target.getAttribute('data-target');
            document.getElementById(m_ID).classList.add('open');
            e.preventDefault();
        }
    }

    // Close modal window with 'data-dismiss' attribute or when the backdrop is clicked
    // if ((target.hasAttribute('data-dismiss') && target.getAttribute('data-dismiss') == 'modal') || target.classList.contains('modal')) {
    //     var modal = document.querySelector('[class="modal open"]');
    //     modal.classList.remove('open');
    //     e.preventDefault();
    // }
}, false);

function cerrarmodal(idmodal) {
    var cerrarr = document.getElementById(idmodal);
    cerrarr.classList.remove('open');
};

var scrollAbajo = document.getElementById("ddd");
scrollAbajo.scrollTop = scrollAbajo.scrollHeight;

/*

EL disparador del modal tiene que tener esto
data-target="modal-personal" data-toggle="modal"

EL modal tiene que tener esto

<div id="modal-zia" class="modal">
    <div class="modal-window w-full md:w-4/5 rounded-lg flex flex-col items-center justify-center">
        <!-- CONTENIDO MODAL -->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

        <!-- CONTENIDO MODAL -->
    </div>
</div>

*/