<?php
session_start();

spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/model/' . $class . '.php',
        __DIR__ . '/controller/' . $class . '.php'
    ];
    foreach($paths as $path) {
        if(file_exists($path)) {
            require_once $path;
            break;
        }
    }
});

$controller_name = $_GET['controller'] ?? 'front';
$action = $_GET['action'] ?? 'accueil';
$id = $_GET['id'] ?? null;
$area = $_GET['area'] ?? 'front';

if($controller_name == 'aliment') {
    $controller = new AlimentController();
    if(method_exists($controller, $action)) {
        if($id) $controller->$action($id, $area);
        else $controller->$action($area);
    }
} elseif($controller_name == 'recette') {
    $controller = new RecetteController();
    if(method_exists($controller, $action)) {
        if($id) $controller->$action($id, $area);
        else $controller->$action($area);
    }
} else {
    if($area == 'back') require_once __DIR__ . '/view/backoffice_dashboard.php';
    else require_once __DIR__ . '/view/frontoffice_accueil.php';
}
?>