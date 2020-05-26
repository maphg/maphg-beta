<!DOCTYPE html>
<html>

    <head>

        

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG -  Login</title>
        <link rel="stylesheet" href="css/bulma.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="icon" href="svg/logo6.png">
        <style>
            .container-scroll {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
            }
        </style>
    </head>

    <body>

        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column has-text-centered">
                            <img src="svg/logon.svg" width="190px" alt="">
                        </div>
                    </div>
                    <div class="columns is-centered">

                        <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                            <form id="needs-validation" novalidate>
                                <div class="field">
                                    <label for="" class="label">Usuario</label>
                                    <div class="control has-icons-left">
                                        <input type="text" placeholder="Nombre de usuario" class="input" id="inputusuario" required>
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="" class="label">Contraseña</label>
                                    <div class="control has-icons-left">
                                        <input type="password" placeholder="*******" class="input" id="inputcontrasena" required>
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <button id="btnLogin" type="button" class="button is-fullwidth" onclick="validarUsuario();">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!--        <section class="hero is-fullheight">
            <div class="hero-body has-background-dark">
                <div class="container has-text-centered">
                    <div class="column is-4 is-offset-4">
                        <div class="box">
                            <figure class="avatar has-padding-5">
                                <img src="svg/logona.svg" width="128">
                            </figure>
                            <form id="needs-validation" novalidate>
                                <div class="field">
                                    <div class="control">
                                        <input class="input is-medium" type="text" id="inputusuario" placeholder="Usuario" autofocus="">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <input class="input is-medium" type="password" id="inputcontrasena" placeholder="Contraseña">
                                    </div>
                                </div>

                                <button id="btnLogin" type="button" class="button is-block is-dark is-large is-fullwidth" onclick="validarUsuario();">Login</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>-->


    </body>

    <script src="js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/bulmajs.js"></script>
    <script src="js/usuariosJS.js"></script>
</html>
