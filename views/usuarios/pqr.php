<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/pqr.css">
    <title>PQR</title>
</head>

<body>
    <div class="content-page">
        <div class="container-form">
            <h1>Si tienes peticiones, quejas, reclamos o sugerencias, llena los datos y da clic en "Enviar PQR".</h1>
            <form id="pqrForm" enctype="multipart/form-data">
                <label for="pqr_type">Tipo de PQR</label>
                <select name="pqr_type_id" id="pqr_type">
                    <?php if (!empty($pqrTypes)) : ?>
                        <?php foreach ($pqrTypes as $type) : ?>
                            <option value="<?php echo htmlspecialchars($type['ID']); ?>">
                                <?php echo htmlspecialchars($type['NOMBRE']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="">No hay tipos de PQR disponibles</option>
                    <?php endif; ?>
                </select>


                <textarea name="message" placeholder="Escribe tu mensaje aquí" required></textarea>

                <label class="file-label" for="fileInput">El Archivo no es Obligatorio</label>
                <input class="styled-button" type="file" name="file" id="fileInput">
                <button class="button" type="button" onclick="createPQR(<?php echo $_SESSION['userId']; ?>)">Enviar
                    PQR</button>
            </form>
            <div id="pqrResult"></div>
        </div>
    </div>

    <script>
        function createPQR(userId) {
            const form = document.getElementById('pqrForm');
            const formData = new FormData(form);
            formData.append('user_id', userId);

            fetch('?c=usuarios&m=createPQR', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    const resultDiv = document.getElementById('pqrResult');
                    resultDiv.innerHTML = data.message;
                    resultDiv.style.color = data.success ? 'green' : 'red';

                    if (data.success) {
                        form.reset();
                    }

                    // Mostrar el mensaje y ocultarlo después de 8 segundos
                    resultDiv.style.display = 'block';
                    setTimeout(() => {
                        resultDiv.style.display = 'none';
                    }, 8000); // 8000 ms = 8 segundos
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('pqrResult').innerHTML = 'Error al procesar la solicitud.';
                });
        }
    </script>

</body>

</html>