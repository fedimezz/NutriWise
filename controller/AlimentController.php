<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/Aliment.php';

class AlimentController {
    private $db;
    private $aliment;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->aliment = new Aliment($this->db);
    }

    public function index($area = 'front') {
        $keyword = $_GET['search'] ?? '';
        if(!empty($keyword)) {
            $stmt = $this->aliment->search($keyword);
        } else {
            $stmt = $this->aliment->readAll();
        }
        $aliments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($area == 'back') {
            require_once __DIR__ . '/../view/backoffice_aliments_index.php';
        } else {
            require_once __DIR__ . '/../view/frontoffice_aliments_index.php';
        }
    }

    public function create() {
        $categories = $this->aliment->getCategories();
        require_once __DIR__ . '/../view/backoffice_aliments_create.php';
    }

    public function store() {
        $this->aliment->nom = $_POST['nom'];
        $this->aliment->calories = $_POST['calories'];
        $this->aliment->proteins = $_POST['proteins'] ?? 0;
        $this->aliment->glucides = $_POST['glucides'] ?? 0;
        $this->aliment->lipids = $_POST['lipids'] ?? 0;
        $this->aliment->eco_score = $_POST['eco_score'];
        $this->aliment->category_id = $_POST['category_id'];
        $this->aliment->saison = $_POST['saison'];
        $this->aliment->durable = isset($_POST['durable']) ? 1 : 0;

        $result = $this->aliment->create();
        if($result['success']) {
            header("Location: index.php?controller=aliment&action=index&area=back&success=created");
        } else {
            $_SESSION['errors'] = $result['errors'];
            header("Location: index.php?controller=aliment&action=create&area=back");
        }
    }

    public function edit($id) {
        $this->aliment->id = $id;
        $aliment = $this->aliment->readOne();
        $categories = $this->aliment->getCategories();
        require_once __DIR__ . '/../view/backoffice_aliments_edit.php';
    }

    public function update($id) {
        $this->aliment->id = $id;
        $this->aliment->nom = $_POST['nom'];
        $this->aliment->calories = $_POST['calories'];
        $this->aliment->proteins = $_POST['proteins'] ?? 0;
        $this->aliment->glucides = $_POST['glucides'] ?? 0;
        $this->aliment->lipids = $_POST['lipids'] ?? 0;
        $this->aliment->eco_score = $_POST['eco_score'];
        $this->aliment->category_id = $_POST['category_id'];
        $this->aliment->saison = $_POST['saison'];
        $this->aliment->durable = isset($_POST['durable']) ? 1 : 0;

        $result = $this->aliment->update();
        if($result['success']) {
            header("Location: index.php?controller=aliment&action=index&area=back&success=updated");
        } else {
            $_SESSION['errors'] = $result['errors'];
            header("Location: index.php?controller=aliment&action=edit&id=" . $id . "&area=back");
        }
    }

    public function delete($id) {
        $this->aliment->id = $id;
        $this->aliment->delete();
        header("Location: index.php?controller=aliment&action=index&area=back&success=deleted");
    }

    public function show($id) {
        $this->aliment->id = $id;
        $aliment = $this->aliment->readOne();
        require_once __DIR__ . '/../view/frontoffice_aliments_show.php';
    }
}
?>