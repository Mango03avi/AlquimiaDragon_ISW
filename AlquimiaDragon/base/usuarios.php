<?php
include("conexion.php");
$action = $_GET['action'];
if ($action === 'fetch') {
    /**
     * Para llenar la tabla con una consulta
     */
    $query = "
    SELECT u.ID_usuario, u.Nombre, u.Apellido_Paterno, u.Apellido_Materno, 
    u.Correo, u.Telefono, u.Contrasena, r.Nombre AS Nombre_Rol
    FROM usuario2 u
    LEFT JOIN roles r ON u.ID_rol = r.ID_rol
    WHERE u.ID_rol NOT IN (1, 8) OR u.ID_rol IS NULL;";  // Excluir administradores y usuarios
    $result = $conn->query($query);
    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    echo json_encode($usuarios);
} elseif ($action === 'delete' && isset($_GET['id'])) {
    /**
     * Para eliminar usuarios de la tabla
     */
    $idUsuario = $_GET['id'];
    $deleteQuery = "DELETE FROM Usuario2 WHERE ID_usuario = $idUsuario AND Rol != 2";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
} elseif ($action === 'getRoles') {
    // Obtener los roles para el select
    $query = "SELECT * FROM roles";
    $result = $conn->query($query);
    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
    echo json_encode($roles);
}elseif ($action === 'update') {
    header('Content-Type: application/json'); // Asegura que la respuesta sea JSON
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['id']) && isset($data['correo']) && isset($data['telefono']) && isset($data['id_rol'])) {
        
        $id = $data['id'];
        $correo = $data['correo'];
        $telefono = $data['telefono'];
        $idRol = $data['id_rol'];
        $query = "UPDATE usuario2 SET Correo = ?, Telefono = ?, ID_rol = ? WHERE ID_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $correo, $telefono, $idRol, $id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar usuario."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
}
?>