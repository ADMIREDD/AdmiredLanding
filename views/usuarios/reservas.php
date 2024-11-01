<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Áreas Comunes</title>
    <link rel="stylesheet" href="./assets/css/principal.css">
    <link rel="stylesheet" href="./assets/css/galeria.css">
    <link rel="stylesheet" href="./assets/css/reservas.css">

    <style>
    .message-box {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f44336;
        /* Color de fondo rojo */
        color: white;
        padding: 15px;
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
        font-family: Arial, sans-serif;
        width: 90%;
        max-width: 400px;
        z-index: 1000;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content {
        padding: 15px;
        border-radius: 5px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        color: white;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container-fluid form-wrapper">
        <div class="container-show-1">
            <h1>Estás reservando el área de <?php echo htmlspecialchars($titulo); ?></h1>
            <h3>El área solo se podrá reservar máximo 4 horas.</h3>
            <form id="formulario" method="POST" action="?c=reservas&m=crearReserva">
                <input type="hidden" name="area_id" value="<?php echo htmlspecialchars($areaId); ?>">
                <div class="form-container">
                    <label for="fecha-hora-inicio">FECHA DE RESERVA:</label>
                    <input type="datetime-local" id="fecha-hora-inicio" name="fecha-hora-inicio" required>
                    <label for="fecha-hora-fin">FECHA FIN:</label>
                    <input type="datetime-local" id="fecha-hora-fin" name="fecha-hora-fin" required>
                    <button type="submit" class="button">Crear Reserva</button>
                    <button type="button" onclick="window.history.back();" class="styled-button">Volver</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mensaje de Conflicto -->
    <?php if (isset($_SESSION['reservationMessage']) && $_SESSION['messageType'] === 'error'): ?>
    <div id="messageBox" class="message-box">
        <?php echo htmlspecialchars($_SESSION['reservationMessage']); ?>
    </div>
    <?php
        // Limpiar la sesión para evitar que el mensaje se muestre de nuevo
        unset($_SESSION['reservationMessage']);
        unset($_SESSION['messageType']);
        ?>
    <?php endif; ?>

    <script>
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Cerrar automáticamente el mensaje después de 8 segundos
    window.onload = function() {
        const messageBox = document.getElementById("messageBox");
        if (messageBox) {
            setTimeout(function() {
                messageBox.style.display = "none";
            }, 8000);
        }
    };
    </script>
</body>

</html>