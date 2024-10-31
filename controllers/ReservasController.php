<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/Applications/XAMPP/xamppfiles/htdocs/SENA/AdmiredLanding/vendor/phpmailer/phpmailer/src/Exception.php';
require '/Applications/XAMPP/xamppfiles/htdocs/SENA/AdmiredLanding/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/Applications/XAMPP/xamppfiles/htdocs/SENA/AdmiredLanding/vendor/phpmailer/phpmailer/src/SMTP.php';

require_once '/Applications/XAMPP/xamppfiles/htdocs/SENA/AdmiredLanding/config.php';

class ReservasController
{
    public function reservas()
    {
        $area = isset($_GET['area']) ? $_GET['area'] : '';

        // Conectar a la base de datos
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Modificar el nombre del área para evitar problemas de mayúsculas/minúsculas o caracteres especiales
        $areaFormatted = str_replace('_', ' ', ucwords($area));

        // Consultar el área común en la base de datos (ignorar mayúsculas y minúsculas)
        $sql = "SELECT ID, NOMBRE FROM areas_comunes WHERE LOWER(NOMBRE) = LOWER(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $areaFormatted);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $areaData = $result->fetch_assoc();
            $titulo = $areaData['NOMBRE'];
            $areaId = $areaData['ID'];
        } else {
            echo "<script>
            alert('El área seleccionada no existe. Por favor, selecciona una área válida.');
            window.location.href = '?c=galeria&m=index';
        </script>";
            $stmt->close();
            $conn->close();
            return;
        }

        $stmt->close();
        $conn->close();

        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/reservas.php');
        require_once('views/components/layout/footer.php');
    }


    public function crearReserva()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: index.php");
            exit;
        }

        $userId = $_SESSION['userId'];
        $fechaInicio = $_POST['fecha-hora-inicio'];
        $fechaFin = $_POST['fecha-hora-fin'];
        $areaId = $_POST['area_id'];

        // Conectar a la base de datos
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verificar si el área existe en la base de datos
        $sql = "SELECT PRECIO FROM areas_comunes WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $areaId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<script>
                alert('El área seleccionada no existe. Por favor, selecciona una área válida.');
                window.location.href = '?c=reservas&m=reservas';
            </script>";
            $stmt->close();
            $conn->close();
            return;
        }

        $valorReserva = $result->fetch_assoc()['PRECIO'];
        $stmt->close();

        // Insertar reserva en la base de datos
        $sql = "INSERT INTO reservas (FECHA_RESERVA, FECHA_FIN, ID_AREA_COMUN, ID_USUARIO, VALOR, ID_ESTADO_RESERVA) 
                VALUES (?, ?, ?, ?, ?, 1)"; // Estado "Pendiente"
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiid", $fechaInicio, $fechaFin, $areaId, $userId, $valorReserva);

        if ($stmt->execute()) {
            $this->enviarCorreoReserva($userId, $areaId, $fechaInicio, $fechaFin, $valorReserva);
            echo "<div id='successMessage' style='
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
    z-index: 1000;
    font-size: 16px;
'>Reserva creada con éxito. Se envió la información de la reserva al correo y pronto será confirmada.</div>
<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
        window.location.href = '?c=galeria&m=galeria'; // Cambiado para redirigir a la galería
    }, 8000);
</script>";
        }

        $stmt->close();
        $conn->close();
    }


    private function enviarCorreoReserva($userId, $areaId, $fechaInicio, $fechaFin, $valorReserva, $observacionEntrega = null, $observacionRecibe = null, $estadoReservaId = 1)
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT u.email, CONCAT(usu.NOMBRE, ' ', usu.APELLIDO) AS nombre_completo 
            FROM users u 
            JOIN usuarios usu ON u.usuario_id = usu.ID 
            WHERE u.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $userDetails = ($result->num_rows == 1) ? $result->fetch_assoc() : [];
        $userEmail = $userDetails['email'] ?? '';
        $nombreUsuario = $userDetails['nombre_completo'] ?? 'Usuario';

        $sql = "SELECT NOMBRE FROM areas_comunes WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $areaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $areaNombre = ($result->num_rows == 1) ? $result->fetch_assoc()['NOMBRE'] : 'Área Desconocida';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'joserosellonl@gmail.com';
            $mail->Password = 'jeka plnp gluz hbiy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('joserosellon@gmail.com', 'Admired');
            $mail->addAddress($userEmail);

            $styles = "
            body { font-family: Arial, sans-serif; color: #333; }
            .container { width: 90%; margin: auto; padding: 20px; border: 1px solid #ddd; }
            h1 { color: #0056b3; }
            p { font-size: 14px; line-height: 1.6; }
            ";

            $mail->isHTML(true);
            $mail->Subject = "Actualización de Reserva";
            $mail->Body = '<html><head><style>' . $styles . '</style></head><body>';
            $mail->Body .= '<div class="container">';
            $mail->Body .= '<h1>Actualización de Reserva</h1>';
            $mail->Body .= '<p>Estimado ' . htmlspecialchars($nombreUsuario) . ',</p>';
            $mail->Body .= '<p>Su reserva ha sido actualizada con éxito. A continuación, encontrará los detalles de su reserva:</p>';
            $mail->Body .= '<p><strong>Fecha de Inicio:</strong> ' . htmlspecialchars($fechaInicio) . '</p>';
            $mail->Body .= '<p><strong>Fecha de Fin:</strong> ' . htmlspecialchars($fechaFin) . '</p>';
            $mail->Body .= '<p><strong>Área Común:</strong> ' . htmlspecialchars($areaNombre) . '</p>';
            $mail->Body .= '<p><strong>Observación Entrega:</strong> ' . htmlspecialchars($observacionEntrega ?: 'No disponible') . '</p>';
            $mail->Body .= '<p><strong>Observación Recibe:</strong> ' . htmlspecialchars($observacionRecibe ?: 'No disponible') . '</p>';
            $mail->Body .= '<p><strong>Valor:</strong> $' . number_format($valorReserva, 2) . '</p>';
            $mail->Body .= '<p><strong>Estado de Reserva:</strong> ' . $this->getEstadoReserva($estadoReservaId) . '</p>';
            $mail->Body .= '<p>Gracias por utilizar nuestro servicio.</p>';
            $mail->Body .= '<p>Atentamente,<br>El equipo de Admired</p>';
            $mail->Body .= '</div>';
            $mail->Body .= '</body></html>';

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    private function getEstadoReserva($estadoReservaId)
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT DESCRIPCION FROM estados_reserva WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $estadoReservaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $descripcion = ($result->num_rows == 1) ? $result->fetch_assoc()['DESCRIPCION'] : 'Desconocido';
        $stmt->close();
        $conn->close();
        return $descripcion;
    }
}