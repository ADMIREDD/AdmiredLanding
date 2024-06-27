<!-- views/auth/login_form.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="icon" href="assets\img\favicon.png" type="icon">
    <link rel="stylesheet" href="assets\css\login.css"> <!-- Ruta al archivo CSS -->
    <style>
        .logo {
            width: 100px; /* Tamaño de la imagen del logo */
            height: 100px; /* Tamaño de la imagen del logo */
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div>
                <form class="formulario__login" method="POST" action="?c=auth&m=login">

                    <div class="login-container">
                        <h2>Iniciar sesión</h2>
                        <?php if (!empty($error)): ?>
                            <p class="error-message"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required autocomplete="current-password">
                            <label class="label-checkbox">
                                <input type="checkbox" name="remember" checked="checked">
                                "guardar datos en este equipo"
                            </label>
                        </div>
                        <button type="button" onclick="window.history.back();">Volver</button>
                        <button type="submit">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
