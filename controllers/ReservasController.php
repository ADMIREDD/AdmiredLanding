<?php
class ReservasController
{
    public function reservas()
    {
        echo "Método galeria() ejecutado correctamente.";
        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/reservas.php');
        require_once('views/components/layout/footer.php');
    }


}
