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
            $remember = isset($_POST['remember']);

            // Crear la URL del API
            $apiUrl = 'http://localhost:8080/api/users/login';

            // Inicializar cURL
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);

            // Enviar datos en formato JSON
            $data = json_encode([
                'email' => $email,
                'password' => $password
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ]);

            // Ejecutar la solicitud y obtener la respuesta
            $response = curl_exec($ch);
            if ($response === false) {
                $error = 'Error de cURL: ' . curl_error($ch);
                curl_close($ch);
                require_once('views/auth/login_form.php');
                return; // Salir del método
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Decodificar la respuesta JSON
            $data = json_decode($response, true);

            // Verificar si la respuesta es válida
            if (is_null($data)) {
                $error = 'Respuesta no válida de la API: ' . $response;
                require_once('views/auth/login_form.php');
                return;
            }

            // Verificar si el inicio de sesión fue exitoso
            if ($httpCode == 200) {
                $_SESSION['loggedin'] = true;
                $_SESSION['token'] = $data['token'];
                $_SESSION['userId'] = $data['userId'];

                // Manejar "Recordarme"
                if ($remember) {
                    setcookie('email', $email, time() + (86400 * 30), "/"); // 30 días
                } else {
                    setcookie('email', '', time() - 3600, "/"); // Eliminar cookie
                }

                header("Location: ?c=usuarios&m=galeria");

                exit;
            } else {
                $error = $data['error'] ?? "Error al iniciar sesión. Código HTTP: $httpCode";
            }
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