<?php
require 'conexion.php'; // Asegúrate de que este archivo contiene la conexión a MySQL

header('Content-Type: application/json');

// Verificar si la conexión existe
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos"]);
    exit();
}

// Capturar la acción desde la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Actualizar disponibilidad
    if ($action == 'updateDisponibilidad' && isset($data['id']) && isset($data['disponibilidad'])) {
        $id = $data['id'];
        $disponibilidad = $data['disponibilidad'];

        $query = "UPDATE producto SET Disponibilidad = ? WHERE ID_producto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $disponibilidad, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Disponibilidad actualizada"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar disponibilidad"]);
        }
        $stmt->close();
    }
    // Actualizar producto
    elseif ($action == 'update' && isset($data['id']) && isset($data['nombre']) && isset($data['tipo']) && isset($data['precio'])) {
        $id = $data['id'];
        $nombre = $data['nombre'];
        $tipo = $data['tipo'];
        $precio = $data['precio'];

        $query = "UPDATE producto SET Nombre = ?, Tipo = ?, Costo = ? WHERE ID_producto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $nombre, $tipo, $precio, $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Producto actualizado correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el producto"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos o acción no válida"]);
    }

    $conn->close();
    exit();
}

// Eliminar producto
elseif ($action === 'delete' && isset($_GET['id'])) {
    $idproducto = intval($_GET['id']);

    $deleteQuery = "DELETE FROM producto WHERE ID_producto = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $idproducto);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el producto"]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Obtener productos si no es POST ni DELETE
$sql = "SELECT * FROM producto";
$result = $conn->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
$conn->close();
?>
