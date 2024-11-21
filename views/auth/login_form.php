<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="icon" href="assets/img/favicon.png" type="icon">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div>
                <form class="formulario__login" method="POST" action="?c=auth&m=login">
                    <div class="login-container">
                        <h2>Iniciar sesión</h2>
                        <?php if (!empty($error)): ?>
                            <p class="error-message" style="color: red;"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required
                                value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required
                                autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="label-checkbox">
                                <input type="checkbox" name="remember"
                                    <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>>
                                "Guardar datos en este equipo"
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