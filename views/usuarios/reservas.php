<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Áreas Comunes</title>
    <link rel="stylesheet" href="assets/css/reservas.css">
</head>

<body>
    <div class="container-fluid form-wrapper">
        <div class="container-show-1">
            <h1>Estás reservando el área de <?php echo htmlspecialchars($titulo); ?></h1>
            <h3>El área solo se podrá reservar entre 2 y 4 horas.</h3>
            <form id="formulario" method="POST" action="?c=reservas&m=crearReserva">
                <input type="hidden" name="area_id" value="<?php echo htmlspecialchars($areaId); ?>">
                <div class="form-container">
                    <label for="fecha-hora-inicio">Fecha y Hora de Inicio:</label>
                    <input type="datetime-local" id="fecha-hora-inicio" name="fecha-hora-inicio" required>

                    <!-- Mensaje de error dinámico -->
                    <div id="mensaje-rojo" style="color: red; font-size: 14px; display: none; margin-bottom: 10px;">
                        La duración de la reserva debe ser entre 2 y 4 horas.
                    </div>
                    <!-- Mensaje de error por conflicto de horario -->
                    <div id="mensaje-conflicto"
                        style="color: red; font-size: 14px; display: none; margin-bottom: 10px;">
                        El área seleccionada ya está reservada en el horario seleccionado. Por favor, elige otro
                        horario.
                    </div>


                    <label for="fecha-hora-fin">Fecha y Hora de Fin:</label>
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
        unset($_SESSION['reservationMessage']);
        unset($_SESSION['messageType']);
        ?>
    <?php endif; ?>

    <script>
    // Validación de rango de tiempo
    document.getElementById("formulario").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        const inicio = new Date(document.getElementById("fecha-hora-inicio").value);
        const fin = new Date(document.getElementById("fecha-hora-fin").value);
        const diferenciaHoras = (fin - inicio) / (1000 * 60 * 60);

        // Validación de rango de tiempo
        const mensajeRojo = document.getElementById("mensaje-rojo");
        const mensajeConflicto = document.getElementById("mensaje-conflicto");
        mensajeConflicto.style.display = "none"; // Reinicia el mensaje de conflicto

        if (diferenciaHoras < 2 || diferenciaHoras > 4) {
            mensajeRojo.style.display = "block"; // Mostrar el mensaje de rango inválido
            return;
        } else {
            mensajeRojo.style.display = "none"; // Ocultar el mensaje si todo está bien
        }

        // Envío del formulario usando fetch para validar en el servidor
        const formData = new FormData(this);

        fetch(this.action, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Mostrar mensaje de error por conflicto de horario
                    mensajeConflicto.style.display = "block";
                    mensajeConflicto.textContent = data.message;
                } else {
                    // Redirigir si todo fue exitoso
                    window.location.href = "?c=galeria&m=galeria";
                }
            })
            .catch(error => console.error("Error:", error));
    });


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