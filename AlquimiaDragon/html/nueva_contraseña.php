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

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Codigo Recuperacion</title>
</head>

<body>
    <div>
        <img src="../media/images/Logo_Ch .png" class="img-fluid" id="icon">
        <a id="title-alquimia">Recuperar Cuenta</a>
    </div>
    <!--Div que contiene card con registro-->
    <div class="card w-auto p-4 text-center" id="card-login">
        <div class="card-body">
            <!--Div para boton de log in-->
            <div class="d-flex justify-content-end align-items-center gap-2 mb-5">
                <span class="text" style="font-weight: 500;">¿Ya tienes cuenta?</span>
                <a class="btn btn-primary" id="btn-login" href="login.php">Log in</a>
            </div>
            <!--Div con texto de registro-->
            <div class="text-start">
                <p class="h6 mb-1">Estamos usando hechizos para hablar con los muertos</p>
                <p class="h1 mb-4">Introduce tu nueva contraseña</p>
            </div>
            <!--Formulario ajustar metodo post y dar funcion con JS-->
            <form class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                <!--Input's largos para correo y password-->
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-auto mb-4">
                        <input type="text" class="form-control mb-2" id="form" placeholder="Contraseña Nueva">
                        <input type="password" class="form-control" id="form" placeholder="Vuelve a escribirla">
                    </div>
                </div>
                <!--Boton-->
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn btn-primary mt-1" id="btn-reenviar">Enviar</button>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2" id="btn-register">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <img src="../media/images/wizard.png" class="img-fluid d-none d-md-none d-lg-block" id="wizard">
    </div>


</body>

</html>