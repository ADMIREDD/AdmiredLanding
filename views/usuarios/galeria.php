<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Áreas Comunes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/reservas.css">
    <link rel="icon" href="assets/img/favicon.png" type="icon">
</head>

<body>
    <!-- Aquí va tu contenido de la galería -->
    <div class="container-products">
        <?php if (isset($_SESSION['areas']) && is_array($_SESSION['areas'])): ?>
        <?php foreach ($_SESSION['areas'] as $area): ?>
        <div class="card-product">
            <div class="container-img">
                <h2><?php echo htmlspecialchars($area['NOMBRE']); ?></h2><br>
                <img src="<?php echo htmlspecialchars($area['IMAGEN_URL']); ?>"
                    alt="<?php echo htmlspecialchars($area['NOMBRE']); ?>" />
            </div><br>
            <div class="content-card-product">
                <span class="add-cart">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <p class="price">$<?php echo number_format($area['PRECIO'], 2); ?></p>
                </span>
                <li><a href="?c=reservas&m=reservas&area=<?php echo urlencode(strtolower($area['NOMBRE'])); ?>"
                        class="btn-option6">Reservar</a></li>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No hay áreas disponibles para mostrar.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para mostrar mensajes -->
    <?php if (isset($_SESSION['reservationMessage']) && $_SESSION['messageType'] === 'success'): ?>
    <div id="messageModal" class="modal" style="display: flex;">
        <div class="modal-content" style="background-color: #4CAF50;">
            <span class="close-btn" onclick="closeModal('messageModal')">&times;</span>
            <p><?php echo htmlspecialchars($_SESSION['reservationMessage']); ?></p>
        </div>
    </div>
    <?php unset($_SESSION['reservationMessage'], $_SESSION['messageType']); ?>
    <?php endif; ?>

    <style>
    .modal {
        display: flex;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        color: white;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 400px;
        text-align: center;
        font-family: Arial, sans-serif;
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

    <script>
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }
    window.onload = function() {
        if (document.getElementById("messageModal")) {
            setTimeout(function() {
                closeModal("messageModal");
            }, 8000);
        }
    };
    </script>

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>