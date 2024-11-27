<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

class UsuariosController
{
   public function pqr()
   {
      require_once 'config.php';
      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      if ($conn->connect_error) {
         die("Conexión fallida: " . $conn->connect_error);
      }

      // Consulta para obtener los tipos de PQR
      $sql = "SELECT ID, NOMBRE FROM pqr_tipo";
      $result = $conn->query($sql);

      $pqrTypes = [];
      if ($result && $result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            $pqrTypes[] = $row;
         }
      }
      $conn->close();

      // Pasar los tipos de PQR a la vista
      // Usamos `compact` para pasar la variable `pqrTypes` como un arreglo a la vista
      require_once('views/usuarios/menu.php');
      require_once('views/usuarios/pqr.php');
      require_once('views/components/layout/footer.php');
   }


   public function createPQR()
   {
      session_start();
      header('Content-Type: application/json');

      try {
         $userId = $_POST['user_id'];
         $pqrTypeId = $_POST['pqr_type_id'];
         $message = $_POST['message'];
         $uploadDir = 'uploads/pqr_files/'; // Ruta relativa
         $filePath = null;

         // Crear el directorio si no existe
         if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
               echo json_encode(['success' => false, 'message' => 'Error al crear el directorio de subida.']);
               return;
            }
         }

         // Procesar el archivo si se ha subido
         if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $fileName = basename($_FILES['file']['name']);
            $fileName = preg_replace('/[^a-zA-Z0-9\.\-_]/', '_', $fileName); // Limpiar el nombre del archivo
            $filePath = $uploadDir . uniqid() . '_' . $fileName;


            if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
               echo json_encode(['success' => false, 'message' => 'Error al subir el archivo.']);
               return;
            }
         }

         // Conectar a la base de datos
         require 'config.php';
         $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

         if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
            return;
         }

         $stmt = $conn->prepare("INSERT INTO pqr (DETALLE, ESTADO_ID, USUARIO_ID, PQR_TIPO_ID, FECHA_SOLICITUD, ARCHIVOS) VALUES (?, 2, ?, ?, NOW(), ?)");
         $stmt->bind_param("siis", $message, $userId, $pqrTypeId, $filePath);

         if ($stmt->execute()) {
            $this->sendPqrEmail($userId, $pqrTypeId, $message);
            echo json_encode(['success' => true, 'message' => 'PQR creada con éxito. Se ha enviado un correo electrónico con los detalles de la PQR.']);
         } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear la PQR.']);
         }

         $stmt->close();
         $conn->close();
      } catch (Exception $e) {
         echo json_encode(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
      }
   }



   private function sendPqrEmail($userId, $pqrTypeId, $message)
   {
      // Configuración para obtener datos del usuario
      require_once 'config.php';
      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      $sql = "SELECT u.email, CONCAT(usu.NOMBRE, ' ', usu.APELLIDO) AS nombre_completo 
              FROM users u 
              JOIN usuarios usu ON u.usuario_id = usu.ID 
              WHERE u.id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $userId);
      $stmt->execute();
      $result = $stmt->get_result();
      $userDetails = $result->fetch_assoc();
      $userEmail = $userDetails['email'] ?? '';
      $nombreUsuario = $userDetails['nombre_completo'] ?? 'Usuario';

      // Obtener el nombre del tipo de PQR
      $sql = "SELECT NOMBRE FROM pqr_tipo WHERE ID = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $pqrTypeId);
      $stmt->execute();
      $result = $stmt->get_result();
      $pqrTypeName = $result->fetch_assoc()['NOMBRE'] ?? 'PQR';

      $stmt->close();
      $conn->close();

      // Configurar el correo electrónico
      $mail = new PHPMailer(true);
      try {
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'joserosellonl@gmail.com'; // Cambia a tu email
         $mail->Password = 'jeka plnp gluz hbiy'; // Cambia a tu contraseña
         $mail->SMTPSecure = 'tls';
         $mail->Port = 587;

         $mail->setFrom('joserosellonl@gmail.com', 'Admired'); // Cambia a tu email
         $mail->addAddress($userEmail);

         $mail->isHTML(true);
         $mail->Subject = "Confirmación de PQR - $pqrTypeName";
         $mail->Body = "
              <html>
                  <body>
                      <h1>Confirmación de PQR</h1>
                      <p>Estimado $nombreUsuario,</p>
                      <p>Su PQR de tipo <strong>$pqrTypeName</strong> ha sido recibida exitosamente.</p>
                      <p><strong>Mensaje:</strong> $message</p>
                      <p>Nos pondremos en contacto pronto para informarle sobre el estado de su solicitud.</p>
                      <p>Gracias,<br>El equipo de Admired</p>
                  </body>
              </html>";

         $mail->send();
      } catch (Exception $e) {
         error_log("Error al enviar correo: " . $mail->ErrorInfo);
      }
   }

   public function cuota()
   {
      require_once('views/usuarios/menu.php');
      require_once('views/usuarios/cuota.php');
      require_once('views/components/layout/footer.php');
   }


   public function galeria()
   {
      require_once 'config.php';
      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      if ($conn->connect_error) {
         die("Conexión fallida: " . $conn->connect_error);
      }

      $sql = "SELECT NOMBRE, IMAGEN_URL, PRECIO FROM areas_comunes";

      $result = $conn->query($sql);

      $areas = [];
      if ($result && $result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            $areas[] = $row;
         }
      }
      $_SESSION['areas'] = $areas; // Asignar las áreas a la sesión

      $conn->close();

      require_once('views/usuarios/menu.php');
      require_once('views/usuarios/galeria.php');
      require_once('views/components/layout/footer.php');
   }
}