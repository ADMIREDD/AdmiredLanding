<?php
session_start(); // Iniciar la sesión aquí para manejar la autenticación

// Incluir el archivo de configuración de la base de datos
require_once('config.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener la contraseña encriptada del usuario
    $sql = "SELECT * FROM usuarios WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['CONTRASENA'];

        // Verificar la contraseña utilizando password_verify
        if (password_verify($password, $hashedPassword)) {
            // Usuario autenticado correctamente
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            header("Location: headd.php"); // Redirigir a la página de headd.php
            exit;
        } else {
            // Contraseña incorrecta
            $error = "Correo electrónico o contraseña incorrectos";
        }
    } else {
        // Usuario no encontrado
        $error = "Correo electrónico o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="icon" href="assets\img\favicon.png" type="icon">

    <link rel="stylesheet" href="assets\css\login.css"> <!-- Ruta al archivo CSS -->
    <img src="assets\img\logo.jpg" alt="Logo" class="logo">
</head>
<body>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div>
                <form class="formulario__login" method="POST" action="login.php">

                    <div class="login-container">
                        <h2>Iniciar sesión</h2>
                        <?php if (!empty($error)): ?>
                            <p class="error-message"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required value>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required autocomplete>
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