<?php

class GaleriaController
{
    public function galeria()
    {

        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/galeria.php');
        require_once('views/components/layout/footer.php');
    }

    public function index()
    {
        // Asegúrate de cargar la vista de galería
        require_once('views/usuarios/galeria.php');
    }
}