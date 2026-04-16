<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/MoteurRecommandationSimple.php';
require_once __DIR__ . '/../model/Recette.php';

class RecommandationController {
    private $db;
    private $moteur;
    private $recette;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->moteur = new MoteurRecommandationSimple($this->db);
        $this->recette = new Recette($this->db);
    }
    
    public function index() {
        // Plus aucun user_id nécessaire !
        $recommandations = $this->moteur->getRecommandations(6);
        
        require_once __DIR__ . '/../view/frontoffice_recommandations.php';
    }
    
    public function similaires($id) {
        $similaires = $this->moteur->getRecettesSimilaires($id, 4);
        
        // Renvoyer directement les données sans vue séparée
        header('Content-Type: application/json');
        echo json_encode($similaires);
    }
}
?>