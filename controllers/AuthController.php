<?php
session_start();
require_once('config.php');

class AuthController
{
    public function show()
    {
        require_once('views/auth/login_form.php');
    }

    public function login()
    {
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
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];
                $cuotasAdminId = $row['CUOTAS_ADMIN_ID'];
                $userId = $row['ID'];
                $docNumber = $row['NO_DOCUMENTO'];

                // Verificar la contraseña utilizando password_verify
                if (password_verify($password, $hashedPassword)) {
                    // Usuario autenticado correctamente
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['cuotasAdminId'] = $cuotasAdminId;
                    $_SESSION['userId'] = $userId;
                    $_SESSION['docNumber'] = $docNumber;
                    header("Location: ?c=usuarios&m=cuota"); // Redirigir a la página de menú
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
        // Mostrar el formulario de inicio de sesión nuevamente con el error
        require_once('views/auth/login_form.php');
    }

    public function logout()
    {
        // Cerrar sesión
        $_SESSION = array();
        session_destroy();
        header("Location: index.php"); // Redirigir a la página principal
        exit;
    }
}

