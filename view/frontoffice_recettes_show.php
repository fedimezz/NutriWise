<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($recette['title']) ?> - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f8f0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .navbar { background: #1B4D1B; padding: 15px 30px; border-radius: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { color: white; font-size: 24px; font-weight: bold; }
        .navbar .nav-links a { color: white; text-decoration: none; margin-left: 20px; }
        .recipe-detail { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2E7D32; margin-bottom: 10px; }
        .recipe-meta { display: flex; gap: 20px; margin: 20px 0; padding: 15px 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; }
        .section { margin: 25px 0; }
        .section h2 { color: #2E7D32; margin-bottom: 10px; }
        .instructions { white-space: pre-line; line-height: 1.6; }
        .btn-back { background: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        .score-badge { background: #ff9800; color: white; display: inline-block; padding: 5px 15px; border-radius: 20px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">🌿 NutriWise</div>
            <div class="nav-links">
                <a href="index.php?controller=aliment&action=publicIndex">Aliments</a>
                <a href="index.php?controller=recette&action=publicIndex">Recettes</a>
            </div>
        </div>
        
        <div class="recipe-detail">
            <h1><?= htmlspecialchars($recette['title']) ?></h1>
            <div class="score-badge">⭐ Score durabilité : <?= $recette['score_durabilite'] ?>/5</div>
            
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
            
            <a href="index.php?controller=recette&action=publicIndex" class="btn-back">← Retour aux recettes</a>
        </div>
        
        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>