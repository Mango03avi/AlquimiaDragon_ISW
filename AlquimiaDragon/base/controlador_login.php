<?php
session_start();
include("conexion.php");

$mostrarError = false; // Variable de control

if (isset($_POST['btningresar'])) {
    $usuario = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consulta para verificar usuario y obtener el rol
    $sql = "SELECT * FROM Usuario2 WHERE Correo = '$usuario' AND Contrasena = '$password'";
    $result = $conn->query($sql);

    // Verificación
    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();

        // Almacenar datos en la sesión
        $_SESSION["id"] = $datos->ID_usuario;
        $_SESSION["nombre"] = $datos->Nombre;
        $_SESSION["rol"] = $datos->Rol; // Guardamos el rol en sesión

        // Redirección según el rol
        if ($datos->Rol == 10) {
            header("Location: ../index.php"); // Página para usuarios normales
        } elseif ($datos->Rol == 1) {
            header("Location: ../html/superuser.php"); // Página para superusuarios
        } else {
            header("Location: ../index.php"); // Por defecto, si el rol no es reconocido
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
        $mostrarError = true; // Activar la variable de control
    }
}
?>
