<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y limpiar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    // 1. Primero validar el correo
    function validarCorreo($correo) {
        // Verificar formato básico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Verificar dominio
        $dominio = explode('@', $correo)[1];
        return checkdnsrr($dominio, 'MX');
    }

    // Verificar si el correo es válido
    if (!validarCorreo($correo)) {
        echo "<script>
                alert('El correo electrónico no es válido o el dominio no existe');
                window.history.back();
              </script>";
        exit();
    }

    // 2. Verificar si el correo ya existe en la base de datos
    $sql_check = "SELECT ID_usuario FROM usuario2 WHERE correo = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        echo "<script>
                alert('Este correo electrónico ya está registrado');
                window.history.back();
              </script>";
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // 3. Hashear la contraseña
   // $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // 4. Insertar el nuevo usuario
    $sql = "INSERT INTO usuario2 (nombre, Apellido_Paterno, Apellido_Materno, telefono, correo, contrasena, ID_rol) 
            VALUES (?, ?, ?, ?, ?, ?, 8)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>
                alert('Error al preparar la consulta: " . $conn->error . "');
                window.history.back();
              </script>";
        $conn->close();
        exit();
    }

    $stmt->bind_param("ssssss", $nombre, $apellido_paterno, $apellido_materno, $telefono, $correo, $contrasena_hash);

    if ($stmt->execute()) {
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

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Acceso no permitido');
            window.location.href='../html/registro.php';
          </script>";
}
?>
