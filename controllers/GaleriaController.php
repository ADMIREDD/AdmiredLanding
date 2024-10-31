<?php
require_once '/Applications/XAMPP/xamppfiles/htdocs/SENA/AdmiredLanding/config.php';

class GaleriaController
{
    public function galeria()
    {
        // Conectar a la base de datos
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener las áreas comunes
        $sql = "SELECT ID, NOMBRE, DESCRIPCION, IMAGEN_URL, PRECIO, DISPONIBILIDAD FROM areas_comunes";
        $result = $conn->query($sql);

        $areas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $areas[] = $row;
            }
        }

        $conn->close();

        // Pasar las áreas a la vista
        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/galeria.php');
        require_once('views/components/layout/footer.php');
    }
}