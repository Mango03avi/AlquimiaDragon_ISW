<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    // Validación de campos vacíos
    $errores = [];
    
    if(empty($nombre)){
        $errores[] = "Ingresa un Nombre";
    }
    if(empty($apellido_paterno)){
        $errores[] = "Ingresa tu Apellido Paterno";
    }
    if(empty($apellido_materno)){
        $errores[] = "Ingresa tu Apellido Materno";
    }
    if(empty($telefono)){
        $errores[] = "Ingresa un Teléfono";
    }
    if(empty($correo)){
        $errores[] = "Ingresa un Correo";
    }
    if(empty($contrasena)){
        $errores[] = "Ingresa una Contraseña";
    }
    
   // Si hay errores, mostrarlos y salir
if (!empty($errores)) {
    echo "<script>
            alert('Por favor complete todos los campos obligatorios');
            window.history.back();
          </script>";
    exit();
}

    // Validación de correo
    function validarCorreo($correo) {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $dominio = explode('@', $correo)[1];
        return checkdnsrr($dominio, 'MX');
    }

    if (!validarCorreo($correo)) {
        echo "<script>alert('El correo electrónico no es válido o el dominio no existe'); window.history.back();</script>";
        exit();
    }

    // Verificar si el correo existe
    $sql_check = "SELECT ID_usuario FROM usuario2 WHERE correo = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('El correo electrónico ya está registrado'); window.history.back();</script>";
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // Hashear la contraseña (¡IMPORTANTE! Descomenta esto)
    // $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $contrasena_hash = $contrasena; // Esto es temporal, solo para pruebas

    // Insertar usuario
    $sql = "INSERT INTO usuario2 (nombre, Apellido_Paterno, Apellido_Materno, telefono, correo, contrasena, ID_rol) 
            VALUES (?, ?, ?, ?, ?, ?, 8)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Error al preparar la consulta: ".$conn->error."'); window.history.back();</script>";
        $conn->close();
        exit();
    }

    $stmt->bind_param("ssssss", $nombre, $apellido_paterno, $apellido_materno, $telefono, $correo, $contrasena_hash);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. ¡Bienvenido, $nombre!'); window.location.href='../html/login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar: ".$stmt->error."'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acceso no permitido'); window.location.href='../html/registro.php';</script>";
}
?>