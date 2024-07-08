<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}
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

    <link type="image/x-icon" href="assets/img/logo.png" rel="icon"> <!-- Ajusta la ruta del logo -->

    <!-- Asegúrate de que la ruta al main.js sea correcta -->
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

                                        <button type="button" class="btn btn-primary" onclick="generateQuote(<?php echo $_SESSION['cuotasAdminId']; ?>, <?php echo $_SESSION['docNumber'] ?>)">Generar Cuota</button>
                                        <div id="result"></div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!-- end container-fluid -->
        </div>
    </div>
    

    <!-- Asegúrate de que la ruta al main.js sea correcta -->
    <script src="../../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printContent() {
            window.print();
        }
    </script>

</body>

</html>