<?php
class ReservasController
{
    public function reservas()
    {
        // Verificar si se ha recibido el parámetro 'area' a través de la URL
        $area = isset($_GET['area']) ? $_GET['area'] : '';

        // Definir el título basado en el área
        $titulo = '';
        switch ($area) {
            case 'gym':
                $titulo = 'Gimnasio (GYM)';
                break;
            case 'piscina':
                $titulo = 'Piscina';
                break;
            case 'bbq':
                $titulo = 'Zona BBQ';
                break;
            case 'salon_comunal':
                $titulo = 'Salón Comunal';
                break;
            case 'terraza_eventos':
                $titulo = 'Terraza de Eventos';
                break;
            case 'cancha_futbol':
                $titulo = 'Cancha de Fútbol';
                break;
            case 'salon_juegos':
                $titulo = 'Salón de Juegos';
                break;
            case 'salon_infantil':
                $titulo = 'Salón Infantil';
                break;
            default:
                $titulo = 'Área Desconocida';
                break;
        }

        // Cargar las vistas y pasar la variable $titulo
        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/reservas.php');
        require_once('views/components/layout/footer.php');
    }
}
