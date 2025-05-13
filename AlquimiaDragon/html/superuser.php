<?php
session_start();

// Validar que esté logueado y que tenga rol 1
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
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
    <title>Administrador</title>
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
                        <a class="nav-link" href="../index.php">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="superuser.php">Administracion</a>
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

    <!--Formulario para registro de nuevo usuario-->
    <div class="card" style="border: 20px; margin: 20px; padding: 10px;background-color: #E0DCDB;">
        <h2 class="d-flex flex-wrap justify-content-center gap-1 mb-3">Registrar trabajador nuevo</h2>

        <form id="registerForm" class="d-flex flex-wrap justify-content-center gap-1 mb-3">
            <!--Input´s para introducir nombre y apellido-->
            <div>
                <div class="col-auto mb-2">
                    <input type="text" class="form-control" id="name" placeholder="Nombre" minlength="5" maxlength="35" required autocomplete="off" oninput="validarSoloTexto(this)" onblur="validarSoloTexto(this)">
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="apellidoP" placeholder="Apellido Materno" minlength="5" maxlength="35" required autocomplete="off" oninput="validarSoloTexto(this)" onblur="validarSoloTexto(this)">
                </div>
            </div>
            <!--Input's para introducir apellido-->
            <div>
                <div class="col-auto mb-2">
                    <input type="text" class="form-control" id="apellidoM" placeholder="Apellido Paterno" minlength="5" maxlength="35" required autocomplete="off" oninput="validarSoloTexto(this)" onblur="validarSoloTexto(this)">
                </div>
                <div class="col-auto mb-1">
                    <input type="tel" class="form-control" id="celular" placeholder="Número Celular" minlength="9" maxlength="11" required autocomplete="off" oninput="validarSoloNumeros(this)" onblur="validarSoloNumeros(this)">
                </div>
            </div>
            <!--Input's largos para correo y password-->
            <div class="d-flex flex-wrap justify-content-center gap-1">
                <div class="col-auto">
                    <input type="email" name="email" class="form-control" id="correo" placeholder="Correo Electrónico" minlength="10" maxlength="35" required autocomplete="off" onblur="validarCorreos(this)">
                </div>
                <div class="col-auto">
                    <input type="password" class="form-control" id="contra" placeholder="Contraseña" minlength="10" maxlength="25" required autocomplete="off">
                </div>
            </div>
            <!--Input's largos para rol-->
            <div class="d-flex flex-wrap justify-content-center gap-1">
                <div class="input-group mb-1">
                    <select class="form-select" id="rol" required>
                        <option selected disabled>Seleccione el Rol...</option>
                    </select>
                </div>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-center">
                <button type="subtmit" class="btn btn-primary mt-2" id="btn-register">Registrar</button>
            </div>
        </form>

        <!-- Contenedor Principal -->
        <div class="container-fluid">
            <div class="container my-5">
                <h1 class="mb-4 text-center">Gestión de empleados</h1>

                <!-- Filtro de búsqueda -->
                <div class="mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar en la tabla...">
                </div>

                <!-- Tabla para mostrar archivos -->
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usuariosTableBody"></tbody>
                    </table>
                </div>

                <h3 class="mb-4 text-center">Modificacion de datos</h3>

                <!--Formulario para edicion de usuarios-->
                <form class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                    <div>
                        <div class="col-auto mb-1">
                            <input type="text" class="form-control" id="idUsuario" placeholder="ID" readonly>
                        </div>
                        <div class="input-group mb-1">
                            <select class="form-select" id="rol1">
                                <option selected disabled>Seleccione el Rol...</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="col-auto mb-1">
                            <input type="text" class="form-control" id="telefono" placeholder="Número Celular" minlength="9" maxlength="11" required autocomplete="off" oninput="validarSoloNumeros(this)" onblur="validarSoloNumeros(this)">
                        </div>
                        <div class="col-auto">
                            <input type="email" name="correo2" class="form-control" id="correo2" placeholder="Correo Electrónico" minlength="10" maxlength="30" required onblur="validarCorreos(this)">
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-wrap justify-content-center">
                        <button type="submit" class="btn btn-primary mt-2" id="btn-update">Guardar</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Contenedor Principal para tabla de productos -->
        <div class="container-fluid">
            <div class="container my-3">
                <h1 class="mb-5 text-center">Gestión de Productos</h1>

                <!-- Filtro de búsqueda -->
                <div class="mb-4">
                    <input type="text" id="searchItem" class="form-control" placeholder="Buscar en la tabla...">
                </div>

                <!-- Tabla para mostrar productos -->
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>ID del producto</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Costo</th>
                                <th>Disponibilidad</th>
                                <th>Cambiar disponibilidad</th>
                                <th>Eliminar Producto</th>
                            </tr>
                        </thead>
                        <tbody id="productosTableBody"></tbody>
                    </table>
                </div>
            </div>
            <h3 class="mb-4 text-center">Modificacion de Menú</h3>
            <!--Formulario para edicion de producto-->
            <form class="d-flex flex-wrap justify-content-center gap-1 mb-2">
                <div>
                    <div class="col-auto mb-1">
                        <input type="text" class="form-control" id="idProducto" placeholder="ID" readonly>
                    </div>
                    <div class="col-auto mb-1">
                        <input type="text" class="form-control" id="nombreProducto" placeholder="Nombre" minlength="5" maxlength="35" required autocomplete="off" oninput="validarSoloTexto(this)" onblur="validarSoloTexto(this)">
                    </div>
                </div>
                <div>
                    <div class="col-auto mb-1">
                        <input type="text" class="form-control" id="tipo" placeholder="Ingrese tipo de Producto" minlength="5" maxlength="35" required autocomplete="off" oninput="validarSoloTexto(this)" onblur="validarSoloTexto(this)">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" id="precio" placeholder="Precio" minlength="4" maxlength="7" required autocomplete="off" oninput="validarPrecio(this)" onblur="validarPrecio(this)">
                    </div>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <button type="submit" class="btn btn-primary mt-2" id="btn-updateP">Guardar Cambios</button>
                </div>
            </form>
        </div>

        <div class="container my-3">
            <h1 class="mb-3 text-center">Generar Ticket</h1>

            <div class="col-12 d-flex flex-wrap justify-content-center">
                <button type="submit" class="btn btn-primary mt-2" id="btn-ticket">Generar Ticket</button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Seleccionar el botón por su ID
            const btnTicket = document.getElementById("btn-ticket");

            // Verificar si el botón existe antes de agregar el evento
            if (btnTicket) {
                btnTicket.addEventListener("click", function (event) {
                    event.preventDefault(); // Evitar que el formulario se envíe
                    alert("Estamos trabajando en esta funcionalidad. ¡Pronto estará disponible!");
                });
            } else {
                console.warn("El botón con ID 'btn-updateP' no fue encontrado");
            }
        });
    </script>

    <script src="../js/usuarios.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>


</body>

<footer>

</footer>

</html>