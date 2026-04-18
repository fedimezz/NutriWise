<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Analyse nutritionnelle - <?= htmlspecialchars($recette['title']) ?> - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        
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
        
        .analyse-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        h1 { color: #2E7D32; margin-bottom: 10px; font-size: 28px; }
        .nutri-badge { display: inline-block; padding: 15px 30px; border-radius: 50px; font-size: 28px; font-weight: bold; margin: 20px 0; text-align: center; }
        
        .info-section { margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 12px; }
        .info-section h3 { color: #2E7D32; margin-bottom: 15px; font-size: 18px; }
        .nutrition-table { width: 100%; border-collapse: collapse; }
        .nutrition-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .nutrition-table td:first-child { font-weight: bold; width: 40%; }
        
        .recommandations-section { margin-top: 30px; }
        .recommandations-section h3 { color: #2E7D32; margin-bottom: 20px; font-size: 20px; }
        .recommandations-list { display: flex; flex-direction: column; gap: 15px; }
        .recommandation-card { background: #f9f9f9; border-radius: 12px; padding: 15px; display: flex; gap: 15px; border-left: 4px solid #4CAF50; }
        .rec-icone { font-size: 32px; min-width: 50px; text-align: center; }
        .rec-content h4 { color: #333; margin-bottom: 8px; font-size: 16px; }
        .rec-content p { color: #666; margin-bottom: 10px; font-size: 14px; line-height: 1.4; }
        .rec-conseil { background: #e8f5e9; padding: 8px 12px; border-radius: 8px; font-size: 13px; color: #2E7D32; }
        
        .allergene { background: #f8d7da; padding: 15px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f44336; }
        .warning { background: #fff3cd; padding: 15px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ffc107; }
        
        .btn-retour { background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin-top: 20px; font-weight: bold; transition: background 0.3s; }
        .btn-retour:hover { background: #2E7D32; }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
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
                <a href="#">Suivi</a>
            </div>
            <div class="auth-buttons">
                <a href="#" class="btn-login">Connexion</a>
                <a href="#" class="btn-register">Inscription</a>
            </div>
        </nav>

        <div class="back-link">
            <a href="../controller/index.php?controller=recette&action=show&id=<?= $recette['id'] ?>">← Retour à la recette</a>
        </div>

        <div class="analyse-card">
            <h1>🔬 Analyse nutritionnelle</h1>
            <h2 style="color: #333; margin-bottom: 20px;"><?= htmlspecialchars($recette['title']) ?></h2>
            
            <div style="text-align: center;">
                <div class="nutri-badge" style="background: <?= $analyse['nutri_score']['couleur'] ?>; color: white;">
                    Nutri-Score <?= $analyse['nutri_score']['score'] ?>
                </div>
            </div>

            <div class="info-section">
                <h3>📊 Valeurs nutritionnelles moyennes (par portion)</h3>
                <table class="nutrition-table">
                    <tr><td🔥 Calories</td><td><?= $analyse['totaux']['calories'] ?> kcal</td></tr>
                    <tr><td🥩 Protéines</td><td><?= $analyse['totaux']['proteins'] ?> g</td></tr>
                    <tr><td🍚 Glucides</td><td><?= $analyse['totaux']['glucides'] ?> g</td></tr>
                    <tr><td🧈 Lipides</td><td><?= $analyse['totaux']['lipids'] ?> g</td></tr>
                    <tr><td🌾 Fibres</td><td><?= $analyse['totaux']['fibres'] ?> g</td></tr>
                    <tr><td📦 Nombre d'ingrédients</td><td><?= $analyse['nb_ingredients'] ?></td></tr>
                </table>
            </div>

            <div class="info-section">
                <h3>🥗 Liste des ingrédients</h3>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($analyse['aliments'] as $aliment): ?>
                        <li style="padding: 5px 0;">• <?= htmlspecialchars($aliment['nom']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if(!empty($recommandations)): ?>
            <div class="recommandations-section">
                <h3>💡 Recommandations personnalisées</h3>
                <div class="recommandations-list">
                    <?php foreach($recommandations as $rec): ?>
                    <div class="recommandation-card">
                        <div class="rec-icone"><?= $rec['icone'] ?></div>
                        <div class="rec-content">
                            <h4><?= $rec['titre'] ?></h4>
                            <p><?= $rec['description'] ?></p>
                            <div class="rec-conseil">
                                <strong>💡 Conseil :</strong> <?= $rec['conseil'] ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($analyse['allergenes'])): ?>
            <div class="allergene">
                <strong>⚠️ Allergènes détectés</strong><br>
                Cette recette contient : <?= implode(', ', $analyse['allergenes']) ?>
            </div>
            <?php endif; ?>

            <?php if($analyse['nutri_score']['score'] == 'D' || $analyse['nutri_score']['score'] == 'E'): ?>
            <div class="warning">
                <strong>🔴 Attention</strong><br>
                Cette recette a un Nutri-Score <?= $analyse['nutri_score']['score'] ?>. 
                Nous vous conseillons de la consommer avec modération.
            </div>
            <?php endif; ?>

            <a href="../controller/index.php?controller=recette&action=show&id=<?= $recette['id'] ?>" class="btn-retour">← Retour à la recette</a>
        </div>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>