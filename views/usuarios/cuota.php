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
$sql = "SELECT 
            users.email, 
            usuarios.NO_DOCUMENTO, 
            cuotas_administracion.ID AS CUOTAS_ADMIN_ID, 
            cuotas_administracion.FECHA_MES, 
            cuotas_administracion.ESTADO, 
            cuotas_administracion.VALOR, 
            cuotas_administracion.NO_APTO, 
            cuotas_administracion.FECHA_PAGO
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
    $_SESSION['fechaMes'] = $userDetails['FECHA_MES'];
    $_SESSION['estado'] = $userDetails['ESTADO'];
    $_SESSION['valor'] = $userDetails['VALOR'];
    $_SESSION['noApto'] = $userDetails['NO_APTO'];
    $_SESSION['fechaPago'] = $userDetails['FECHA_PAGO'];
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
                            <h4 class="page-title" id="title">Generar Tu Cuota de Administración</h4>
                            <div class="col-15">
                                <div class="card">
                                    <div class="card-body">
                                        <?php if (isset($_SESSION['cuotasAdminId']) && isset($_SESSION['docNumber'])): ?>
                                        <!-- Botón para generar cuota -->
                                        <button type="button" class="btn btn-primary"
                                            onclick="generateQuote(<?php echo $_SESSION['cuotasAdminId']; ?>, <?php echo $_SESSION['docNumber']; ?>)">
                                            Generar Cuota
                                        </button>
                                        <?php else: ?>
                                        <p class="text-danger">No se encontró la información necesaria para generar la
                                            cuota.</p>
                                        <?php endif; ?>

                                        <!-- Aquí se generará el recibo -->
                                        <div class="recibo" id="result" style="display: none;">
                                            <h1>Este es tu recibo de cuota de administración</h1>
                                            <ul class="recibo1">
                                                <li><strong>NUMERO DOCUMENTO:</strong>
                                                    <?php echo $_SESSION['docNumber']; ?></li>
                                                <li><strong>FECHA MES A PAGAR:</strong>
                                                    <?php echo $_SESSION['fechaMes']; ?></li>
                                                <li><strong>FECHA LIMITE DE PAGO:</strong>
                                                    <?php echo $_SESSION['fechaPago']; ?></li>
                                                <li><strong>ESTADO DEL PAGO:</strong> <?php echo $_SESSION['estado']; ?>
                                                </li>
                                                <li><strong>NUMERO DE APARTAMENTO:</strong>
                                                    <?php echo $_SESSION['noApto']; ?></li>
                                                <li><strong>VALOR DE LA CUOTA:</strong>
                                                    $<?php echo number_format($_SESSION['valor'], 2); ?></li>
                                            </ul>
                                            <h4>Imprime este recibo y dirígete al banco admired y paga el valor de tu
                                                cuota al número de cuenta 0000000001, luego envia el pago al correo
                                                joserosellonl@gmail.com
                                            </h4>
                                            <!-- Botón para imprimir -->
                                            <button type="button" class="btn btn-success" onclick="printContent()">
                                                <h5>Imprimir Recibo</h5>
                                            </button>
                                        </div>
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
    function generateQuote(cuotId, docNumber) {
        // Ocultamos el botón y título cuando se genera la cuota
        document.getElementById('title').style.display = 'none';
        document.querySelector('button').style.display = 'none';
        // Mostramos el recibo con los datos
        document.getElementById('result').style.display = 'block';
    }

    function printContent() {
        window.print();
    }
    </script>
</body>

</html>