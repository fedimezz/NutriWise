<?php
// index.php
session_start();

// Inclusion des contrôleurs
require_once 'controllers/AuthController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/AlimentController.php';

// On récupère la page demandée, sinon 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    // --- FRONTEND ---
    case 'home':
        // On inclut la vue de la page d'accueil
        require_once 'views/front/index.php'; 
        break;

    case 'login':
        $auth = new AuthController();
        $auth->handleLogin();
        break;

    case 'register':
        $auth = new AuthController();
        $auth->handleRegister();
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'profile':
        $user = new UserController();
        $user->profile();
        break;

    case 'aliments':
        $alimentController = new AlimentController();
        $alimentController->frontList();
        break;

    case 'aliment_details':
        $alimentController = new AlimentController();
        $alimentController->details();
        break;

    // --- BACKEND (ADMIN) ---
    case 'admin_dashboard':
        $admin = new AdminController();
        $admin->dashboard();
        break;

    case 'admin_users':
        $admin = new AdminController();
        $admin->listUsers();
        break;

    case 'admin_aliments':
        $alimentController = new AlimentController();
        $alimentController->listAliments();
        break;

    case 'admin_add_aliment':
        $alimentController = new AlimentController();
        $alimentController->addAliment();
        break;

    case 'admin_delete_aliment':
        $alimentController = new AlimentController();
        $alimentController->deleteAliment();
        break;

    case 'admin_edit_aliment':
        $alimentController = new AlimentController();
        $alimentController->editAliment();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page introuvable.";
        break;
}