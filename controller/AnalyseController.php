<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/AnalyseurNutritionnel.php';
require_once __DIR__ . '/../model/Aliment.php';
require_once __DIR__ . '/../model/Recette.php';

class AnalyseController {
    private $db;
    private $analyseur;
    private $aliment;
    private $recette;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->analyseur = new AnalyseurNutritionnel($this->db);
        $this->aliment = new Aliment($this->db);
        $this->recette = new Recette($this->db);
    }
    
    public function analyserAliment($id) {
        $this->aliment->id = $id;
        $aliment = $this->aliment->readOne();
        $nutriScore = $this->analyseur->calculerNutriScoreAliment($id);
        $novaScore = $this->analyseur->calculerNovaScore($id);
        
        $analyseur = $this->analyseur;
        
        require_once __DIR__ . '/../view/frontoffice_analyse_aliment.php';
    }
    
    public function analyserRecette($id) {
        // Récupérer les données de l'analyse
        $analyse = $this->analyseur->analyserRecette($id);
        $recommandations = $this->analyseur->getRecommandationsRecetteDetaillees($id);
        
        // Récupérer la recette
        $this->recette->id = $id;
        $recette = $this->recette->readOne();
        
        // Passer toutes les variables à la vue
        $analyseur = $this->analyseur;
        
        require_once __DIR__ . '/../view/frontoffice_analyse_recette.php';
    }
    
    public function comparer() {
        $aliment1_id = $_GET['aliment1'] ?? null;
        $aliment2_id = $_GET['aliment2'] ?? null;
        
        $comparaison = null;
        if ($aliment1_id && $aliment2_id && $aliment1_id != $aliment2_id) {
            $comparaison = $this->analyseur->comparerAliments($aliment1_id, $aliment2_id);
        }
        
        $aliments = $this->aliment->readAll()->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../view/frontoffice_comparateur.php';
    }
}
?>