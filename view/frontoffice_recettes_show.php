<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($recette['title']) ?> - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        
        .navbar { background: #1B4D1B; padding: 12px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: nowrap; gap: 10px; width: 100%; }
        .navbar .logo { color: white; font-size: 20px; font-weight: bold; white-space: nowrap; }
        .nav-links { display: flex; gap: 8px; flex-wrap: nowrap; }
        .nav-links a { color: white; text-decoration: none; padding: 6px 12px; border-radius: 8px; transition: background 0.3s; font-weight: normal; font-size: 14px; white-space: nowrap; }
        .nav-links a:hover { background: #4CAF50; }
        .auth-buttons { display: flex; gap: 6px; flex-wrap: nowrap; }
        .btn-login { background: transparent; border: 1px solid white; color: white; padding: 6px 12px; border-radius: 25px; text-decoration: none; font-weight: normal; font-size: 13px; white-space: nowrap; }
        .btn-login:hover { background: white; color: #1B4D1B; }
        .btn-register { background: #4CAF50; color: white; padding: 6px 12px; border-radius: 25px; text-decoration: none; font-weight: normal; font-size: 13px; white-space: nowrap; }
        .btn-register:hover { background: #2E7D32; }
        
        .back-link { margin: 20px 0; }
        .back-link a { color: #4CAF50; text-decoration: none; font-weight: bold; }
        
        .recipe-detail { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2E7D32; margin-bottom: 10px; font-size: 28px; }
        .recipe-meta { display: flex; gap: 20px; margin: 20px 0; padding: 15px 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; flex-wrap: wrap; }
        .section { margin: 25px 0; }
        .section h2 { color: #2E7D32; margin-bottom: 10px; font-size: 20px; }
        .instructions { white-space: pre-line; line-height: 1.6; }
        
        .btn-analyse {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-analyse:hover {
            background: #2E7D32;
            transform: translateY(-2px);
        }
        .btn-back { background: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        .btn-back:hover { background: #555; transform: translateY(-2px); }
        
        .similaires-section { margin-top: 40px; padding: 20px; background: #f9f9f9; border-radius: 15px; }
        .similaires-section h3 { color: #2E7D32; margin-bottom: 20px; font-size: 20px; }
        .similaires-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .similaire-card { background: white; border-radius: 10px; padding: 15px; box-shadow: 0 1px 5px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .similaire-card:hover { transform: translateY(-3px); }
        .similaire-card h4 { color: #2E7D32; margin-bottom: 5px; font-size: 16px; }
        .similaire-meta { display: flex; gap: 10px; font-size: 12px; color: #666; margin: 5px 0; }
        .btn-similaire { background: #4CAF50; color: white; padding: 5px 12px; text-decoration: none; border-radius: 5px; font-size: 12px; display: inline-block; margin-top: 10px; }
        .btn-similaire:hover { background: #2E7D32; }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .similaires-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo">🌿 NutriWise</div>
            <div class="nav-links">
                <a href="../controller/index.php">Accueil</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=front">Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=front" class="active">Recettes</a>
                <a href="../controller/index.php?controller=recommandation&action=index">Recommandations</a>
                <a href="#">Suivi</a>
            </div>
            <div class="auth-buttons">
                <a href="#" class="btn-login">Connexion</a>
                <a href="#" class="btn-register">Inscription</a>
            </div>
        </nav>

        <div class="back-link">
            <a href="../controller/index.php?controller=recette&action=index&area=front">← Retour aux recettes</a>
        </div>

        <div class="recipe-detail">
            <h1><?= htmlspecialchars($recette['title']) ?></h1>
            
            <div class="recipe-meta">
                <span>⏱️ Durée : <?= $recette['duree'] ?> minutes</span>
                <span>📊 Difficulté : <?= $recette['difficulte'] ?></span>
                <span>🌸 Saison : <?= $recette['saison'] ?></span>
            </div>
            
            <div class="section">
                <h2>📝 Description</h2>
                <p><?= nl2br(htmlspecialchars($recette['description'])) ?></p>
            </div>
            
            <div class="section">
                <h2>👨‍🍳 Instructions</h2>
                <div class="instructions"><?= nl2br(htmlspecialchars($recette['instructions'])) ?></div>
            </div>

            <div style="text-align: center;">
                <a href="../controller/index.php?controller=analyse&action=analyserRecette&id=<?= $recette['id'] ?>" class="btn-analyse">
                    🔬 Analyser cette recette (Nutri-Score)
                </a>
            </div>
            
            <a href="../controller/index.php?controller=recette&action=index&area=front" class="btn-back">← Retour aux recettes</a>
        </div>

        <?php
        require_once __DIR__ . '/../model/Database.php';
        require_once __DIR__ . '/../model/MoteurRecommandation.php';
        $db = (new Database())->getConnection();
        $moteur = new MoteurRecommandation($db);
        $similaires = $moteur->getRecettesSimilaires($recette['id'], 4);
        ?>
        
        <?php if(!empty($similaires)): ?>
        <div class="similaires-section">
            <h3>🍽️ Vous aimerez aussi</h3>
            <div class="similaires-grid">
                <?php foreach($similaires as $s): ?>
                <div class="similaire-card">
                    <h4><?= htmlspecialchars($s['title']) ?></h4>
                    <div class="similaire-meta">
                        <span>⏱️ <?= $s['duree'] ?> min</span>
                        <span><?= $s['difficulte'] ?></span>
                    </div>
                    <p style="font-size: 12px; color: #666;"><?= htmlspecialchars(substr($s['description'] ?? '', 0, 60)) ?>...</p>
                    <a href="../controller/index.php?controller=recette&action=show&id=<?= $s['id'] ?>" class="btn-similaire">Voir →</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>