<?php
require_once 'models/PlanAlimentaireModel.php';

class PlanAlimentaireController {
    private $model;

    public function __construct() {
        $this->model = new PlanAlimentaireModel();
    }

    public function listPlans() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        $plansList = $this->model->getAllPlans();
        require_once 'views/back/plan_alimentaires.php';
    }

    public function addPlan() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        $users = $this->model->getAllUsers();
        $aliments = $this->model->getAllAliments();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $week = intval($_POST['week'] ?? 0);
            $userId = intval($_POST['user_id'] ?? 0);
            $alimentIds = isset($_POST['aliments']) ? $_POST['aliments'] : [];

            if($week <= 0 || $userId <= 0) {
                $error = "La semaine et l'utilisateur sont obligatoires.";
                require_once 'views/back/add_plan_alimentaire.php';
                return;
            }

            $success = $this->model->addPlan($week, $userId, $alimentIds);

            if($success) {
                header("Location: index.php?page=admin_plan_alimentaires&success=Plan alimentaire ajouté avec succès !");
                exit();
            }

            $error = "Erreur lors de l'ajout du plan alimentaire.";
        }

        require_once 'views/back/add_plan_alimentaire.php';
    }

    public function editPlan() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        if(!isset($_GET['id'])) {
            header("Location: index.php?page=admin_plan_alimentaires");
            exit();
        }

        $id = intval($_GET['id']);
        $plan = $this->model->getPlanById($id);

        if(!$plan) {
            header("Location: index.php?page=admin_plan_alimentaires&error=Plan introuvable");
            exit();
        }

        $users = $this->model->getAllUsers();
        $aliments = $this->model->getAllAliments();
        $selectedAliments = $this->model->getSelectedAlimentIds($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $week = intval($_POST['week'] ?? 0);
            $userId = intval($_POST['user_id'] ?? 0);
            $alimentIds = isset($_POST['aliments']) ? $_POST['aliments'] : [];

            if($week <= 0 || $userId <= 0) {
                $error = "La semaine et l'utilisateur sont obligatoires.";
                require_once 'views/back/edit_plan_alimentaire.php';
                return;
            }

            $success = $this->model->updatePlan($id, $week, $userId, $alimentIds);

            if($success) {
                header("Location: index.php?page=admin_plan_alimentaires&success=Plan alimentaire modifié avec succès !");
                exit();
            }

            $error = "Erreur lors de la modification du plan alimentaire.";
            $selectedAliments = $alimentIds;
        }

        require_once 'views/back/edit_plan_alimentaire.php';
    }

    public function deletePlan() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }

        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->deletePlan($id);
        }

        header("Location: index.php?page=admin_plan_alimentaires&success=Plan alimentaire supprimé avec succès !");
        exit();
    }

    public function frontList() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Connectez-vous pour voir vos plans alimentaires");
            exit();
        }

        $plans = $this->model->getPlansByUser($_SESSION['user_id']);
        require_once 'views/front/plan_alimentaires.php';
    }

    public function details() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Connectez-vous");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if(!$id) {
            header("Location: index.php?page=plan_alimentaires");
            exit();
        }

        $plan = $this->model->getPlanById(intval($id));

        if(!$plan) {
            header("Location: index.php?page=plan_alimentaires&error=Plan introuvable");
            exit();
        }

        if($_SESSION['user_role'] !== 'admin' && intval($plan['user_id']) !== intval($_SESSION['user_id'])) {
            header("Location: index.php?page=plan_alimentaires&error=Accès refusé");
            exit();
        }

        $planAliments = $this->model->getPlanAliments(intval($id));
        require_once 'views/front/plan_alimentaire_details.php';
    }
}
?>
