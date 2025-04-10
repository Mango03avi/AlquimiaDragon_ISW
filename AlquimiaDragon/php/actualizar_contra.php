<?php
session_start();
require 'conexion.php'; // Aquí debes incluir tu conexión a la BD

if (!isset($_SESSION['codigo_verificado']) || !$_SESSION['codigo_verificado']) {
    header("Location: olvide_contra.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva_contra = $_POST['nueva_contra'];
    $confirmar_contra = $_POST['confirmar_contra'];

    if ($nueva_contra !== $confirmar_contra) {
        header("Location: ../html/nueva_contrasena.php?error=Las contraseñas no coinciden");
        exit();
    }

    $email = $_SESSION['email']; // **IMPORTANTE:** debes haber guardado el email en sesión antes de esta pantalla

    $nueva_contra_hashed = $nueva_contra; // Usamos la contraseña tal cual

    // Actualizar contraseña en base de datos
    $sql = "UPDATE usuario2 SET contrasena = ? WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $nueva_contra_hashed, $email);
        if ($stmt->execute()) {
            session_destroy(); // Destruir sesión para mayor seguridad
            header("Location: ../html/login.php?success=Contraseña actualizada correctamente");
            exit();
        } else {
            header("Location: ../html/nueva_contrasena.php?error=Error al actualizar la contraseña");
            exit();
        }
    } else {
        header("Location: ../html/nueva_contrasena.php?error=Error en la preparación de la consulta");
        exit();
    }
}
?>
