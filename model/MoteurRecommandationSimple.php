<?php
class MoteurRecommandationSimple {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Recommandations principales (page d'accueil des recommandations)
     */
    public function getRecommandations($limit = 6) {
        $recettes = [];
        
        // 1. Recettes de saison (priorité 1)
        $saison = $this->getRecommandationsParSaison($limit);
        $recettes = array_merge($recettes, $saison);
        
        // 2. Top recettes notées (priorité 2)
        $top = $this->getTopRecettes($limit);
        $recettes = array_merge($recettes, $top);
        
        // 3. Recettes les plus consultées (priorité 3)
        $populaires = $this->getRecettesPopulaires($limit);
        $recettes = array_merge($recettes, $populaires);
        
        // 4. Recettes aléatoires (priorité 4 - pour compléter)
        if (count($recettes) < $limit) {
            $aleatoires = $this->getRecettesAleatoires($limit);
            $recettes = array_merge($recettes, $aleatoires);
        }
        
        // Supprimer les doublons
        $ids = [];
        $unique = [];
        foreach ($recettes as $recette) {
            if (!in_array($recette['id'], $ids)) {
                $ids[] = $recette['id'];
                $unique[] = $recette;
            }
        }
        
        return array_slice($unique, 0, $limit);
    }
    
    /**
     * Recettes de saison
     */
    public function getRecommandationsParSaison($limit = 5) {
        $mois = date('n');
        if ($mois >= 3 && $mois <= 5) $saison = 'Printemps';
        elseif ($mois >= 6 && $mois <= 8) $saison = 'Été';
        elseif ($mois >= 9 && $mois <= 11) $saison = 'Automne';
        else $saison = 'Hiver';
        
        $query = "SELECT * FROM recettes 
                  WHERE (saison = :saison OR saison = 'Toute l annee' OR saison = 'Toute l\'année')
                  AND statut = 'Publie'
                  ORDER BY score_durabilite DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":saison", $saison);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Top recettes les mieux notées
     */
    public function getTopRecettes($limit = 5) {
        $query = "SELECT r.*, COALESCE(AVG(urr.rating), 0) as avg_rating
                  FROM recettes r
                  LEFT JOIN user_recette_ratings urr ON r.id = urr.recette_id
                  WHERE r.statut = 'Publie'
                  GROUP BY r.id
                  ORDER BY avg_rating DESC, r.score_durabilite DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Recettes les plus consultées
     */
    public function getRecettesPopulaires($limit = 5) {
        $query = "SELECT r.*, COUNT(urv.id) as view_count
                  FROM recettes r
                  LEFT JOIN user_recette_views urv ON r.id = urv.recette_id
                  WHERE r.statut = 'Publie'
                  GROUP BY r.id
                  ORDER BY view_count DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Recettes aléatoires (pour compléter)
     */
    public function getRecettesAleatoires($limit = 5) {
        $query = "SELECT * FROM recettes 
                  WHERE statut = 'Publie'
                  ORDER BY RAND()
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Recettes similaires (basé sur les ingrédients)
     */
    public function getRecettesSimilaires($recette_id, $limit = 4) {
        $query = "SELECT DISTINCT r2.*, COUNT(DISTINCT ra2.aliment_id) as common_ingredients
                  FROM recette_aliments ra1
                  JOIN recette_aliments ra2 ON ra1.aliment_id = ra2.aliment_id
                  JOIN recettes r2 ON ra2.recette_id = r2.id
                  WHERE ra1.recette_id = :recette_id
                  AND r2.id != :recette_id
                  AND r2.statut = 'Publie'
                  GROUP BY r2.id
                  ORDER BY common_ingredients DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":recette_id", $recette_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>