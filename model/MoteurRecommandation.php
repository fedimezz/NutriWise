<?php
class MoteurRecommandation {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getRecommandationsPersonnalisees($user_id, $limit = 6) {
        $recettes = [];
        
        $historique = $this->getRecommandationsParHistorique($user_id, $limit);
        $recettes = array_merge($recettes, $historique);
        
        $categories = $this->getRecommandationsParCategories($user_id, $limit);
        $recettes = array_merge($recettes, $categories);
        
        $saison = $this->getRecommandationsParSaison($limit);
        $recettes = array_merge($recettes, $saison);
        
        $top = $this->getTopRecettes($limit);
        $recettes = array_merge($recettes, $top);
        
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
    
    public function getRecommandationsParHistorique($user_id, $limit = 5) {
        $query = "SELECT DISTINCT r2.*, COUNT(*) as score
                  FROM user_recette_views urv1
                  JOIN recette_aliments ra1 ON urv1.recette_id = ra1.recette_id
                  JOIN recette_aliments ra2 ON ra1.aliment_id = ra2.aliment_id
                  JOIN recettes r2 ON ra2.recette_id = r2.id
                  WHERE urv1.user_id = :user_id
                  AND r2.id NOT IN (SELECT recette_id FROM user_recette_views WHERE user_id = :user_id)
                  AND r2.statut = 'Publie'
                  GROUP BY r2.id
                  ORDER BY score DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecommandationsParCategories($user_id, $limit = 5) {
        $query = "SELECT DISTINCT r.*, COUNT(DISTINCT c.id) as match_score
                  FROM recettes r
                  JOIN recette_aliments ra ON r.id = ra.recette_id
                  JOIN aliments a ON ra.aliment_id = a.id
                  JOIN categories c ON a.category_id = c.id
                  LEFT JOIN user_preferences up ON up.user_id = :user_id
                  WHERE (up.preferred_categories IS NULL OR FIND_IN_SET(c.name, up.preferred_categories))
                  AND r.statut = 'Publie'
                  AND r.id NOT IN (SELECT recette_id FROM user_recette_views WHERE user_id = :user_id)
                  GROUP BY r.id
                  ORDER BY match_score DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecommandationsParSaison($limit = 5) {
        $mois = date('n');
        if ($mois >= 3 && $mois <= 5) $saison = 'Printemps';
        elseif ($mois >= 6 && $mois <= 8) $saison = 'Été';
        elseif ($mois >= 9 && $mois <= 11) $saison = 'Automne';
        else $saison = 'Hiver';
        
        $query = "SELECT * FROM recettes 
                  WHERE (saison = :saison OR saison = 'Toute l annee')
                  AND statut = 'Publie'
                  ORDER BY score_durabilite DESC
                  LIMIT :limit";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":saison", $saison);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTopRecettes($limit = 5) {
        $query = "SELECT r.*, AVG(urr.rating) as avg_rating
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