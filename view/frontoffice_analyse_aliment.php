<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Analyse nutritionnelle - <?= htmlspecialchars($aliment['nom']) ?> - NutriWise</title>
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
        .score-container { display: flex; gap: 40px; justify-content: center; margin: 30px 0; flex-wrap: wrap; }
        .score-circle { text-align: center; }
        .score-letter { font-size: 60px; font-weight: bold; width: 120px; height: 120px; border-radius: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
        .score-label { font-size: 14px; color: #666; margin-top: 5px; }
        
        .info-section { margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 12px; }
        .info-section h3 { color: #2E7D32; margin-bottom: 15px; font-size: 18px; }
        .nutrition-table { width: 100%; border-collapse: collapse; }
        .nutrition-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .nutrition-table td:first-child { font-weight: bold; width: 40%; }
        
        .recommandation { background: #e8f5e9; padding: 15px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4CAF50; }
        
        .recommandations-section { margin-top: 30px; }
        .recommandations-section h3 { color: #2E7D32; margin-bottom: 20px; font-size: 20px; }
        .recommandations-list { display: flex; flex-direction: column; gap: 15px; }
        .recommandation-card { background: #f9f9f9; border-radius: 12px; padding: 15px; display: flex; gap: 15px; border-left: 4px solid #4CAF50; }
        .rec-icone { font-size: 32px; min-width: 50px; text-align: center; }
        .rec-content h4 { color: #333; margin-bottom: 8px; font-size: 16px; }
        .rec-content p { color: #666; margin-bottom: 10px; font-size: 14px; line-height: 1.4; }
        .rec-conseil { background: #e8f5e9; padding: 8px 12px; border-radius: 8px; font-size: 13px; color: #2E7D32; }
        
        .btn-retour { background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin-top: 20px; font-weight: bold; transition: background 0.3s; }
        .btn-retour:hover { background: #2E7D32; }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .score-container { flex-direction: column; align-items: center; }
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
                <a href="../controller/index.php?controller=recommandation&action=index">Recommandations</a>
                <a href="#">Suivi</a>
            </div>
            <div class="auth-buttons">
                <a href="#" class="btn-login">Connexion</a>
                <a href="#" class="btn-register">Inscription</a>
            </div>
        </nav>

        <div class="back-link">
            <a href="../controller/index.php?controller=aliment&action=show&id=<?= $aliment['id'] ?>">← Retour à l'aliment</a>
        </div>

        <div class="analyse-card">
            <h1>🔬 Analyse nutritionnelle</h1>
            <h2 style="color: #333; margin-bottom: 20px;"><?= htmlspecialchars($aliment['nom']) ?></h2>
            
            <div class="score-container">
                <div class="score-circle">
                    <div class="score-letter" style="background: <?= $nutriScore['couleur'] ?>; color: white;">
                        <?= $nutriScore['score'] ?>
                    </div>
                    <div class="score-label">Nutri-Score</div>
                    <div style="font-size: 12px; color: #666;"><?= $nutriScore['description'] ?></div>
                </div>
                <div class="score-circle">
                    <div class="score-letter" style="background: <?= $novaScore['couleur'] ?>; color: white;">
                        <?= $novaScore['score'] ?>
                    </div>
                    <div class="score-label">Score NOVA</div>
                    <div style="font-size: 12px; color: #666;"><?= $novaScore['niveau'] ?></div>
                </div>
            </div>

            <div class="recommandation">
                <strong>💡 Recommandation générale</strong><br>
                <?php 
                switch($nutriScore['score']) {
                    case 'A': echo "🎉 Félicitations ! Cet aliment est excellent pour votre santé. N'hésitez pas à en consommer régulièrement."; break;
                    case 'B': echo "👍 Bon choix ! Cet aliment peut faire partie d'une alimentation équilibrée."; break;
                    case 'C': echo "⚠️ À consommer avec modération. Variez votre alimentation."; break;
                    case 'D': echo "🔴 Limitez votre consommation. Privilégiez des alternatives meilleures."; break;
                    case 'E': echo "🚫 À éviter si possible. Cherchez des alternatives plus saines."; break;
                    default: echo "Consultez les détails nutritionnels pour plus d'informations.";
                }
                ?>
            </div>

            <div class="info-section">
                <h3>📊 Détails nutritionnels (pour 100g)</h3>
                <table class="nutrition-table">
                    <tr><td>🔥 Calories</td><td><?= $aliment['calories'] ?> kcal</td></tr>
                    <tr><td>🥩 Protéines</td><td><?= $aliment['proteins'] ?> g</td></tr>
                    <tr><td>🍚 Glucides</td><td><?= $aliment['glucides'] ?> g</td></tr>
                    <tr><td>🧈 Lipides</td><td><?= $aliment['lipids'] ?> g</td></tr>
                    <tr><td>🌾 Fibres</td><td><?= $aliment['fibres'] ?? 0 ?> g</td></tr>
                </table>
            </div>

            <div class="info-section">
                <h3>🏭 Score NOVA - Niveau de transformation</h3>
                <p><strong><?= $novaScore['niveau'] ?></strong></p>
                <p><?= $novaScore['description'] ?></p>
            </div>

            <?php 
            $recommandationsDetaillees = $analyseur->getRecommandationsDetaillees($aliment['id']);
            if(!empty($recommandationsDetaillees)):
            ?>
            <div class="recommandations-section">
                <h3>💡 Recommandations personnalisées</h3>
                <div class="recommandations-list">
                    <?php foreach($recommandationsDetaillees as $rec): ?>
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

            <a href="../controller/index.php?controller=aliment&action=show&id=<?= $aliment['id'] ?>" class="btn-retour">← Retour à l'aliment</a>
        </div>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>