<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('config.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['userId'];

// Conecta a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener la información del usuario, documento y cuota
$sql = "SELECT users.email, usuarios.NO_DOCUMENTO, cuotas_administracion.ID AS CUOTAS_ADMIN_ID 
        FROM users
        LEFT JOIN usuarios ON users.usuario_id = usuarios.ID
        LEFT JOIN cuotas_administracion ON usuarios.ID = cuotas_administracion.USUARIO_ID
        WHERE users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $userDetails = $result->fetch_assoc();
    $_SESSION['email'] = $userDetails['email'];
    $_SESSION['cuotasAdminId'] = $userDetails['CUOTAS_ADMIN_ID'];
    $_SESSION['docNumber'] = $userDetails['NO_DOCUMENTO'];
} else {
    echo "No se encontraron detalles para el usuario.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cuota de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cuotas.css">
    <link type="image/x-icon" href="assets/img/logo.png" rel="icon">
</head>

<body>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Generar Cuota de Administración</h4>
                            <div class="col-15">
                                <div class="card">
                                    <div class="card-body">
                                        <?php if (isset($_SESSION['cuotasAdminId']) && isset($_SESSION['docNumber'])): ?>
                                        <button type="button" class="btn btn-primary"
                                            onclick="generateQuote(<?php echo $_SESSION['cuotasAdminId']; ?>, <?php echo $_SESSION['docNumber']; ?>)">
                                            Generar Cuota
                                        </button>
                                        <div id="result"></div>
                                        <?php else: ?>
                                        <p class="text-danger">No se encontró la información necesaria para generar la
                                            cuota.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!-- end container-fluid -->
        </div>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function printContent() {
        window.print();
    }
    </script>
</body>

</html>