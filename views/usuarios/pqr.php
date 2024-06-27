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
    <link rel="stylesheet" href="assets/css/pqr.css">
    <!-- <link rel="stylesheet" href="assets/css/styles.css"> -->
    <title>Cuota de Administración</title>
</head>

<body>
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="containerr">
                                <h1 class="page-title">Peticiones, quejas y reclamos</h1>
                                <form id="formulario">
                                    <!-- <input type="text" name="name" id="name" placeholder="Nombre" required> -->
                                    <textarea name="message" placeholder="Mensaje" id="mensaje" required></textarea>
                                    <!-- <input type="email" name="email" placeholder="Email" required> -->
                                    <button class="button" type="button" onclick="createPQR(<?php echo $_SESSION['userId']; ?>)">Enviar</button>
                                    <button type="button" onclick="window.history.back();" class="styled-button">Volver</button>
                                </form>
                                <div id="pqrResult"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- end container-fluid -->
            </div> <!-- end content -->
        </div>
    </div>
</body>

</html>