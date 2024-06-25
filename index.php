<?php
$controller = isset($_GET['c']) ? $_GET['c'] : 'Dashboard';
$controller = $controller . 'controller';
$method = isset($_GET['m']) ? $_GET['m'] : 'dashboard';

require_once('./controllers/' . $controller . '.php');
$objet = new $controller();
$objet->$method();
?>





