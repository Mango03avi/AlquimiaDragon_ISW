<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: html/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Zen+Kaku+Gothic+Antique&family=Zeyada&display=swap"
        rel="stylesheet">
    <link rel="icon" href="../media/images/Logo_G.png" type="image/png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Reserva Mesa</title>
</head>


<header>
    <!--Para el menu superior-->
    <nav class="navbar navbar-expand-lg" id="navbarStyle">
        <div class="container-fluid d-flex align-items-center">
            <!-- Logo y encabezado alineados a la izquierda -->
            <div class="d-flex align-items-center me-auto">
                <span class="fs-3 ms-3 d-sm-inline"
                    style="font-family: 'Zeyada', serif; font-weight: 500; font-style: normal;">
                    AlquimiaDragon</span>
            </div>

            <!-- Botón toggle para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--Div para menu estilo hamburguesa-->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!--Etiqueta Ul que despliega la lista y la hace responsiva a pantallas chicas-->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">#</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="location.href='../base/logout.php'">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body id="dashboard">

    <script src="../js/bootstrap.bundle.js"></script>

</body>

<footer></footer>

</html>