<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos aliments - NutriWise</title>
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
        
        .search-box { margin: 20px 0; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        .search-box button { background: #2E7D32; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .search-box button:hover { background: #1B5E20; }
        
        .foods-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; margin-top: 20px; }
        .food-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .food-card:hover { transform: translateY(-5px); }
        .food-card h3 { color: #2E7D32; margin-bottom: 10px; font-size: 18px; }
        .food-category { background: #C8E6C9; display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; margin-bottom: 10px; }
        .food-nutrition { display: flex; justify-content: space-between; margin: 15px 0; padding: 10px 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; }
        .food-nutrition div { font-size: 13px; color: #555; }
        
        .eco-A, .eco-B, .eco-C, .eco-D, .eco-E { padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .eco-A { background: #4CAF50; color: white; }
        .eco-B { background: #8BC34A; color: white; }
        .eco-C { background: #FFC107; color: white; }
        .eco-D { background: #FF9800; color: white; }
        .eco-E { background: #f44336; color: white; }
        
        .btn-detail { background: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; font-size: 13px; font-weight: bold; transition: background 0.3s; }
        .btn-detail:hover { background: #2E7D32; }
        
        .footer { text-align: center; margin-top: 50px; padding: 20px; color: #666; border-top: 1px solid #ddd; }
        .no-results { text-align: center; padding: 40px; color: #666; }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links, .auth-buttons { flex-wrap: wrap; justify-content: center; }
            .foods-grid { grid-template-columns: 1fr; }
            .search-box { flex-direction: column; }
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

        <h1>🥗 Notre base de données alimentaire</h1>
        <p class="subtitle">Découvrez la valeur nutritionnelle et l'impact environnemental de chaque aliment.</p>

        <form method="GET" class="search-box">
            <input type="hidden" name="controller" value="aliment">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="area" value="front">
            <input type="text" name="search" placeholder="Rechercher un aliment..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">🔍 Rechercher</button>
            <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                <a href="../controller/index.php?controller=aliment&action=index&area=front" style="background:#666; color:white; padding:12px 25px; text-decoration:none; border-radius:5px;">Annuler</a>
            <?php endif; ?>
        </form>

        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
            <p>Résultats : <strong><?= htmlspecialchars($_GET['search']) ?></strong> (<?= count($aliments) ?> trouvé(s))</p>
        <?php endif; ?>

        <?php if(count($aliments) > 0): ?>
        <div class="foods-grid">
            <?php foreach($aliments as $a): ?>
            <div class="food-card">
                <h3><?= htmlspecialchars($a['nom']) ?></h3>
                <div class="food-category"><?= $a['category_name'] ?? '-' ?></div>
                <div class="food-nutrition">
                    <div><?= $a['calories'] ?> kcal</div>
                    <div>P: <?= $a['proteins'] ?>g</div>
                    <div>G: <?= $a['glucides'] ?>g</div>
                    <div>L: <?= $a['lipids'] ?>g</div>
                </div>
                <div><span class="eco-<?= $a['eco_score'] ?>">🌱 Eco-Score <?= $a['eco_score'] ?></span></div>
                <a href="../controller/index.php?controller=aliment&action=show&id=<?= $a['id'] ?>" class="btn-detail">Voir le détail →</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="no-results">
                <p>Aucun aliment trouvé pour "<strong><?= htmlspecialchars($_GET['search'] ?? '') ?></strong>"</p>
                <a href="../controller/index.php?controller=aliment&action=index&area=front">Voir tous les aliments</a>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>