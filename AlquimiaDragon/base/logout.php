<?php
session_start();
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("location: ../html/login.php"); // Redirigir al login
exit();
?>
