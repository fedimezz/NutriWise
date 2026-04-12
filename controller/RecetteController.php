<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/Recette.php';

class RecetteController {
    private $db;
    private $recette;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->recette = new Recette($this->db);
    }

    public function index($area = 'front') {
        $keyword = $_GET['search'] ?? '';
        if($area == 'back') {
            if(!empty($keyword)) {
                $stmt = $this->recette->search($keyword);
            } else {
                $stmt = $this->recette->readAll();
            }
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            require_once __DIR__ . '/../view/backoffice_recettes_index.php';
        } else {
            if(!empty($keyword)) {
                $stmt = $this->recette->search($keyword);
                $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $this->recette->readPublished();
                $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            require_once __DIR__ . '/../view/frontoffice_recettes_index.php';
        }
    }

    public function create() {
        require_once __DIR__ . '/../view/backoffice_recettes_create.php';
    }

    public function store() {
        $this->recette->title = $_POST['title'];
        $this->recette->description = $_POST['description'];
        $this->recette->instructions = $_POST['instructions'];
        $this->recette->duree = $_POST['duree'];
        $this->recette->difficulte = $_POST['difficulte'];
        $this->recette->saison = $_POST['saison'];
        $this->recette->statut = $_POST['statut'];
        $this->recette->score_durabilite = $_POST['score_durabilite'];

        $result = $this->recette->create();
        if($result['success']) {
            header("Location: index.php?controller=recette&action=index&area=back&success=created");
        } else {
            $_SESSION['errors'] = $result['errors'];
            header("Location: index.php?controller=recette&action=create&area=back");
        }
    }

    public function edit($id) {
        $this->recette->id = $id;
        $recette = $this->recette->readOne();
        require_once __DIR__ . '/../view/backoffice_recettes_edit.php';
    }

    public function update($id) {
        $this->recette->id = $id;
        $this->recette->title = $_POST['title'];
        $this->recette->description = $_POST['description'];
        $this->recette->instructions = $_POST['instructions'];
        $this->recette->duree = $_POST['duree'];
        $this->recette->difficulte = $_POST['difficulte'];
        $this->recette->saison = $_POST['saison'];
        $this->recette->statut = $_POST['statut'];
        $this->recette->score_durabilite = $_POST['score_durabilite'];

        $result = $this->recette->update();
        if($result['success']) {
            header("Location: index.php?controller=recette&action=index&area=back&success=updated");
        } else {
            $_SESSION['errors'] = $result['errors'];
            header("Location: index.php?controller=recette&action=edit&id=" . $id . "&area=back");
        }
    }

    public function delete($id) {
        $this->recette->id = $id;
        $this->recette->delete();
        header("Location: index.php?controller=recette&action=index&area=back&success=deleted");
    }

    public function show($id) {
        $this->recette->id = $id;
        $recette = $this->recette->readOne();
        require_once __DIR__ . '/../view/frontoffice_recettes_show.php';
    }
}
?>