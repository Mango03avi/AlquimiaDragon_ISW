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
    <link rel="icon" href="./media/images/Logo_G.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>AlquimiaDragon</title>
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
                        <a class="nav-link" href="#">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./html/mesas.php">Mesas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./html/superuser.php">Administracion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="location.href='base/logout.php'">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body id="dashboard">

    <div style="box-sizing: border-box;">
        <!-- Imagen del logo -->
        <div class="d-flex justify-content-center align-items-center vh-100 flex-md-row flex-column">
            <div class="card border-0" id="img-dashboard">
                <img src="./media/images/Logo_G.png" class="img-fluid imgdashboard">
            </div>
        </div>



        <div class="card d-flex justify-content-center align-items-center d-none d-lg-flex" id="texto-pricipal">
            <p>¡Vive la Magia de D&D en Nuestra Cafetería!</p>
        </div>

        <!--Div con la frase 1-->
        <div class="card d-flex justify-content-center align-items-center d-none d-lg-flex" id="frase-1"
            data-bs-toggle="popover" data-bs-placement="left" data-bs-trigger="click" data-bs-title="¿Sabias qué?"
            data-bs-content="Este café es unico y los snacks son caseros.">
            <p>Café de especialidad y deliciosos snacks.</p>
        </div>

        <!-- Div con la frase 2 y Popover a la izquierda -->
        <div class="card d-flex justify-content-center align-items-center d-none d-lg-flex" id="frase-2"
            data-bs-toggle="popover" data-bs-trigger="click" data-bs-placement="left" data-bs-title="Nuestras mesas"
            data-bs-content="Las mesas están diseñadas para juegos de mesa, con suficiente espacio y comodidad.">
            <p>Mesas equipadas para juegos de mesa.</p>
        </div>

        <!-- Div con la frase 3 y Popover a la izquierda -->
        <div class="card d-flex justify-content-center align-items-center d-none d-lg-flex" id="frase-3"
            data-bs-toggle="popover" data-bs-trigger="click" data-bs-placement="left" data-bs-title="Una pelicula"
            data-bs-content="Sumérgete en una experiencia inmersiva y emocionante.">
            <p>Una aventura digna de película.</p>
        </div>


        <!-- Imagen de dados -->
        <div class="d-flex justify-content-end align-items-center vh-90 d-none d-md-flex">
            <div class="card border-0" id="img-wallpaper">
                <img src="./media/images/Diseño sin título 1 (2).png" class="card-img-end">
            </div>
        </div>

    </div>


    <div class="card p-3" id="menu-dashboard">

        <!--Div para cards deproductos-->
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
            <!--Card 1-->
            <div class="col">
                <div class="card h-100" id="cards-productos">
                    <img src="./media/cafe/capuccino.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Capuccino</h5>
                        <p class="card-text">con leche entera</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end align-items-end">

                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" id="btn-reenviar"
                            style="max-width: 125px;">Conocer mas</button>

                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                            aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Descripcion del Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body small">
                                ...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--Card 2-->
            <div class="col">
                <div class="card h-100" id="cards-productos">
                    <img src="./media/cafe/frapuccino.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Frapuccino</h5>
                        <p class="card-text">This card has supporting text below as a natural lead-in to additional
                            content.</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end align-items-end">

                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" id="btn-reenviar"
                            style="max-width: 125px;">Conocer mas</button>

                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                            aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Descripcion del Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body small">
                                ...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--Card 3-->
            <div class="col">
                <div class="card h-100" id="cards-productos">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Cafe</h5>
                        <p class="card-text">Descripcion breve</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end align-items-end">

                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" id="btn-reenviar"
                            style="max-width: 125px;">Conocer mas</button>

                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                            aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Descripcion del Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body small">
                                ...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--Card 4-->
            <div class="col">
                <div class="card h-100" id="cards-productos">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Cafe</h5>
                        <p class="card-text">Descripcion breve</p>
                    </div>
                    <div class="card-footer d-flex justify-content-end align-items-end">

                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" id="btn-reenviar"
                            style="max-width: 125px;">Conocer mas</button>

                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                            aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Descripcion del Producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body small">
                                ...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-5 m-2">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Promocion</h5>
                        <p class="card-text">Promocion por tiempo limitado</p>
                        <p class="card-text"><small class="text-body-secondary">Disponible por 3 dias</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var popover = new bootstrap.Popover(document.getElementById('frase-1'));
            var popover2 = new bootstrap.Popover(document.getElementById('frase-2'));
            var popover3 = new bootstrap.Popover(document.getElementById('frase-3'));
        });

    </script>

    <script src="./js/bootstrap.bundle.js"></script>

</body>

<footer></footer>

</html>