<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recommandations - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 1300px; margin: 0 auto; padding: 20px; }
        
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
        
        h1 { color: #2E7D32; margin-bottom: 10px; font-size: 28px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 16px; }
        
        .section-title { font-size: 22px; color: #2E7D32; margin: 30px 0 20px 0; padding-bottom: 10px; border-bottom: 3px solid #4CAF50; font-weight: bold; }
        
        .recipes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-top: 10px; }
        .recipe-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .recipe-card:hover { transform: translateY(-5px); }
        .recipe-card h3 { color: #2E7D32; margin-bottom: 10px; font-size: 18px; }
        .recipe-meta { display: flex; gap: 15px; font-size: 13px; color: #666; margin: 10px 0; flex-wrap: wrap; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-saison { background: #e8f5e9; color: #2E7D32; }
        .badge-top { background: #ffd700; color: #333; }
        .recipe-card p { color: #555; font-size: 13px; line-height: 1.4; margin: 10px 0; }
        .btn-detail { background: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; font-size: 13px; font-weight: bold; transition: background 0.3s; }
        .btn-detail:hover { background: #2E7D32; }
        
        .footer { text-align: center; margin-top: 50px; padding: 20px; color: #666; border-top: 1px solid #ddd; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .recipes-grid { grid-template-columns: 1fr; }
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
                <a href="../controller/index.php?controller=recette&action=index&area=front">Recettes</a>
                <a href="../controller/index.php?controller=recommandation&action=index" class="active">Recommandations</a>
                <a href="#">Suivi</a>
            </div>
            <div class="auth-buttons">
                <a href="#" class="btn-login">Connexion</a>
                <a href="#" class="btn-register">Inscription</a>
            </div>
        </nav>

        <div class="back-link">
            <a href="../controller/index.php">← Retour à l'accueil</a>
        </div>

        <h1>🎯 Nos recommandations</h1>
        <p class="subtitle">Découvrez les meilleures recettes du moment, selon la saison et les notes des utilisateurs</p>

        <?php if(count($recommandations) > 0): ?>
        
        <div class="section-title">🌸 Recettes de saison</div>
        <div class="recipes-grid">
            <?php 
            $saisonCount = 0;
            foreach($recommandations as $r): 
                $saisonCount++;
                if($saisonCount > 3) break;
            ?>
            <div class="recipe-card">
                <h3><?= htmlspecialchars($r['title']) ?></h3>
                <div class="recipe-meta">
                    <span>⏱️ <?= $r['duree'] ?> min</span>
                    <span><?= $r['difficulte'] ?></span>
                    <span class="badge badge-saison"><?= $r['saison'] ?></span>
                </div>
                <p><?= htmlspecialchars(substr($r['description'] ?? '', 0, 100)) ?>...</p>
                <a href="../controller/index.php?controller=recette&action=show&id=<?= $r['id'] ?>" class="btn-detail">Voir la recette →</a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section-title">⭐ Top recettes notées</div>
        <div class="recipes-grid">
            <?php 
            $topCount = 0;
            foreach($recommandations as $r): 
                $topCount++;
                if($topCount <= 3) continue;
                if($topCount > 6) break;
            ?>
            <div class="recipe-card">
                <h3><?= htmlspecialchars($r['title']) ?></h3>
                <div class="recipe-meta">
                    <span>⏱️ <?= $r['duree'] ?> min</span>
                    <span><?= $r['difficulte'] ?></span>
                    <span class="badge badge-top">⭐ <?= round($r['avg_rating'] ?? 0, 1) ?></span>
                </div>
                <p><?= htmlspecialchars(substr($r['description'] ?? '', 0, 100)) ?>...</p>
                <a href="../controller/index.php?controller=recette&action=show&id=<?= $r['id'] ?>" class="btn-detail">Voir la recette →</a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <p style="text-align: center; padding: 40px;">Aucune recette disponible pour le moment.</p>
        <?php endif; ?>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>