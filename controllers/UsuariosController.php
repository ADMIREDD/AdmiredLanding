<?php

class UsuariosController {
    public function pqr(){
      //  require_once('views/components/layout/head.php');
      require_once('views/usuarios/menu.php');
       require_once('views/usuarios/pqr.php');
       require_once('views/components/layout/footer.php');
    }
    public function reservas_areas(){
        require_once('views/components/layout/head.php');
        require_once('views/usuarios/reservas_areas.php');
        require_once('views/components/layout/footer.php');
     }
     public function cuota(){
        require_once('views/usuarios/menu.php');
        require_once('views/usuarios/cuota.php');
        require_once('views/components/layout/footer.php');
     }
     public function noticias(){
      require_once('views/components/layout/head.php');
      require_once('views/informacion/noticias.php');
      require_once('views/components/layout/footer.php');
   }
}