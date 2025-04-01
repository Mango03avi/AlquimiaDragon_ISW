<?php
include("conexion.php");

$action = $_GET['action'];

if ($action === 'fetch') {
    $query = "SELECT ID_usuario, Nombre, Correo FROM Usuario2 WHERE ID_rol != 10";  // Excluir administradores
    $result = $conn->query($query);

    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    $deleteQuery = "DELETE FROM Usuario2 WHERE ID_usuario = $idUsuario AND ID_rol != 10";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
}
?>
