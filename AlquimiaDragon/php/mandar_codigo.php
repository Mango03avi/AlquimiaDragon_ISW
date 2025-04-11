<?php
session_start();

include 'conexion.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['enviar'])) {
    $email = $_POST['email'];
    $codigo = rand(100000, 999999); // Corregí el nombre de la variable (antes tenía un typo)


      //  Verificar si el correo existe en la base de datos
  $stmt = $conn->prepare("SELECT ID_usuario FROM usuario2 WHERE correo = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows == 0) {
    $_SESSION['error'] = 'El correo no está registrado en nuestro sistema';
    echo "<script>
            alert('El correo no está registrado en nuestro sistema');
            window.location.href = '../html/olvide_contra.php';
          </script>";
    exit();
}
$stmt->close();
    
    // Guardar en sesión
    $_SESSION['codigo'] = $codigo;
    $_SESSION['email'] = $email;
    $_SESSION['codigo_time'] = time(); // Nombre consistente para el tiempo

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alquimiadragon123@gmail.com';
        $mail->Password = 'abou rscv rhtt vqem';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('no-reply@alquimiadragon.com', 'AlquimiaDragon');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Tu código de recuperacion';
        $mail->Body = '
            <h2 style="color: #d35400;">¡Hechizo de recuperacion activado!</h2>
            <p>Tu código mágico es: <strong>' . $codigo . '</strong></p>
            <p>Válido por 10 minutos ⏳</p>
        ';

        $mail->send();
        
        // Redirección después de enviar el correo exitosamente
        header("Location: ../html/codigo_recuperacion.php");
        exit();

    } catch (Exception $e) {
        // Mostrar error si falla el envío
        echo '<div class="alert alert-danger">Error al enviar el correo: ' . $mail->ErrorInfo . '</div>';
        // Opcional: puedes redirigir a una página de error aquí si lo prefieres
        // header("Location: error.php");
        // exit();
    }
}
?>