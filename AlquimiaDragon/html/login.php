<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Zeyada&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../media/images/Logo_G.png" type="image/png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>AlquimiaDragon</title>
</head>

<body>

    <?php
    include "../base/conexion.php";
    include "../base/controlador_login.php";
    ?>

    <div>
        <img src="../media/images/Logo_Ch .png" class="img-fluid" id="icon">
        <a id="title-alquimia">AlquimiaDragon</a>
    </div>
    <!--Div que contiene card con registro-->
    <div class="card w-auto p-4 text-center" id="card-login">
        <div class="card-body">
            <!--Div para boton de log in-->
            <div class="d-flex justify-content-end align-items-center gap-2 mb-5">
                <span class="text" style="font-weight: 500;">¿No tienes cuenta?</span>
                <a class="btn btn-primary" id="btn-login" href="registro.php">Sign in</a>
            </div>
            <!--Div con texto de registro-->
            <div class="text-start">
                <p class="h6 mb-1">Estas de vuelta Aventurero!!!</p>
                <p class="h1 mb-4">Inicio de Sesión</p>
            </div>
            <!--Formulario ajustar metodo post y dar funcion con JS-->
            <form method="post" action="#" class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                <!--Input's largos para correo y password-->
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-auto">
                        <input type="email" name="email" class="form-control" id="email" minlength="10" maxlength="35"
                            placeholder="Correo Electrónico">
                    </div>
                    <!--Div para el ojito de mostrar contraseña-->
                    <div class="input-group" style="max-width: 504px;">
                        <input type="password" name="password" class="form-control" id="password" minlength="10"
                            maxlength="25" placeholder="Contraseña" style="border-style: solid none solid solid;">
                        <span class="input-group-text" onclick="vista()" id="verPassword"
                            style="border: var(--bs-border-width) solid #000000; background-color: #E0DCDB; border-radius:0;cursor: pointer;">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>


                </div>
                <!--Div para recuperacion de contraseña-->
                <div class="w-100 text-start gap-2">
                    <p class="h6 mb-3">¿Olvidaste tu contraseña? <a href="olvide_contra.php"
                            style="color:black;cursor: pointer;">Recuperar</a></p>
                </div>
                <!--Boton-->
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2" id="btn-register"
                        name="btningresar">Iniciar Sesión</button>
                </div>
            </form>
        </div>
    </div>

    <!--div imagen para alerta-->
    <?php if ($mostrarError): ?>
        <div class="d-flex justify-content-center" id="contenedor-mensaje">
            <img src="../media/images/msj_wizard.png" class="img-fluid" id="msjwizard">
            <div class="mensaje-error">
                <?php echo $error; ?>
            </div>
        </div>
    <?php endif; ?>



    <div class="d-flex justify-content-end">
        <img src="../media/images/wizard.png" class="img-fluid d-none d-md-none d-lg-block" id="wizard">
    </div>

    <script>
        function vista() {
            const passwordInput = document.getElementById("password");
            const icon = document.querySelector("#verPassword i");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        form.addEventListener("submit", function (event) {
            let hasError = false;
            if (emailInput.value.trim() === "") {
                highlightField(emailInput);
                hasError = true;
            }
            if (passwordInput.value.trim() === "") {
                highlightField(passwordInput);
                hasError = true;
            }
            if (hasError) {
                event.preventDefault(); // Detiene el envío del formulario
            }
        });
        function highlightField(input) {
            input.classList.add("error");
            input.setAttribute("placeholder", "Campo vacío");
            input.value = ""; // Borra el contenido para que se vea el placeholder
        }
    });
    </script>


</body>

</html>