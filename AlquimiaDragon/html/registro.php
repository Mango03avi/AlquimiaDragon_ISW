<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Zeyada&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>AlquimiaDragon</title>
</head>

<body>
    <div>
        <img src="../media/images/Logo_Ch .png" class="img-fluid" id="icon">
        <a id="title-alquimia">AlquimiaDragon</a>
    </div>

    <!--Div que contiene card con registro-->
    <div class="card w-auto p-4 text-center" id="card-login">
        <div class="card-body">
            <!--Div para boton de log in-->
            <div class="d-flex justify-content-end align-items-center gap-2 mb-5">
                <span class="text" style="font-weight: 500;">¿Ya estas registrado?</span>
                <a class="btn btn-primary mt-1" id="btn-login" href="login.php">Log in</a>
            </div>
            <!--Div con texto de registro-->
            <div class="text-start">
                <p class="h6 mb-1">Registremonos Aventurero</p>
                <p class="h1 mb-5">Crea una cuenta</p>
            </div>
            <!--Formulario ajustar metodo post y dar funcion con JS-->
            <form class="d-flex flex-wrap justify-content-center gap-1 mb-3" method="POST" action="../php/registroBD.php" >
                <!--Input´s para introducir nombre y apellido-->
                <div>
                    <div class="col-auto mb-2">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" minlength="4" maxlength="30">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" placeholder="Apellido Materno" name="apellido_materno" minlength="4" maxlength="30" >
                    </div>
                </div>
                <!--Input's para introducir apellido-->
                <div>
                    <div class="col-auto mb-2">
                        <input type="text" class="form-control" placeholder="Apellido Paterno" name="apellido_paterno" minlength="4" maxlength="30">
                    </div>
                    <div class="col-auto mb-1">
                        <input type="tel" class="form-control" placeholder="Número Celular" name="telefono" pattern="[0-9]{10,15}" 
                        title="Solo números (10 dígitos)"  >
                    </div>
                </div>
                <!--Input's largos para correo y password-->
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-auto">
                        <input type="email" class="form-control" id="form" placeholder="Correo Electrónico" name="correo" minlength="8" maxlength="30">
                    </div>
                    <div class="col-auto">
                        <input type="password" class="form-control" id="form" placeholder="Contraseña" name="contrasena" minlength="10" maxlength="30">
                    </div>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2" id="btn-register">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end" >
        <img src="../media/images/wizard.png" class="img-fluid d-none d-md-none d-lg-block" id="wizard">
    </div>
    

</body>

</html>