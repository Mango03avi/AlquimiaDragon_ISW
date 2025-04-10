<?php
// Importar clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Requerir los archivos de PHPMailer
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = 2; // Mostrar mensajes detallados
$mail->Debugoutput = 'html'; // Mostrar el debug bonito en HTML

    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alquimiadragon123@gmail.com';    // <-- PON AQUÍ TU GMAIL
    $mail->Password = 'abou rscv rhtt vqem';       // <-- PON LA CONTRASEÑA DE APLICACIÓN
    $mail->SMTPSecure = 'tls'; // También puedes usar 'ssl' pero con otro puerto
    $mail->Port = 587; // (si usas ssl, sería 465)

    // Remitente y destinatario
    $mail->setFrom('angeldragneel100172@gmail.com', 'Prueba Alquimia');
    $mail->addAddress('nerfeali100172@gmail.com', 'Destino'); // <-- A qué correo quieres enviarlo

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Correo de prueba';
    $mail->Body    = '<h1>¡Hola! Este es un correo de prueba 🔥</h1>';

    // Enviar
    $mail->send();
    echo 'Correo enviado correctamente ✅';
} catch (Exception $e) {
    echo "Error al enviar el correo ❌: {$mail->ErrorInfo}";
}
?>
