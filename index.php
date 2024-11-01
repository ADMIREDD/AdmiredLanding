<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = isset($_GET['c']) ? $_GET['c'] : 'Dashboard';
$controller = ucfirst($controller) . 'Controller';
$method = isset($_GET['m']) ? $_GET['m'] : 'dashboard';

$controllerFile = './controllers/' . $controller . '.php';

if (file_exists($controllerFile)) {
    require_once($controllerFile);
    $object = new $controller();
    if (method_exists($object, $method)) {
        $object->$method();
    } else {
        echo "El método $method no existe en el controlador $controller.";
    }
} else {
    echo "El controlador $controller no se ha encontrado.";
}