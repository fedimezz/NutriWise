<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Comparateur d'aliments - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        
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
        
        h1 { color: #2E7D32; margin-bottom: 20px; font-size: 28px; }
        
        .compare-form { background: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .compare-row { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
        .compare-col { flex: 1; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        button { background: #4CAF50; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: background 0.3s; }
        button:hover { background: #2E7D32; }
        
        .result-card { background: white; border-radius: 12px; padding: 25px; margin-top: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .comparison-table { width: 100%; border-collapse: collapse; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        .comparison-table th { background: #e8f5e9; color: #2E7D32; }
        .winner { background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .compare-row { flex-direction: column; }
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
            <a href="../controller/index.php?controller=aliment&action=index&area=front">← Retour aux aliments</a>
        </div>

        <h1>🔍 Comparateur d'aliments</h1>

        <div class="compare-form">
            <form method="GET">
                <input type="hidden" name="controller" value="analyse">
                <input type="hidden" name="action" value="comparer">
                <div class="compare-row">
                    <div class="compare-col">
                        <label>Aliment 1 :</label>
                        <select name="aliment1" required>
                            <option value="">-- Sélectionnez --</option>
                            <?php foreach($aliments as $a): ?>
                                <option value="<?= $a['id'] ?>" <?= ($_GET['aliment1'] ?? '') == $a['id'] ? 'selected' : '' ?>><?= htmlspecialchars($a['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="compare-col">
                        <label>Aliment 2 :</label>
                        <select name="aliment2" required>
                            <option value="">-- Sélectionnez --</option>
                            <?php foreach($aliments as $a): ?>
                                <option value="<?= $a['id'] ?>" <?= ($_GET['aliment2'] ?? '') == $a['id'] ? 'selected' : '' ?>><?= htmlspecialchars($a['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit">Comparer</button>
            </form>
        </div>

        <?php if($comparaison): ?>
        <div class="result-card">
            <h2 style="color: #2E7D32; margin-bottom: 20px;">📊 Résultat de la comparaison</h2>
            <table class="comparison-table">
                <thead>
                    <tr><th>Critère</th><th><?= $comparaison['aliment1']['nom'] ?></th><th><?= $comparaison['aliment2']['nom'] ?></th></tr>
                </thead>
                <tbody>
                    <tr><td style="font-weight: bold;">Nutri-Score</td><td style="color: <?= $comparaison['aliment1']['nutri_couleur'] ?>; font-weight: bold;"><?= $comparaison['aliment1']['nutri_score'] ?></td><td style="color: <?= $comparaison['aliment2']['nutri_couleur'] ?>; font-weight: bold;"><?= $comparaison['aliment2']['nutri_score'] ?></td></tr>
                    <tr><td style="font-weight: bold;">Calories</td><td><?= $comparaison['aliment1']['calories'] ?> kcal</td><td><?= $comparaison['aliment2']['calories'] ?> kcal</td></tr>
                    <tr><td style="font-weight: bold;">Protéines</td><td><?= $comparaison['aliment1']['proteines'] ?> g</td><td><?= $comparaison['aliment2']['proteines'] ?> g</td></tr>
                    <tr><td style="font-weight: bold;">Lipides</td><td><?= $comparaison['aliment1']['lipids'] ?> g</td><td><?= $comparaison['aliment2']['lipids'] ?> g</td></tr>
                </tbody>
            </table>
            <div class="winner">
                <strong>🏆 Meilleur choix nutritionnel :</strong> <?= $comparaison['meilleur_nutri'] ?>
            </div>
            <div style="margin-top: 15px; padding: 10px; background: #e8f5e9; border-radius: 8px;">
                <strong>💡 Conseil :</strong> <?= $comparaison['conseil'] ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>