<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}

// Datos de ejemplo (puedes obtener estos datos de una base de datos)
$cuotaId = $_SESSION['cuotasAdminId'];
$numeroApto = $_SESSION['docNumber'];
$valor = 100000; // Valor de la cuota
$estado = "Pendiente";
$fechaMes = date("Y-m"); // Mes y año actual
$fechaPago = date("Y-m-d"); // Fecha actual

// Aquí puedes agregar la lógica para actualizar el estado y la fecha de pago según sea necesario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cuota de Administración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos generales -->
    <link rel="stylesheet" href="assets/css/cuotas.css">
    <link type="image/x-icon" href="assets/img/logo.png" rel="icon">
</head>

<body>
    <div class="container mt-5">
        <h4 class="text-center">Generar Cuota de Administración</h4>
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body text-center">
                <button type="button" class="btn btn-primary" onclick="generateReceipt()">Generar Cuota</button>
                <div id="receipt" class="mt-4" style="display:none;">
                    <h5>Recibo de Pago</h5>
                    <p>ID: <span id="receipt-id"></span></p>
                    <p>Mes: <span id="receipt-fecha-mes"></span></p>
                    <p>Estado: <span id="receipt-estado"></span></p>
                    <p>Valor: <span id="receipt-valor"></span></p>
                    <p>Número de Apartamento: <span id="receipt-numero-apto"></span></p>
                    <p>Fecha de Pago: <span id="receipt-fecha-pago"></span></p>
                    <button class="btn btn-secondary" onclick="printContent()">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateReceipt() {
            document.getElementById('receipt-id').innerText = '<?php echo $cuotaId; ?>';
            document.getElementById('receipt-fecha-mes').innerText = '<?php echo $fechaMes; ?>';
            document.getElementById('receipt-estado').innerText = '<?php echo $estado; ?>';
            document.getElementById('receipt-valor').innerText = '<?php echo $valor; ?>';
            document.getElementById('receipt-numero-apto').innerText = '<?php echo $numeroApto; ?>';
            document.getElementById('receipt-fecha-pago').innerText = '<?php echo $fechaPago; ?>';
            document.getElementById('receipt').style.display = 'block';
        }

        function printContent() {
            window.print();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
