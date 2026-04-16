<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($aliment['nom']) ?> - NutriWise</title>
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
        
        .food-detail { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2E7D32; margin-bottom: 10px; font-size: 28px; }
        .eco-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; margin: 10px 0; }
        .eco-A { background: #4CAF50; color: white; }
        .eco-B { background: #8BC34A; color: white; }
        .eco-C { background: #FFC107; color: white; }
        .eco-D { background: #FF9800; color: white; }
        .eco-E { background: #f44336; color: white; }
        
        .nutrition-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .nutrition-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .nutrition-table td:first-child { font-weight: bold; width: 40%; }
        
        .btn-group { display: flex; gap: 15px; margin: 20px 0; flex-wrap: wrap; justify-content: center; }
        .btn-analyse, .btn-comparateur {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-analyse:hover, .btn-comparateur:hover {
            background: #2E7D32;
            transform: translateY(-2px);
        }
        .btn-back { background: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; transition: all 0.3s; }
        .btn-back:hover { background: #555; transform: translateY(-2px); }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .btn-group { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo">🌿 NutriWise</div>
            <div class="nav-links">
                <a href="../controller/index.php">Accueil</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=front" class="active">Aliments</a>
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

        <div class="food-detail">
            <h1><?= htmlspecialchars($aliment['nom']) ?></h1>
            <div class="eco-badge eco-<?= $aliment['eco_score'] ?>">🌱 Eco-Score <?= $aliment['eco_score'] ?></div>
            <p>Catégorie : <?= $aliment['category_name'] ?? 'Non catégorisé' ?></p>
            <p>Saison : <?= $aliment['saison'] ?></p>

            <table class="nutrition-table">
                <tr>
                    <td>🔥 Calories (kcal/100g)</td>
                    <td><?= $aliment['calories'] ?></td>
                </tr>
                <tr>
                    <td>🥩 Protéines (g/100g)</td>
                    <td><?= $aliment['proteins'] ?></td>
                </tr>
                <tr>
                    <td>🍚 Glucides (g/100g)</td>
                    <td><?= $aliment['glucides'] ?></td>
                </tr>
                <tr>
                    <td>🧈 Lipides (g/100g)</td>
                    <td><?= $aliment['lipids'] ?></td>
                </tr>
            </table>

            <div class="btn-group">
                <a href="../controller/index.php?controller=analyse&action=analyserAliment&id=<?= $aliment['id'] ?>" class="btn-analyse">
                   🔬 Voir l'analyse nutritionnelle (Nutri-Score)
                </a>
                <a href="../controller/index.php?controller=analyse&action=comparer" class="btn-comparateur">
                   🔍 Comparer avec un autre aliment
                </a>
            </div>

            <a href="../controller/index.php?controller=aliment&action=index&area=front" class="btn-back">← Retour aux aliments</a>
        </div>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>