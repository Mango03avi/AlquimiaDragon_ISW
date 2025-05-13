require_once("conexion.php");

$fecha = $_GET["fecha"] ?? date("Y-m-d");

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="comanda_' . $fecha . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID Comanda', 'ID Mesa', 'ID Usuario', 'Fecha', 'Cantidad', 'Subtotal']);

$stmt = $conn->prepare("SELECT ID_comanda, Mesas_ID_mesa, Usuario2_ID_usuario, Fecha, Cantidad, Subtotal 
                        FROM Comanda 
                        WHERE Fecha = ?");
$stmt->execute([$fecha]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;