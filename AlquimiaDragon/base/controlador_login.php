<?php
session_start();
include("conexion.php");

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
        header("Location: ../index.html");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Usuario o contraseña incorrectos</div>";
    }
}
?>
