<?php
include("conexion.php");

// Verificar conexión
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $conn->connect_error]));
}

// Validar acción
$action = $_GET['action'] ?? '';
if (empty($action)) {
    header('Content-Type: application/json');
    die(json_encode(["success" => false, "message" => "Acción no especificada"]));
}

if ($action === 'fetch') {
    $query = "SELECT u.ID_usuario, u.Nombre, u.Apellido_Paterno, u.Apellido_Materno, 
            u.Correo, u.Telefono, r.Nombre AS Nombre_Rol
            FROM usuario2 u
            LEFT JOIN roles r ON u.ID_rol = r.ID_rol
            WHERE u.ID_rol NOT IN (1, 8) OR u.ID_rol IS NULL";
    $result = $conn->query($query);

    if (!$result) {
        header('Content-Type: application/json');
        die(json_encode(["success" => false, "message" => "Error en la consulta: " . $conn->error]));
    }

    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($usuarios);
//Boton delete de la tabla funcionando
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);
    if ($idUsuario <= 0) {
        header('Content-Type: application/json');
        die(json_encode(["success" => false, "message" => "ID inválido"]));
    }

    $stmt = $conn->prepare("DELETE FROM usuario2 WHERE ID_usuario = ? AND ID_rol != 1");
    $stmt->bind_param("i", $idUsuario);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario eliminado"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar usuario: " . $stmt->error]);
    }
    $stmt->close();
//Obtencion de roles para la tabla
} elseif ($action === 'getRoles') {
    $query = "SELECT * FROM roles";
    $result = $conn->query($query);

    if (!$result) {
        header('Content-Type: application/json');
        die(json_encode(["success" => false, "message" => "Error al obtener roles: " . $conn->error]));
    }

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($roles);
// Update YA FUNCIONA
} elseif ($action === 'update') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['id']) || !isset($data['correo']) || !isset($data['telefono']) || !isset($data['id_rol'])) {
        die(json_encode(["success" => false, "message" => "Datos incompletos o inválidos"]));
    }

    $id = intval($data['id']);
    $correo = $conn->real_escape_string($data['correo']);
    $telefono = $conn->real_escape_string($data['telefono']);
    $idRol = intval($data['id_rol']);

    $query = "UPDATE usuario2 SET Correo = ?, Telefono = ?, ID_rol = ? WHERE ID_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $correo, $telefono, $idRol, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar usuario: " . $stmt->error]);
    }
    $stmt->close();

} elseif ($action === 'register') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        die(json_encode(["success" => false, "message" => "Datos inválidos"]));
    }

    // Validación de campos requeridos
    $required = ['nombre', 'apellidoP', 'apellidoM', 'telefono', 'correo', 'contra', 'id_rol'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            die(json_encode(["success" => false, "message" => "Todos los campos son obligatorio"]));
        }
    }

    // Preparar datos
    $nombre = $conn->real_escape_string($data['nombre']);
    $apellidoP = $conn->real_escape_string($data['apellidoP']);
    $apellidoM = $conn->real_escape_string($data['apellidoM']);
    $telefono = intval($data['telefono']);
    $correo = $conn->real_escape_string($data['correo']);
    $contra = password_hash($data['contra'], PASSWORD_DEFAULT);
    $idRol = intval($data['id_rol']);

    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die(json_encode(["success" => false, "message" => "El correo electrónico no es válido"]));
    }

    //Verificar si el correo ya está registrado
    $checkEmailQuery = "SELECT ID_usuario FROM usuario2 WHERE Correo = ?";
    $stmtCheck = $conn->prepare($checkEmailQuery);
    $stmtCheck->bind_param("s", $correo);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        $stmtCheck->close();
        die(json_encode(["success" => false, "message" => "El correo ya está registrado."]));
    }
    $stmtCheck->close();

    // Insertar
    $query = "INSERT INTO usuario2 (Nombre, Apellido_Paterno, Apellido_Materno, Telefono, Correo, Contrasena, ID_rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssissi", $nombre, $apellidoP, $apellidoM, $telefono, $correo, $contra, $idRol);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario registrado con éxito"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar: " . $stmt->error]);
    }
    $stmt->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Acción no válida"]);
}

$conn->close();
?>