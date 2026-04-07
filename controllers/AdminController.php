<?php
// controllers/AlimentController.php
require_once 'models/AlimentModel.php';

class AlimentController {
    private $model;

    public function __construct() {
        $this->model = new AlimentModel();
    }

    public function listAliments() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }
        $alimentsList = $this->model->getAllAliments();
        require_once 'views/back/aliments.php';
    }

    public function frontList() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Vous devez être connecté pour accéder aux aliments");
            exit();
        }
        
        $aliments = $this->model->getAllAliments();
        $categories = $this->model->getAllCategories();
        require_once 'views/front/aliments.php';
    }

    public function details() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login&error=Vous devez être connecté pour voir les détails");
            exit();
        }
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Aliment introuvable";
            return;
        }

        $aliment = $this->model->getAlimentById($id);
        require_once 'views/front/aliment_details.php';
    }

    public function addAliment() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom']);
            $category_id = $_POST['category_id'];
            $calories = floatval($_POST['calories']);
            $proteins = floatval($_POST['proteins']);
            $glucides = floatval($_POST['glucides']);
            $lipids = floatval($_POST['lipids']);
            $eco_score = floatval($_POST['eco_score']);

            if(empty($nom)) {
                $error = "Le nom de l'aliment est obligatoire.";
                $categories = $this->model->getAllCategories();
                require_once 'views/back/add_aliment.php';
                return;
            }

            $success = $this->model->addAliment($nom, $category_id, $calories, $proteins, $glucides, $lipids, $eco_score);
            if($success) {
                header("Location: index.php?page=admin_aliments&success=Aliment ajouté avec succès !");
                exit;
            } else {
                $error = "Erreur lors de l'ajout de l'aliment.";
                $categories = $this->model->getAllCategories();
                require_once 'views/back/add_aliment.php';
            }
        } else {
            $categories = $this->model->getAllCategories();
            require_once 'views/back/add_aliment.php';
        }
    }

    public function deleteAliment() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }
        
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->deleteAliment($id);
        }
        header("Location: index.php?page=admin_aliments");
        exit;
    }

    public function editAliment() {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: index.php?page=home");
            exit();
        }
        
        if(!isset($_GET['id'])) {
            header("Location: index.php?page=admin_aliments");
            exit;
        }

        $id = intval($_GET['id']);
        $aliment = $this->model->getAlimentById($id);

        if(!$aliment) {
            header("Location: index.php?page=admin_aliments");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom']);
            $category_id = $_POST['category_id'];
            $calories = floatval($_POST['calories']);
            $proteins = floatval($_POST['proteins']);
            $glucides = floatval($_POST['glucides']);
            $lipids = floatval($_POST['lipids']);
            $eco_score = floatval($_POST['eco_score']);

            if(empty($nom)) {
                $error = "Le nom de l'aliment est obligatoire.";
                $categories = $this->model->getAllCategories();
                require_once 'views/back/edit-aliment.php';
                return;
            }

            $success = $this->model->updateAliment($id, $nom, $category_id, $calories, $proteins, $glucides, $lipids, $eco_score);
            if($success) {
                header("Location: index.php?page=admin_aliments&success=Aliment modifié avec succès !");
                exit;
            } else {
                $error = "Erreur lors de la modification de l'aliment.";
            }
        }

        $categories = $this->model->getAllCategories();
        require_once 'views/back/edit-aliment.php';
    }
}
?>