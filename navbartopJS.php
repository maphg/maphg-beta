<style>
    .menu-contenedor-1 {
        background-color: #000;
        width: 16rem;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        overflow: hidden;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        margin-top: 5rem;
        border-radius: 0.5rem;
        z-index: 50;
    }

    .menu-contenedor-2 {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .menu-contenedor-3 {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: center;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .menu-contenedor-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .menu-contenedor-logo-imagen {
        height: 2.5rem;
    }

    .menu-contenedor-flecha {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        color: #63b3ed;
        font-size: 1.25rem;
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        margin-right: 0.5rem;
        margin-top: 0.5rem;
    }

    .menu-contenedor-padre-1 {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
        align-items: center;
        color: #a0aec0;
        cursor: pointer;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
        background-color: #1a202c;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .menu-contenedor-padre-1:hover {
        background-color: #fff;
        color: #1a202c;
        font-weight: 500;
    }

    .menu-contenedor-padre-2 {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .menu-hijo-1 {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        border-style: solid;
        border-color: #fff;
        border-left: 2px;
        margin-left: 1.5rem;
        font-size: 0.875rem;
    }

    /* aqui */

    .menu-hijo-2 {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
        align-items: center;
        color: #a0aec0;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        cursor: pointer;
    }

    .menu-hijo-2:hover {
        background-color: #1a202c;
        font-weight: 500;
        color: #fff;
    }

    .menu-hijo-3 {
        margin-left: 2rem;
    }

    .menu-nieto-1 {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        border-style: solid;
        border-color: #63b3ed;
        border-left-width: 2px;
        margin-left: 1.5rem;
        font-size: 0.875rem;
    }

    .menu-nieto-2 {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: flex-start;
        color: #a0aec0;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        cursor: pointer;
    }

    .menu-nieto-2:hover {
        background-color: #1a202c;
        font-weight: 500;
        color: #fff;
    }

    .menu-nieto-3 {
        margin-left: 2rem;
    }

    .menu-contenedor-4 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: auto;
        color: #cbd5e0;
        padding: 0.75rem;
        border-style: solid;
        border-color: #4a5568;
        border-top-width: 1px;
    }

    .menu-contenedor-5 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 50%;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .menu-contenedor-6 {
        width: 100%;
    }

    .menu-contenedor-7 {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 0.5rem;
    }

    .menu-contenedor-8 {
        font-size: 0.875rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-weight: 600;
    }

    .menu-contenedor-9 {
        font-size: 1.25rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        color: #63b3ed;
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .menu-contenedor-10 {
        font-size: 0.75rem;
        margin-left: 0.25rem;
    }

    .ocultalo {
        display: none;
    }

    .menu-hijo-4 {
        margin-right: 1.5rem;
    }

    .d1 {
        background-color: #000;
        width: 6rem;
        position: absolute;
        top: 0;
        right: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        overflow: hidden;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        margin-top: 5rem;
        border-radius: 0.5rem;
        z-index: 50;
    }

    .d2 {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .d3 {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: center;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .d4 {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 3rem;
        font-size: 3rem;
        color: #e53e3e;
    }

    .d5 {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
        align-items: center;
    }

    .d6 {
        display: flex;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 100%;
        background-color: #2d3748;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-radius: 0.375rem;
        line-height: 1.25;
        font-weight: 500;
        color: #a0aec0;
        margin-bottom: 1rem;
    }

    .d6:hover {
        border-color: #edf2f7;
    }

    .nt1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        background-color: #000;
        padding: 0.75rem;
        width: 100%;
    }

    .nt2 {
        display: flex;
        align-items: center;
        color: #63b3ed;
        cursor: pointer;
    }

    .nt3 {
        font-weight: 600;
        font-size: 1.5rem;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
    }

    .nt4 {
        color: #975a16;
        background-color: #f6e05e;
        border-radius: 9999px;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .nt5 {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }


    .nt6 {
        font-size: 0.875rem;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        line-height: 1;
        border-width: 1px;
        border-radius: 9999px;
        color: #63b3ed;
        border-color: #63b3ed;
        margin-top: 0;
    }

    .nt6:hover {
        border-color: transparent;
        color: #2c5282;
        background-color: #63b3ed;
    }

    .nt7 {
        margin-right: 0.5rem;
        cursor: pointer;
    }

    .nt8 {
        margin-left: 0.5rem;
    }
</style>
<!-- navbar -->
<dav class="nt1">
    <!-- nt1 -->
    <dav class="nt2">
        <!-- nt2 -->
        <spen onclick="botonMenu()" class="nt3"><i class="fas fa-bars"></i></spen><!-- nt3 -->
        <o href="#" class="nt4"><?= $nombreUsuario; ?> <spen class="nt8"><i class="fal fa-angle-down"></i></spen>
        </o><!-- nt4 -->
    </dav>
    <dav class="nt5">
        <!-- nt5 -->
        <o onclick="botonDestino()" href="#" class="nt6">
            <spen><i class="fas fa-map-marker-alt nt7"></i></spen><?= $destinoT; ?>
        </o><!-- nt6 -->
    </dav>
</dav>
<!-- navbar -->