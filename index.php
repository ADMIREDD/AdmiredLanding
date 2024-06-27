<?php
$controller = isset($_GET['c']) ? $_GET['c'] : 'Dashboard';
$controller = ucfirst($controller) . 'Controller';
$method = isset($_GET['m']) ? $_GET['m'] : 'dashboard';

require_once('./controllers/' . $controller . '.php');
$object = new $controller();
$object->$method();
?>