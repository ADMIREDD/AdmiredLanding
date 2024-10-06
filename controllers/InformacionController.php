<?php

class InformacionController
{

   public function sobre_nosotros()
   {
      require_once('views/components/layout/head.php');
      require_once('views/informacion/sobre_nosotros.php');
      require_once('views/components/layout/footer.php');
   }
   public function contactanos()
   {
      require_once('views/components/layout/head.php');
      require_once('views/informacion/contactanos.php');
      require_once('views/components/layout/footer.php');
   }
   public function servicios()
   {
      require_once('views/components/layout/head.php');
      require_once('views/informacion/servicios.php');
      require_once('views/components/layout/footer.php');
   }

   public function noticias()
   {
      require_once('views/components/layout/head.php');
      require_once('views/informacion/noticias.php');
      require_once('views/components/layout/footer.php');
   }







}
