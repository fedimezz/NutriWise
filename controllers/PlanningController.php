<?php
require_once 'models/PlanningModel.php';

class PlanningController {
    private $model;

    public function __construct() {
        $this->model = new PlanningModel();
    }

    public function listPlannings() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        $plannings = $this->model->getAllPlannings();
        require_once 'views/back/plannings.php';
    }

    public function addPlanning() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        $users = $this->model->getAllUsers();
        $menus = $this->model->getAllMenus();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $startDate = trim($_POST['start_date'] ?? '');
            $endDate = trim($_POST['end_date'] ?? '');
            $userId = intval($_POST['user_id'] ?? 0);
            $status = in_array($_POST['status'] ?? '', ['draft', 'active', 'completed']) ? $_POST['status'] : 'draft';
            $menuIds = isset($_POST['menus']) ? $_POST['menus'] : [];

            if($name === '' || $userId <= 0 || !$startDate || !$endDate) {
                $error = 'Le nom, l’utilisateur et les dates sont obligatoires.';
                require_once 'views/back/add_planning.php';
                return;
            }

            if(strtotime($endDate) < strtotime($startDate)) {
                $error = 'La date de fin doit être postérieure à la date de début.';
                require_once 'views/back/add_planning.php';
                return;
            }

            $success = $this->model->addPlanning($name, $description, $startDate, $endDate, $userId, $_SESSION['user_id'] ?? null, $status, $menuIds);
            if($success) {
                header("Location: index.php?page=admin_plannings&success=Planning ajouté avec succès !");
                exit();
            }

            $error = 'Erreur lors de l’ajout du planning.';
        }

        require_once 'views/back/add_planning.php';
    }

    public function editPlanning() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        if(!isset($_GET['id'])) {
            header("Location: index.php?page=admin_plannings");
            exit();
        }

        $id = intval($_GET['id']);
        $planning = $this->model->getPlanningById($id);
        if(!$planning) {
            header("Location: index.php?page=admin_plannings&error=Planning introuvable");
            exit();
        }

        $users = $this->model->getAllUsers();
        $menus = $this->model->getAllMenus();
        $selectedMenus = array_map(function($menu) { return $menu['id']; }, $this->model->getPlanningMenus($id));

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $startDate = trim($_POST['start_date'] ?? '');
            $endDate = trim($_POST['end_date'] ?? '');
            $userId = intval($_POST['user_id'] ?? 0);
            $status = in_array($_POST['status'] ?? '', ['draft', 'active', 'completed']) ? $_POST['status'] : 'draft';
            $menuIds = isset($_POST['menus']) ? $_POST['menus'] : [];

            if($name === '' || $userId <= 0 || !$startDate || !$endDate) {
                $error = 'Le nom, l’utilisateur et les dates sont obligatoires.';
                require_once 'views/back/edit_planning.php';
                return;
            }

            if(strtotime($endDate) < strtotime($startDate)) {
                $error = 'La date de fin doit être postérieure à la date de début.';
                require_once 'views/back/edit_planning.php';
                return;
            }

            $success = $this->model->updatePlanning($id, $name, $description, $startDate, $endDate, $userId, $status, $menuIds);
            if($success) {
                header("Location: index.php?page=admin_plannings&success=Planning modifié avec succès !");
                exit();
            }

            $error = 'Erreur lors de la modification du planning.';
        }

        require_once 'views/back/edit_planning.php';
    }

    public function deletePlanning() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->deletePlanning($id);
        }

        header("Location: index.php?page=admin_plannings&success=Planning supprimé avec succès !");
        exit();
    }

    public function frontList() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Connectez-vous pour voir vos plannings");
            exit();
        }

        $plannings = $this->model->getPlanningsByUser($_SESSION['user_id']);
        require_once 'views/front/nutrition_plans.php';
    }

    public function details() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Connectez-vous");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if(!$id) {
            header("Location: index.php?page=nutrition_plans");
            exit();
        }

        $planning = $this->model->getPlanningById(intval($id));
        if(!$planning) {
            header("Location: index.php?page=nutrition_plans&error=Planning introuvable");
            exit();
        }

        if(intval($planning['user_id']) !== intval($_SESSION['user_id']) && $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?page=nutrition_plans&error=Accès refusé");
            exit();
        }

        $planningMenus = $this->model->getPlanningMenus(intval($id));
        require_once 'views/front/nutrition_plan_details.php';
    }
}
