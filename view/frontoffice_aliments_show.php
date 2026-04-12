<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($aliment['nom']) ?> - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .navbar { background: #1B4D1B; padding: 15px 30px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .navbar .logo { color: white; font-size: 24px; font-weight: bold; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 20px; flex-wrap: wrap; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 16px; border-radius: 8px; }
        .nav-links a:hover { background: #4CAF50; }
        .auth-buttons { display: flex; gap: 10px; }
        .btn-login { background: transparent; border: 1px solid white; color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; }
        .btn-register { background: #4CAF50; color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; }
        .food-detail { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2E7D32; margin-bottom: 10px; }
        .eco-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; margin: 10px 0; }
        .eco-A { background: #4CAF50; color: white; }
        .eco-B { background: #8BC34A; color: white; }
        .eco-C { background: #FFC107; color: white; }
        .eco-D { background: #FF9800; color: white; }
        .eco-E { background: #f44336; color: white; }
        .nutrition-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .nutrition-table td { padding: 10px; border-bottom: 1px solid #ddd; }
        .nutrition-table td:first-child { font-weight: bold; }
        .btn-back { background: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        .back-link { margin: 20px 0; }
        .back-link a { color: #4CAF50; text-decoration: none; }
        @media (max-width: 768px) { .navbar { flex-direction: column; text-align: center; } }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <div class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="index.php?controller=aliment&action=index&area=front">Aliments</a>
                <a href="index.php?controller=recette&action=index&area=front">Recettes</a>
                <a href="#">Suivi</a>
            </div>
            <div class="auth-buttons">
                <a href="#" class="btn-login">Connexion</a>
                <a href="#" class="btn-register">Inscription</a>
            </div>
        </nav>

        <div class="back-link">
            <a href="index.php?controller=aliment&action=index&area=front">← Retour aux aliments</a>
        </div>

        <div class="food-detail">
            <h1><?= htmlspecialchars($aliment['nom']) ?></h1>
            <div class="eco-badge eco-<?= $aliment['eco_score'] ?>">🌱 Eco-Score <?= $aliment['eco_score'] ?></div>
            <p>Catégorie : <?= $aliment['category_name'] ?? 'Non catégorisé' ?></p>
            <p>Saison : <?= $aliment['saison'] ?></p>

            <table class="nutrition-table">
                <tr><td>🔥 Calories (kcal/100g)