<?php
session_start();
include("conexion.php");

$mostrarError = false; // Variable de control

if (isset($_POST['btningresar'])) {
    $usuario = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consulta sencilla para verificar correo y contraseña
    $sql = "SELECT * FROM Usuario2 WHERE Correo = '$usuario' AND Contrasena = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();

        // Almacenar datos en la sesión
        $_SESSION["id"] = $datos->ID_usuario;
        $_SESSION["nombre"] = $datos->Nombre;

        // Redirigir a la página principal (index.html)
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
        $mostrarError = true; // Activar la variable de control
    }
}
?>
