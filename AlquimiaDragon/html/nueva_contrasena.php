<?php
session_start();
if (!isset($_SESSION['codigo_verificado']) || !$_SESSION['codigo_verificado']) {
    header("Location: olvide_contra.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Zeyada&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Nueva Contraseña</title>
</head>

<body>
    <div>
        <img src="../media/images/Logo_Ch .png" class="img-fluid" id="icon">
        <a id="title-alquimia">Recuperar Cuenta</a>
    </div>
    
    <!-- Mostrar mensajes de error/success -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="card w-auto p-4 text-center" id="card-login">
        <div class="card-body">
            <div class="d-flex justify-content-end align-items-center gap-2 mb-5">
                <span class="text" style="font-weight: 500;">¿Ya tienes cuenta?</span>
                <a class="btn btn-primary" id="btn-login" href="login.php">Log in</a>
            </div>
            
            <div class="text-start">
                <p class="h6 mb-1">Estamos usando hechizos para hablar con los muertos</p>
                <p class="h1 mb-4">Introduce tu nueva contraseña</p>
            </div>
            
            <form method="POST" action="../php/actualizar_contra.php">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="col-auto mb-4">
                        <input type="password" class="form-control mb-2" name="nueva_contra" placeholder="Contraseña Nueva" required>
                        <input type="password" class="form-control" name="confirmar_contra" placeholder="Vuelve a escribirla" required>
                    </div>
                </div>
                
                <div class="col-12 d-flex flex-wrap justify-content-center gap-2">
                    <button type="submit" class="btn btn-primary mt-1" name="actualizar">Guardar</button>
                    <a href="login.php" class="btn btn-secondary mt-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <img src="../media/images/wizard.png" class="img-fluid d-none d-md-none d-lg-block" id="wizard">
    </div>
</body>
</html>