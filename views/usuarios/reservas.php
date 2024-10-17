<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Áreas Comunes</title>
    <link rel="stylesheet" href="./assets/css/principal.css">
    <link rel="stylesheet" href="./assets/css/galeria.css">
    <link rel="stylesheet" href="./assets/css/reservas.css">

    <link type="image/x-icon" href="assets/img/favicon.png" rel="icon">

</head>

<body>
    <div class="container-fluid form-wrapper">
        <div class="container-show-1">
            <!-- Aquí se muestra el título del área correspondiente -->
            <h1>Estas reservando el área de <?php echo $titulo; ?></h1>
            <h3> El área solo se podrá reservar máximo 4 horas.</h3>
            <form id="formulario" method="POST" action="ruta-del-controlador">
                <div class="form-container">
                    <label for="fecha-hora-inicio">FECHA DE RESERVA:</label>
                    <input type="datetime-local" id="fecha-hora-inicio" name="fecha-hora-inicio" required>
                    <label for="fecha-hora-fin">FECHA FIN:</label>
                    <input type="datetime-local" id="fecha-hora-fin" name="fecha-hora-fin" required>
                    <button type="button" onclick="window.history.back();" class="styled-button">Volver</button>
                    <button type="submit" class="button">Reservar</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>