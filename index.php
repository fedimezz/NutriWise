<?php
// index.php
session_start();

// Inclusion des contrôleurs
require_once 'controllers/AuthController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/AlimentController.php';

// On récupère la page demandée, sinon on affiche l'accueil (home) par défaut
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    // --- PAGES FRONTEND ---
    case 'home':
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

    case 'motpasse':
        require_once 'views/front/motpasse.php';
        break;

    case 'profile':
        $user = new UserController();
        $user->profile();
        break;
    // --- FRONT ALIMENTS ---
    case 'aliments':
    $alimentController = new AlimentController();
    $alimentController->frontList();
    break;

    case 'aliment_details':
    $alimentController = new AlimentController();
    $alimentController->details();
    break;

    // --- PAGES BACKEND ---
    case 'admin_dashboard':
        $admin = new AdminController();
        $admin->dashboard();
        break;

    case 'admin_users':
        $admin = new AdminController();
        $admin->listUsers();
        break;

    case 'admin_add_user':
        $admin = new AdminController();
        $admin->addUser();
        break;

    case 'admin_edit_user':
        $admin = new AdminController();
        $admin->editUser();
        break;

    case 'admin_delete_user':
        $admin = new AdminController();
        $admin->deleteUser();
        break;

    // --- NOUVEAU : ALIMENTS ---
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

    // --- ERREUR 404 ---
    default:
        echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>";
        echo "<h1>Erreur 404 - Page introuvable</h1>";
        echo "<p>Le routeur ne trouve pas la page : <b>" . htmlspecialchars($page) . "</b></p>";
        echo "<a href='index.php' style='color:blue; text-decoration:none;'>⬅ Retour à l'accueil</a>";
        echo "</div>";
        break;
}
?>