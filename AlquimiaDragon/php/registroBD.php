<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);



    // Hashear la contraseña antes de guardarla en la base de datos
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Escapar los datos para evitar SQL Injection
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $apellido_paterno = mysqli_real_escape_string($conn, $apellido_paterno);
    $apellido_materno = mysqli_real_escape_string($conn, $apellido_materno);
    $telefono = mysqli_real_escape_string($conn, $telefono);
    $correo = mysqli_real_escape_string($conn, $correo);
    $contrasena_hash = mysqli_real_escape_string($conn, $contrasena_hash);

    // Sentencia SQL preparada
    $sql = "INSERT INTO usuario2 (nombre, Apellido_Paterno, Apellido_Materno, telefono, correo, contrasena) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssss", $nombre, $apellido_paterno, $apellido_materno, $telefono, $correo, $contrasena_hash);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Mostrar alerta y redirigir a home.php
            echo "<script>
                    alert('Registro exitoso. ¡Bienvenido, $nombre!');
                    window.location.href='../html/login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar: " . $stmt->error . "');
                    window.history.back();
                  </script>";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
