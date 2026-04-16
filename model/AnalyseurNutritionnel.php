<?php
class AnalyseurNutritionnel {
    private $conn;
    
    // Seuils pour le Nutri-Score
    private $seuils = [
        'energie' => [80, 160, 240, 320, 400, 480, 560, 640, 720, 800],
        'sucres' => [4.5, 9, 13.5, 18, 22.5, 27, 31, 36, 40, 45],
        'acides_gras' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        'sel' => [90, 180, 270, 360, 450, 540, 630, 720, 810, 900],
        'fibres' => [0.7, 1.4, 2.1, 2.8, 3.5, 4.2, 4.9, 5.6, 6.3, 7],
        'proteines' => [1.6, 3.2, 4.8, 6.4, 8, 9.6, 11.2, 12.8, 14.4, 16],
        'fruits_legumes' => [40, 60, 80]
    ];
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Calculer le Nutri-Score pour un aliment
     */
    public function calculerNutriScoreAliment($aliment_id) {
        $aliment = $this->getAlimentById($aliment_id);
        if (!$aliment) return null;
        
        $pointsN = 0;
        $pointsN += $this->calculerPointsEnergie($aliment['calories']);
        $pointsN += $this->calculerPointsSucres($aliment['glucides']);
        $pointsN += $this->calculerPointsGraisses($aliment['lipids']);
        $pointsN += $this->calculerPointsSel($aliment['sel'] ?? 0);
        
        $pointsP = 0;
        $pointsP += $this->calculerPointsFibres($aliment['fibres'] ?? 0);
        $pointsP += $this->calculerPointsProteines($aliment['proteins']);
        $pointsP += $this->calculerPointsFruitsLegumes($aliment['category_id']);
        
        $scoreFinal = $pointsN - $pointsP;
        $nutriScore = $this->convertirScoreEnLettre($scoreFinal);
        
        $this->sauvegarderNutriScore($aliment_id, $nutriScore);
        
        return [
            'score' => $nutriScore,
            'points_negatifs' => $pointsN,
            'points_positifs' => $pointsP,
            'score_final' => $scoreFinal,
            'couleur' => $this->getCouleurNutriScore($nutriScore),
            'description' => $this->getDescriptionNutriScore($nutriScore)
        ];
    }
    
    /**
     * Calculer le score NOVA
     */
    public function calculerNovaScore($aliment_id) {
        $aliment = $this->getAlimentById($aliment_id);
        if (!$aliment) return null;
        
        $novaScore = 1;
        if ($this->estUltraTransforme($aliment)) {
            $novaScore = 4;
        } elseif ($this->estTransforme($aliment)) {
            $novaScore = 3;
        } elseif ($this->estIngredientCulinaire($aliment)) {
            $novaScore = 2;
        } else {
            $novaScore = 1;
        }
        
        $this->sauvegarderNovaScore($aliment_id, $novaScore);
        
        return [
            'score' => $novaScore,
            'niveau' => $this->getNiveauNova($novaScore),
            'description' => $this->getDescriptionNova($novaScore),
            'couleur' => $this->getCouleurNova($novaScore)
        ];
    }
    
    /**
     * Analyser une recette complète
     */
    public function analyserRecette($recette_id) {
        $recette = $this->getRecetteById($recette_id);
        if (!$recette) return null;
        
        $aliments = $this->getAlimentsByRecette($recette_id);
        
        $totaux = [
            'calories' => 0,
            'proteins' => 0,
            'glucides' => 0,
            'lipids' => 0,
            'fibres' => 0
        ];
        
        foreach ($aliments as $aliment) {
            $totaux['calories'] += $aliment['calories'];
            $totaux['proteins'] += $aliment['proteins'];
            $totaux['glucides'] += $aliment['glucides'];
            $totaux['lipids'] += $aliment['lipids'];
            $totaux['fibres'] += $aliment['fibres'] ?? 0;
        }
        
        $nbAliments = count($aliments);
        if ($nbAliments > 0) {
            foreach ($totaux as $key => $value) {
                $totaux[$key] = round($value / $nbAliments, 1);
            }
        }
        
        $nutriScores = array_filter(array_column($aliments, 'nutri_score'));
        $nutriScoreMoyen = $this->calculerNutriScoreMoyen($nutriScores);
        $allergenes = $this->detecterAllergenes($aliments);
        
        return [
            'recette' => $recette,
            'totaux' => $totaux,
            'nb_ingredients' => $nbAliments,
            'nutri_score' => $nutriScoreMoyen,
            'allergenes' => $allergenes,
            'aliments' => $aliments
        ];
    }
    
    /**
     * Générer des recommandations détaillées pour un aliment
     */
    public function getRecommandationsDetaillees($aliment_id) {
        $aliment = $this->getAlimentById($aliment_id);
        $nutriScore = $this->calculerNutriScoreAliment($aliment_id);
        $novaScore = $this->calculerNovaScore($aliment_id);
        
        $recommandations = [];
        
        // Recommandations NUTRI-SCORE
        switch($nutriScore['score']) {
            case 'A':
                $recommandations[] = [
                    'titre' => '🏆 Excellent choix nutritionnel',
                    'description' => 'Cet aliment est excellent pour votre santé. Il est faible en calories, graisses saturées, sucres et sel, tout en étant riche en nutriments essentiels.',
                    'conseil' => 'N\'hésitez pas à l\'intégrer régulièrement dans votre alimentation. Variez simplement les sources pour un apport équilibré.',
                    'icone' => '🥇'
                ];
                break;
            case 'B':
                $recommandations[] = [
                    'titre' => '👍 Très bon choix',
                    'description' => 'Cet aliment a de bonnes qualités nutritionnelles. Il peut faire partie d\'une alimentation saine et équilibrée.',
                    'conseil' => 'Consommez-le sans modération excessive, tout en veillant à diversifier vos sources alimentaires.',
                    'icone' => '✅'
                ];
                break;
            case 'C':
                $recommandations[] = [
                    'titre' => '⚠️ À consommer avec modération',
                    'description' => 'Cet aliment présente des qualités nutritionnelles moyennes. Il contient une quantité modérée de calories, sucres ou graisses.',
                    'conseil' => 'Privilégiez une consommation occasionnelle. Associez-le à des aliments de meilleure qualité nutritionnelle.',
                    'icone' => '⚖️'
                ];
                break;
            case 'D':
                $recommandations[] = [
                    'titre' => '🔴 À limiter dans votre alimentation',
                    'description' => 'Cet aliment est riche en calories, sucres, graisses ou sel. Une consommation excessive peut avoir un impact négatif sur votre santé.',
                    'conseil' => 'Réduisez votre consommation. Cherchez des alternatives avec un meilleur Nutri-Score (A ou B).',
                    'icone' => '⚠️'
                ];
                break;
            case 'E':
                $recommandations[] = [
                    'titre' => '🚫 À éviter si possible',
                    'description' => 'Cet aliment a une qualité nutritionnelle médiocre. Il est généralement trop riche en calories, sucres, graisses ou sel.',
                    'conseil' => 'Évitez sa consommation régulière. Privilégiez des aliments naturels ou moins transformés.',
                    'icone' => '❌'
                ];
                break;
        }
        
        // Recommandations NOVA
        switch($novaScore['score']) {
            case 1:
                $recommandations[] = [
                    'titre' => '🌱 Aliment non transformé',
                    'description' => 'Cet aliment est naturel ou minimalement transformé. Il conserve tous ses nutriments et bienfaits.',
                    'conseil' => 'C\'est le meilleur choix pour votre santé. Privilégiez ce type d\'aliments au quotidien.',
                    'icone' => '🥬'
                ];
                break;
            case 2:
                $recommandations[] = [
                    'titre' => '🧂 Ingrédient culinaire transformé',
                    'description' => 'Cet aliment est utilisé comme ingrédient en cuisine. Il subit une transformation légère.',
                    'conseil' => 'À utiliser avec modération dans vos préparations culinaires.',
                    'icone' => '🧑‍🍳'
                ];
                break;
            case 3:
                $recommandations[] = [
                    'titre' => '🏭 Aliment transformé',
                    'description' => 'Cet aliment a subi une transformation industrielle. Il peut contenir des additifs ou conservateurs.',
                    'conseil' => 'Limitez sa consommation. Préférez les versions maison ou moins transformées.',
                    'icone' => '🏭'
                ];
                break;
            case 4:
                $recommandations[] = [
                    'titre' => '🚨 Aliment ultra-transformé',
                    'description' => 'Cet aliment contient de nombreux additifs, conservateurs, colorants ou arômes artificiels.',
                    'conseil' => 'Évitez au maximum. Ces aliments sont associés à des risques pour la santé.',
                    'icone' => '⚠️'
                ];
                break;
        }
        
        // Recommandations spécifiques
        if ($aliment['calories'] > 500) {
            $recommandations[] = [
                'titre' => '📈 Riche en calories',
                'description' => "Cet aliment apporte {$aliment['calories']} kcal pour 100g, ce qui est élevé.",
                'conseil' => 'Consommez-le avec parcimonie, surtout si vous surveillez votre poids. Idéal pour les sportifs ou repas principaux.',
                'icone' => '🔥'
            ];
        } elseif ($aliment['calories'] < 50) {
            $recommandations[] = [
                'titre' => '📉 Faible en calories',
                'description' => "Cet aliment apporte seulement {$aliment['calories']} kcal pour 100g.",
                'conseil' => 'Parfait pour les collations ou pour augmenter le volume de vos repas sans ajouter trop de calories.',
                'icone' => '🥗'
            ];
        }
        
        if ($aliment['proteins'] > 15) {
            $recommandations[] = [
                'titre' => '💪 Riche en protéines',
                'description' => "Cet aliment contient {$aliment['proteins']}g de protéines pour 100g.",
                'conseil' => 'Idéal pour la construction musculaire, la satiété et la récupération. Parfait après le sport.',
                'icone' => '🏋️'
            ];
        }
        
        if ($aliment['lipids'] > 20) {
            $recommandations[] = [
                'titre' => '🫒 Riche en matières grasses',
                'description' => "Cet aliment contient {$aliment['lipids']}g de lipides pour 100g.",
                'conseil' => 'Privilégiez les bonnes graisses (oméga-3, insaturées). Limitez les graisses saturées et trans.',
                'icone' => '🥑'
            ];
        }
        
        if (($aliment['fibres'] ?? 0) > 5) {
            $recommandations[] = [
                'titre' => '🌾 Excellente source de fibres',
                'description' => "Cet aliment contient {$aliment['fibres']}g de fibres pour 100g.",
                'conseil' => 'Les fibres améliorent le transit, augmentent la satiété et réduisent le cholestérol. Excellent choix !',
                'icone' => '🥦'
            ];
        }
        
        if ($aliment['durable'] == 1) {
            $recommandations[] = [
                'titre' => '🌍 Aliment durable',
                'description' => 'Cet aliment a un faible impact environnemental.',
                'conseil' => 'Privilégiez les aliments durables pour préserver la planète tout en prenant soin de votre santé.',
                'icone' => '♻️'
            ];
        }
        
        return $recommandations;
    }
    
    /**
     * Générer des recommandations détaillées pour une recette
     */
    public function getRecommandationsRecetteDetaillees($recette_id) {
        $analyse = $this->analyserRecette($recette_id);
        $recommandations = [];
        
        if ($analyse['nutri_score']['score'] == 'A' || $analyse['nutri_score']['score'] == 'B') {
            $recommandations[] = [
                'titre' => '🍽️ Excellente recette !',
                'description' => 'Cette recette est équilibrée et bénéfique pour votre santé.',
                'conseil' => 'N\'hésitez pas à la cuisiner régulièrement. Variez les accompagnements pour ne pas vous lasser.',
                'icone' => '⭐'
            ];
        } else {
            $recommandations[] = [
                'titre' => '🔧 Suggestions d\'amélioration',
                'description' => 'Cette recette peut être améliorée nutritionnellement.',
                'conseil' => 'Ajoutez plus de légumes, réduisez les matières grasses ou remplacez certains ingrédients par des alternatives plus saines.',
                'icone' => '🛠️'
            ];
        }
        
        $nbLegumes = 0;
        foreach ($analyse['aliments'] as $aliment) {
            if (in_array($aliment['category_id'], [1, 2])) {
                $nbLegumes++;
            }
        }
        
        if ($nbLegumes < 2) {
            $recommandations[] = [
                'titre' => '🥗 Ajoutez des légumes',
                'description' => 'Cette recette contient peu de légumes ou de fruits.',
                'conseil' => 'Ajoutez au moins 2 portions de légumes pour un repas équilibré. Variez les couleurs pour plus de nutriments.',
                'icone' => '🥕'
            ];
        }
        
        if ($analyse['totaux']['proteins'] < 10) {
            $recommandations[] = [
                'titre' => '💪 Renforcez l\'apport en protéines',
                'description' => 'Cette recette est faible en protéines.',
                'conseil' => 'Ajoutez des légumineuses (lentilles, pois chiches), des œufs, du tofu ou une viande maigre.',
                'icone' => '🥩'
            ];
        }
        
        if ($analyse['totaux']['fibres'] < 5) {
            $recommandations[] = [
                'titre' => '🌾 Augmentez les fibres',
                'description' => 'Cette recette manque de fibres alimentaires.',
                'conseil' => 'Ajoutez des céréales complètes (riz complet, quinoa), des légumes ou des graines (lin, chia).',
                'icone' => '🌾'
            ];
        }
        
        if ($analyse['totaux']['lipids'] > 20) {
            $recommandations[] = [
                'titre' => '🫒 Réduisez les matières grasses',
                'description' => 'Cette recette est riche en lipides.',
                'conseil' => 'Utilisez moins d\'huile, privilégiez la cuisson à la vapeur ou au four, et choisissez des viandes maigres.',
                'icone' => '💧'
            ];
        }
        
        return $recommandations;
    }
    
    // ============ MÉTHODES PRIVÉES ============
    
    private function calculerPointsEnergie($calories) {
        $energieKj = $calories * 4.184;
        foreach ($this->seuils['energie'] as $i => $seuil) {
            if ($energieKj <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsSucres($sucres) {
        foreach ($this->seuils['sucres'] as $i => $seuil) {
            if ($sucres <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsGraisses($graisses) {
        foreach ($this->seuils['acides_gras'] as $i => $seuil) {
            if ($graisses <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsSel($sel) {
        $selMg = $sel * 1000;
        foreach ($this->seuils['sel'] as $i => $seuil) {
            if ($selMg <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsFibres($fibres) {
        foreach ($this->seuils['fibres'] as $i => $seuil) {
            if ($fibres <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsProteines($proteines) {
        foreach ($this->seuils['proteines'] as $i => $seuil) {
            if ($proteines <= $seuil) return $i;
        }
        return 10;
    }
    
    private function calculerPointsFruitsLegumes($category_id) {
        $categoriesFruitsLegumes = [1, 2];
        if (in_array($category_id, $categoriesFruitsLegumes)) {
            return 5;
        }
        return 0;
    }
    
    private function convertirScoreEnLettre($score) {
        if ($score <= -1) return 'A';
        if ($score <= 2) return 'B';
        if ($score <= 10) return 'C';
        if ($score <= 18) return 'D';
        return 'E';
    }
    
    private function getCouleurNutriScore($score) {
        $couleurs = ['A' => '#2E7D32', 'B' => '#8BC34A', 'C' => '#FFC107', 'D' => '#FF9800', 'E' => '#f44336'];
        return $couleurs[$score] ?? '#999';
    }
    
    private function getDescriptionNutriScore($score) {
        $descriptions = [
            'A' => 'Excellent choix nutritionnel',
            'B' => 'Très bon choix',
            'C' => 'Bon choix, à consommer avec modération',
            'D' => 'À limiter dans votre alimentation',
            'E' => 'À éviter si possible'
        ];
        return $descriptions[$score] ?? '';
    }
    
    private function getNiveauNova($score) {
        $niveaux = [1 => 'Non transformé', 2 => 'Ingrédient culinaire', 3 => 'Aliment transformé', 4 => 'Ultra-transformé'];
        return $niveaux[$score] ?? '';
    }
    
    private function getDescriptionNova($score) {
        $descriptions = [
            1 => 'Aliments naturels, excellents pour la santé',
            2 => 'Utilisés en cuisine, à consommer avec modération',
            3 => 'Produits transformés, à limiter',
            4 => 'Éviter autant que possible'
        ];
        return $descriptions[$score] ?? '';
    }
    
    private function getCouleurNova($score) {
        $couleurs = [1 => '#2E7D32', 2 => '#8BC34A', 3 => '#FFC107', 4 => '#f44336'];
        return $couleurs[$score] ?? '#999';
    }
    
    private function estUltraTransforme($aliment) {
        $motsCles = ['soda', 'snack', 'céréale', 'plat préparé', 'nugget'];
        foreach ($motsCles as $mot) {
            if (stripos($aliment['nom'], $mot) !== false) return true;
        }
        return false;
    }
    
    private function estTransforme($aliment) {
        $motsCles = ['pain', 'fromage', 'conserve', 'jus', 'yaourt'];
        foreach ($motsCles as $mot) {
            if (stripos($aliment['nom'], $mot) !== false) return true;
        }
        return false;
    }
    
    private function estIngredientCulinaire($aliment) {
        $motsCles = ['huile', 'sucre', 'sel', 'farine', 'beurre'];
        foreach ($motsCles as $mot) {
            if (stripos($aliment['nom'], $mot) !== false) return true;
        }
        return false;
    }
    
    private function detecterAllergenes($aliments) {
        $allergenesListe = [
            'gluten' => ['blé', 'froment', 'orge', 'seigle', 'avoine'],
            'lait' => ['lait', 'crème', 'beurre', 'fromage', 'yaourt'],
            'oeufs' => ['œuf', 'oeuf'],
            'arachides' => ['arachide', 'cacahuète'],
            'soja' => ['soja', 'tofu'],
            'poisson' => ['saumon', 'thon', 'cabillaud', 'sardine', 'poisson'],
            'crustaces' => ['crevette', 'crabe', 'homard', 'moule'],
            'fruits_coque' => ['amande', 'noix', 'noisette', 'pistache', 'cajou']
        ];
        
        $allergenesTrouves = [];
        foreach ($aliments as $aliment) {
            foreach ($allergenesListe as $allergene => $mots) {
                foreach ($mots as $mot) {
                    if (stripos($aliment['nom'], $mot) !== false) {
                        $allergenesTrouves[$allergene] = true;
                    }
                }
            }
        }
        return array_keys($allergenesTrouves);
    }
    
    private function calculerNutriScoreMoyen($scores) {
        if (empty($scores)) return ['score' => 'C', 'couleur' => '#FFC107'];
        $ordre = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5];
        $total = 0;
        foreach ($scores as $score) {
            if ($score && isset($ordre[$score])) $total += $ordre[$score];
        }
        $moyenne = $total / count($scores);
        if ($moyenne <= 1.5) return ['score' => 'A', 'couleur' => '#2E7D32'];
        if ($moyenne <= 2.5) return ['score' => 'B', 'couleur' => '#8BC34A'];
        if ($moyenne <= 3.5) return ['score' => 'C', 'couleur' => '#FFC107'];
        if ($moyenne <= 4.5) return ['score' => 'D', 'couleur' => '#FF9800'];
        return ['score' => 'E', 'couleur' => '#f44336'];
    }
    
    private function sauvegarderNutriScore($aliment_id, $nutriScore) {
        $query = "UPDATE aliments SET nutri_score = :nutri_score WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nutri_score", $nutriScore);
        $stmt->bindParam(":id", $aliment_id);
        $stmt->execute();
    }
    
    private function sauvegarderNovaScore($aliment_id, $novaScore) {
        $query = "UPDATE aliments SET nova_score = :nova_score WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nova_score", $novaScore);
        $stmt->bindParam(":id", $aliment_id);
        $stmt->execute();
    }
    
    private function getAlimentById($id) {
        $query = "SELECT a.*, c.name as category_name FROM aliments a LEFT JOIN categories c ON a.category_id = c.id WHERE a.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function getRecetteById($id) {
        $query = "SELECT * FROM recettes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function getAlimentsByRecette($recette_id) {
        $query = "SELECT a.* FROM aliments a JOIN recette_aliments ra ON a.id = ra.aliment_id WHERE ra.recette_id = :recette_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":recette_id", $recette_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        /**
     * Comparer deux aliments
     */
    public function comparerAliments($aliment1_id, $aliment2_id) {
        $aliment1 = $this->getAlimentById($aliment1_id);
        $aliment2 = $this->getAlimentById($aliment2_id);
        
        if (!$aliment1 || !$aliment2) return null;
        
        $nutri1 = $this->calculerNutriScoreAliment($aliment1_id);
        $nutri2 = $this->calculerNutriScoreAliment($aliment2_id);
        $nova1 = $this->calculerNovaScore($aliment1_id);
        $nova2 = $this->calculerNovaScore($aliment2_id);
        
        // Déterminer le meilleur Nutri-Score
        $ordre = ['A', 'B', 'C', 'D', 'E'];
        $meilleurNutri = (array_search($nutri1['score'], $ordre) < array_search($nutri2['score'], $ordre)) 
            ? $aliment1['nom'] : $aliment2['nom'];
        
        // Générer un conseil
        if ($meilleurNutri == $aliment1['nom']) {
            $conseil = "L'aliment '{$aliment1['nom']}' a un meilleur Nutri-Score ({$nutri1['score']}) que '{$aliment2['nom']}' ({$nutri2['score']}). Privilégiez-le pour une alimentation plus saine.";
        } else {
            $conseil = "L'aliment '{$aliment2['nom']}' a un meilleur Nutri-Score ({$nutri2['score']}) que '{$aliment1['nom']}' ({$nutri1['score']}). Privilégiez-le pour une alimentation plus saine.";
        }
        
        return [
            'aliment1' => [
                'nom' => $aliment1['nom'],
                'nutri_score' => $nutri1['score'],
                'nutri_couleur' => $nutri1['couleur'],
                'nova_score' => $nova1['score'],
                'nova_couleur' => $nova1['couleur'],
                'calories' => $aliment1['calories'],
                'proteines' => $aliment1['proteins'],
                'lipids' => $aliment1['lipids']
            ],
            'aliment2' => [
                'nom' => $aliment2['nom'],
                'nutri_score' => $nutri2['score'],
                'nutri_couleur' => $nutri2['couleur'],
                'nova_score' => $nova2['score'],
                'nova_couleur' => $nova2['couleur'],
                'calories' => $aliment2['calories'],
                'proteines' => $aliment2['proteins'],
                'lipids' => $aliment2['lipids']
            ],
            'meilleur_nutri' => $meilleurNutri,
            'conseil' => $conseil
        ];
    }
}
?>