<?php
require 'conexion.php'; // Conexión a MySQL

header('Content-Type: application/json');

// Verificar conexión
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos"]);
    exit();
}

// Obtener acción de la URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que se haya recibido JSON válido
    if (is_null($data)) {
        echo json_encode(["success" => false, "message" => "Datos JSON inválidos"]);
        exit();
    }

    // Insertar producto
    if ($action === 'insert') {
        if (isset($data['nombre'], $data['tipo'], $data['precio'])) {
            $nombre = $data['nombre'];
            $tipo = $data['tipo'];
            $precio = floatval($data['precio']);
            $disponibilidad = 0;

            $query = "INSERT INTO producto (Nombre, Tipo, Costo, Disponibilidad) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                echo json_encode(["success" => false, "message" => "Error en prepare: " . $conn->error]);
                exit();
            }

            $stmt->bind_param("ssdi", $nombre, $tipo, $precio, $disponibilidad);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Producto insertado correctamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al insertar: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos para insertar"]);
        }
    }

    // Actualizar disponibilidad
    elseif ($action === 'updateDisponibilidad') {
        if (isset($data['id'], $data['disponibilidad'])) {
            $id = intval($data['id']);
            $disponibilidad = intval($data['disponibilidad']);

            $query = "UPDATE producto SET Disponibilidad = ? WHERE ID_producto = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                echo json_encode(["success" => false, "message" => "Error en prepare: " . $conn->error]);
                exit();
            }

            $stmt->bind_param("ii", $disponibilidad, $id);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Disponibilidad actualizada"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos para actualizar disponibilidad"]);
        }
    }

    // Actualizar producto
    elseif ($action === 'update') {
        if (isset($data['id'], $data['nombre'], $data['tipo'], $data['precio'])) {
            $id = intval($data['id']);
            $nombre = $data['nombre'];
            $tipo = $data['tipo'];
            $precio = floatval($data['precio']);

            $query = "UPDATE producto SET Nombre = ?, Tipo = ?, Costo = ? WHERE ID_producto = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                echo json_encode(["success" => false, "message" => "Error en prepare: " . $conn->error]);
                exit();
            }

            $stmt->bind_param("ssdi", $nombre, $tipo, $precio, $id);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Producto actualizado"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos para actualizar producto"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Acción POST no válida"]);
    }

    $conn->close();
    exit();
}

// Procesar solicitudes DELETE
elseif ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM producto WHERE ID_producto = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error en prepare: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Obtener productos (GET normal)
else {
    $sql = "SELECT * FROM producto";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(["success" => false, "message" => "Error al obtener productos: " . $conn->error]);
        $conn->close();
        exit();
    }

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);
    $conn->close();
    exit();
}
?>
