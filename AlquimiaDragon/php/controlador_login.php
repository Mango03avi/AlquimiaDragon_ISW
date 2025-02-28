<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script>
        function validarFormulario() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            if (email === "" || password === "") {
                alert("Por favor, completa todos los campos.");
                return false; // Evita que el formulario se envíe
            }
            return true; // Permite que el formulario se envíe
        }
    </script>
</head>
<body>
    <form action="login.php" method="POST" onsubmit="return validarFormulario()">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="btningresar">Ingresar</button>
    </form>

    <?php
    // Mostrar mensaje de error si existe
    if (!empty($error)) {
        echo "<script>alert('$error');</script>";
    }
    ?>
</body>
</html>