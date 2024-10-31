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

            // Consulta para obtener el usuario y la cuota de administración
            $sql = "SELECT 
                        users.id AS user_id, 
                        users.email, 
                        users.password, 
                        usuarios.NO_DOCUMENTO, 
                        cuotas_administracion.ID AS CUOTAS_ADMIN_ID 
                    FROM users
                    LEFT JOIN usuarios ON users.usuario_id = usuarios.ID
                    LEFT JOIN cuotas_administracion ON usuarios.ID = cuotas_administracion.USUARIO_ID
                    WHERE users.email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['userId'] = $row['user_id'];
                    $_SESSION['cuotasAdminId'] = $row['CUOTAS_ADMIN_ID'];
                    $_SESSION['docNumber'] = $row['NO_DOCUMENTO'];
                    header("Location: ?c=usuarios&m=cuota");
                    exit;
                } else {
                    $error = "Correo electrónico o contraseña incorrectos";
                }
            }

            $stmt->close();
            $conn->close();
        }
        require_once('views/auth/login_form.php');
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}