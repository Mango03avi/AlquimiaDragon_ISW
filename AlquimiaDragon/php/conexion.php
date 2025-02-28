<?php
$servername = "localhost"; // Cambia si tu servidor es diferente
$username = "root"; // Cambia por tu usuario de la base de datos
$password = "0309"; // Cambia por tu contraseña de la base de datos
$dbname = "alquimia"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

