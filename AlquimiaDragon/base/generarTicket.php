<?php
require 'conexion.php';

// Establece la zona horaria si aún no está configurada
date_default_timezone_set('America/Mexico_City'); // Cambia según tu zona

$hoy = date('Y-m-d');

// Obtener tickets del día (usando DATE() para ignorar la hora)
$ticketsQuery = $conn->query("
    SELECT ID_ticket, Total, Metodo_pago, Fecha 
    FROM ticket 
    WHERE DATE(Fecha) = CURDATE()
");

$tickets = $ticketsQuery ? $ticketsQuery->fetch_all(MYSQLI_ASSOC) : [];

// Obtener productos vendidos hoy
$productosQuery = $conn->query("
    SELECT 
        p.Nombre, 
        p.Tipo, 
        php.Cantidad, 
        php.Precio_individual,
        (php.Cantidad * php.Precio_individual) AS Total
    FROM pedido_has_producto php
    INNER JOIN pedidos ped ON ped.ID_pedido = php.pedidos_ID_pedido
    INNER JOIN producto p ON p.ID_producto = php.producto_ID_producto
    WHERE DATE(ped.Fecha) = CURDATE()
");

$productos = $productosQuery ? $productosQuery->fetch_all(MYSQLI_ASSOC) : [];

// Encabezado para que devuelva JSON correctamente
header('Content-Type: application/json');

// Respuesta como JSON
echo json_encode([
    "tickets" => $tickets,
    "productos" => $productos
], JSON_UNESCAPED_UNICODE);

?>
