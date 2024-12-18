<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIRED</title>
    <link rel="stylesheet" href="assets/css/principal.css" />
    <link rel="icon" href="assets/img/favicon.png" type="icon">
    <script src="assets/js/main.js"></script>
</head>

<body>
    <header>
        <div class="container-hero">
            <div class="container hero">
                <div class="customer-support">
                    <div class="content-customer-support">
                        <img src="assets/img/admired.png" alt="" width="100px">
                    </div>
                </div>

                <div class="container-logo">
                    <h1 class="logo"><a href="">ADMIRED <img src="" alt=""></a></h1>
                </div>
            </div>
        </div>
    </header>

    <div class="container-navbar">
        <nav class="navbar container">
            <i class="fa-solid fa-bars"></i>
            <ul class="menu">
                <li class="<?php echo ($_GET['c'] == 'usuarios' && $_GET['m'] == 'galeria') ? 'active' : ''; ?>">
                    <a href="?c=usuarios&m=galeria">Reservas</a>
                </li>
                <li class="<?php echo ($_GET['c'] == 'usuarios' && $_GET['m'] == 'cuota') ? 'active' : ''; ?>">
                    <a href="?c=usuarios&m=cuota">Cuota de Administración</a>
                </li>
                <li class="<?php echo ($_GET['c'] == 'usuarios' && $_GET['m'] == 'pqr') ? 'active' : ''; ?>">
                    <a href="?c=usuarios&m=pqr">Pqr</a>
                </li>
                <a href="?c=auth&m=logout">Cerrar sesión</a>
            </ul>
        </nav>
    </div>

    <!-- Asegúrate de no tener otro menú en tu archivo principal -->
</body>

</html>