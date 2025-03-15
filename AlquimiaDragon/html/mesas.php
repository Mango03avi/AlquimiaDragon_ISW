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

<div class="container contenedor">
        <div class="row w-100">
            <!-- Sección de mesas -->
            <div class="col-md-7">
                <h2 class="text-center mb-5" style="color: #fff;">Mesas Disponibles</h2>
                <div class="row g-3" id="lista-mesas">
                    <!-- Las mesas se generan dinámicamente -->
                </div>
            </div>

            <!-- Sección de reserva -->
            <div class="col-md-5" style="color: #fff;">
                <h2 class="text-center mb-3">Reservar Mesa</h2>
                <form id="reserva-form" class="p-3 border-none">
                    <div class="mb-3">
                        <label for="mesa" class="form-label">Número de Mesa</label>
                        <input type="text" id="mesa" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="text" id="capacidad" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" id="ubicacion" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" id="fecha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reservar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Datos de las mesas (6 mesas en total)
        const mesas = [
            { id: 1, capacidad: 2, ubicacion: "Terraza" },
            { id: 2, capacidad: 4, ubicacion: "Interior" },
            { id: 3, capacidad: 6, ubicacion: "VIP" },
            { id: 4, capacidad: 8, ubicacion: "Privada" },
            { id: 5, capacidad: 3, ubicacion: "Ventana" },
            { id: 6, capacidad: 5, ubicacion: "Balcón" }
        ];

        // Referencia al contenedor de mesas
        const listaMesas = document.getElementById("lista-mesas");

        // Generar tarjetas dinámicamente en una cuadrícula 3x2
        mesas.forEach(mesa => {
            const col = document.createElement("div");
            col.classList.add("col-md-4");

            col.innerHTML = `
                <div class="card mesa-card text-center p-3 shadow-sm" data-id="${mesa.id}">
                    <h5 class="card-title">Mesa ${mesa.id}</h5>
                    <p class="card-text">Capacidad: ${mesa.capacidad} personas</p>
                    <p class="card-text">Ubicación: ${mesa.ubicacion}</p>
                </div>
            `;

            // Evento para seleccionar una mesa
            col.querySelector(".mesa-card").addEventListener("click", () => {
                document.getElementById("mesa").value = mesa.id;
                document.getElementById("capacidad").value = mesa.capacidad;
                document.getElementById("ubicacion").value = mesa.ubicacion;
            });

            listaMesas.appendChild(col);
        });

        // Evento para manejar la reserva
        document.getElementById("reserva-form").addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Mesa reservada con éxito!");
        });
    </script>
    <script src="../js/bootstrap.bundle.js"></script>

</body>

<footer></footer>

</html>