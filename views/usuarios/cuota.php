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
    <link rel="stylesheet" href="../../assets/css/cuotas.css">

    <link type="image/x-icon" href="../../assets/img/logo.png" rel="icon"> <!-- Ajusta la ruta del logo -->

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
                                        
                                        <button type="button" class="btn btn-primary" onclick="generateQuote(<?php echo $_SESSION['cuotasAdminId']; ?>)">Generar Cuota</button>
                            <div id="quoteResult"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!-- end container-fluid -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="quotaModal" tabindex="-1" aria-labelledby="quotaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quotaModalLabel">Detalles de la Cuota de Administración</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="quotaId"></span></p>
                    <p><strong>FECHA:</strong> <span id="quotaFecha"></span></p>
                    <p><strong>ESTADO:</strong> <span id="quotaEstado"></span></p>
                    <p><strong>FECHA_LIMITE:</strong> <span id="quotaFechaLimite"></span></p>
                    <p><strong>PRECIO:</strong> <span id="quotaPrecio"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Asegúrate de que la ruta al main.js sea correcta -->
    <script src="../../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
