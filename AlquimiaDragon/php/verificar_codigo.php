<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_ingresado = trim($_POST['codigo']);
    $codigo_guardado = $_SESSION['codigo'] ?? null;
    $hora_generacion = $_SESSION['codigo_time'] ?? null;

    if (empty($_POST['codigo'])) {
        echo('<div class="alert alert-danger">Por favor ingresa el código recibido</div>');
    }
    elseif ((time() - $hora_generacion) / 60 > 10) {
        echo '<div class="alert alert-danger">El código ha expirado. Por favor, solicita uno nuevo.</div>';
    } 
    elseif ($codigo_ingresado != $codigo_guardado) {
        echo '<div class="alert alert-danger">El código ingresado es incorrecto. Por favor, intenta nuevamente.</div>';
    }
    else {
        $_SESSION['codigo_verificado'] = true;
        header("Location: ../html/nueva_contrasena.php");
        exit();
    }
}

// Mostrar el formulario de código
include '../html/codigo_recuperacion.php';
?>