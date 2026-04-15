<?php
session_start();

// Correction de l'autoloader
spl_autoload_register(function($class) {
    // Chemins possibles pour les fichiers
    $paths = [
        __DIR__ . '/../model/' . $class . '.php',
        __DIR__ . '/../controller/' . $class . '.php'
    ];
    
    foreach($paths as $path) {
        if(file_exists($path)) {
            require_once $path;
            return;
        }
    }
    
    // Si la classe n'est pas trouvée, afficher une erreur claire
    echo "Classe non trouvée : " . $class . "<br>";
    echo "Chemins recherchés :<br>";
    foreach($paths as $path) {
        echo "- " . $path . "<br>";
    }
});

$controller_name = $_GET['controller'] ?? 'front';
$action = $_GET['action'] ?? 'accueil';
$id = $_GET['id'] ?? null;
$area = $_GET['area'] ?? 'front';

if($controller_name == 'aliment') {
    // Vérifier si la classe existe
    if(class_exists('AlimentController')) {
        $controller = new AlimentController();
        if(method_exists($controller, $action)) {
            if($id) $controller->$action($id);
            else $controller->$action($area);
        } else {
            echo "Action non trouvée : " . $action;
        }
    } else {
        echo "Classe AlimentController non trouvée. Vérifiez que le fichier existe dans : " . __DIR__ . "/../controller/AlimentController.php";
    }
} elseif($controller_name == 'recette') {
    if(class_exists('RecetteController')) {
        $controller = new RecetteController();
        if(method_exists($controller, $action)) {
            if($id) $controller->$action($id);
            else {
                if($action == 'createUser') {
                    $controller->createUser();
                } else {
                    $controller->$action($area);
                }
            }
        } else {
            echo "Action non trouvée : " . $action;
        }
    } else {
        echo "Classe RecetteController non trouvée";
    }
} else {
    if($area == 'back') {
        require_once __DIR__ . '/../view/backoffice_dashboard.php';
    } else {
        require_once __DIR__ . '/../view/frontoffice_accueil.php';
    }
}
?>