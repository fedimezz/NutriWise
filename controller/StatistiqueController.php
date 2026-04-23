<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/Statistique.php';

class StatistiqueController {
    private $db;
    private $statistique;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->statistique = new Statistique($this->db);
    }
    
    /**
     * Page des statistiques (backoffice)
     */
    public function index() {
        $stats = $this->statistique->getDashboardStats();
        require_once __DIR__ . '/../view/backoffice_statistiques.php';
    }
    
    /**
     * Page des statistiques (frontoffice)
     */
    public function front() {
        $stats = $this->statistique->getDashboardStats();
        require_once __DIR__ . '/../view/frontoffice_statistiques.php';
    }
}
?>