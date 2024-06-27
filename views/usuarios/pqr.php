<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pqr.css">
    <link rel="stylesheet" href="estilos.css">
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
                                <form id="formulario" action="pqr.php" method="POST">
                                <form id="pqrForm">
    <input type="text" name="name" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="message" placeholder="Mensaje" required></textarea>
    <button type="submit">Enviar PQR</button>
</form>
<div id="pqrResult"></div>
                                    <a href="" class="button">Enviar</a>
                                    <button type="button" onclick="window.history.back();"
                                        class="styled-button">Volver</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- end container-fluid -->
            </div> <!-- end content -->
        </div>
    </div>
    <script src="./assets/js/cuota.js"></script>
</body>

</html>