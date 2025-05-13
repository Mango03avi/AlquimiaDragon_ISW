<?php
session_start();
include("conexion.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mostrarError = false;

if (isset($_POST['btningresar'])) {
    $usuario = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("
        SELECT u.*, r.id_rol 
        FROM Usuario2 u
        INNER JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.Correo = ? AND u.Contrasena = ?
    ");
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();

        $_SESSION["id"] = $datos->ID_usuario;
        $_SESSION["nombre"] = $datos->Nombre;
        $_SESSION["rol"] = $datos->id_rol; // Ahora usamos el id real del Rol

        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // Validar según id_rol
        if (intval($datos->id_rol) == 1) {
            header("Location: ../html/superuser.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
        $mostrarError = true;
    }
}
?>
