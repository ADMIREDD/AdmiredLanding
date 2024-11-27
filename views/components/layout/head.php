<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AdmiredLanding</title>
    <link rel="stylesheet" href="assets/css/principal.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="assets/img/favicon.png" type="icon">
</head>

<body>
    <header>
        <div class="container-hero">
            <div class="container hero">
                <span class="logo-lg">
                    <img src="assets/img/admired.png" alt="Logo Admired" height="50">
                </span>
                <div class="container-logo">
                    <h1 class="logo"><a href="#">ADMIRED</a></h1>
                </div>
            </div>
        </div>
        <div class="container-navbar">
            <nav class="navbar container">
                <i class="fa-solid fa-bars menu-toggle"></i>
                <ul class="menu">
                    <li><a href="?c=dashboard&m=dashboard">Inicio</a></li>
                    <li><a href="?c=informacion&m=sobre_nosotros">Sobre Nosotros</a></li>
                    <li><a href="?c=informacion&m=servicios">Servicios</a></li>
                    <li><a href="?c=informacion&m=noticias">Noticias</a></li>
                    <li><a href="?c=informacion&m=contactanos">Contáctanos</a></li>
                    <li><a href="?c=auth&m=show">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        const menu = document.querySelector('.menu');
        menu.classList.toggle('active');
    });
    </script>
</body>