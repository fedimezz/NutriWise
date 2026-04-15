<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos recettes - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f8f0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar { background: #1B4D1B; padding: 15px 30px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .navbar .logo { color: white; font-size: 24px; font-weight: bold; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 20px; flex-wrap: wrap; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 16px; border-radius: 8px; transition: background 0.3s; cursor: pointer; }
        .nav-links a:hover, .nav-links a.active { background: #4CAF50; }
        .auth-buttons { display: flex; gap: 10px; }
        .btn-login { background: transparent; border: 1px solid white; color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; cursor: pointer; }
        .btn-login:hover { background: white; color: #1B4D1B; }
        .btn-register { background: #4CAF50; color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; cursor: pointer; }
        .btn-register:hover { background: #2E7D32; }
        h1 { color: #2E7D32; margin-bottom: 10px; }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .btn-propose {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-propose:hover {
            background: #2E7D32;
            transform: translateY(-2px);
        }
        .search-box { margin: 20px 0; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        .search-box button { background: #2E7D32; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; }
        .recipes-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .recipe-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .recipe-card:hover { transform: translateY(-5px); }
        .recipe-card h3 { color: #2E7D32; margin-bottom: 10px; }
        .recipe-meta { display: flex; gap: 15px; font-size: 13px; color: #666; margin: 10px 0; }
        .recipe-ingredients { font-size: 13px; color: #888; margin: 10px 0; font-style: italic; }
        .recipe-score { color: #f9a825; margin: 10px 0; }
        .btn-detail { background: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #666; }
        .back-link { margin: 20px 0; }
        .back-link a { color: #4CAF50; text-decoration: none; }
        .no-results { text-align: center; padding: 40px; color: #666; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745; }
        @media (max-width: 768px) { 
            .navbar { flex-direction: column; text-align: center; }
            .header-section { flex-direction: column; text-align: center; }
            .btn-propose { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <div class="nav-links">
                <a href="../controller/index.php">Accueil</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=front">Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=front" class="active">Recettes</a>
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

        <div class="header-section">
            <div>
                <h1>🍳 Nos recettes durables</h1>
                <p>Découvrez des recettes saines, locales et respectueuses de l'environnement.</p>
            </div>
            <a href="../controller/index.php?controller=recette&action=createUser&area=front" class="btn-propose">
                ➕ Proposer une recette
            </a>
        </div>

        <?php if(isset($_GET['success']) && $_GET['success'] == 'created'): ?>
            <div class="success-message">
                ✅ Merci ! Votre recette a été soumise avec succès. Elle sera publiée après validation par notre équipe.
            </div>
        <?php endif; ?>

        <form method="GET" class="search-box">
            <input type="hidden" name="controller" value="recette">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="area" value="front">
            <input type="text" name="search" placeholder="Rechercher une recette..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">🔍 Rechercher</button>
            <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                <a href="../controller/index.php?controller=recette&action=index&area=front" style="background:#666; color:white; padding:12px 25px; text-decoration:none; border-radius:5px;">Annuler</a>
            <?php endif; ?>
        </form>

        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
            <p>Résultats : <strong><?= htmlspecialchars($_GET['search']) ?></strong> (<?= count($recettes) ?> trouvé(s))</p>
        <?php endif; ?>

        <?php if(count($recettes) > 0): ?>
        <div class="recipes-grid">
            <?php foreach($recettes as $r): ?>
            <div class="recipe-card">
                <h3><?= htmlspecialchars($r['title']) ?></h3>
                <div class="recipe-meta">
                    <span>⏱️ <?= $r['duree'] ?> min</span>
                    <span><?= $r['difficulte'] ?></span>
                    <span><?= $r['saison'] ?></span>
                </div>
                <?php if(isset($r['aliments_list']) && !empty($r['aliments_list'])): ?>
                <div class="recipe-ingredients">
                    🥗 Ingrédients : <?= htmlspecialchars(substr($r['aliments_list'], 0, 60)) ?>...
                </div>
                <?php endif; ?>
                <div class="recipe-score">⭐ Score durabilité : <?= $r['score_durabilite'] ?>/5</div>
                <p><?= htmlspecialchars(substr($r['description'] ?? '', 0, 100)) ?>...</p>
                <a href="../controller/index.php?controller=recette&action=show&id=<?= $r['id'] ?>" class="btn-detail">Voir la recette →</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="no-results">
                <p>Aucune recette trouvée pour "<strong><?= htmlspecialchars($_GET['search'] ?? '') ?></strong>"</p>
                <a href="../controller/index.php?controller=recette&action=index&area=front">Voir toutes les recettes</a>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>