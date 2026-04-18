<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer une recette - NutriWise</title>
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
        
        h1 { color: #2E7D32; margin-bottom: 10px; font-size: 28px; }
        .subtitle { color: #666; margin-bottom: 20px; }
        
        .recipe-form { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #333; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; }
        button { background: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; font-size: 16px; width: 100%; font-weight: bold; }
        button:hover { background: #2E7D32; }
        button:disabled { background: #ccc; cursor: not-allowed; }
        .btn-back { background: #666; text-decoration: none; color: white; padding: 12px 20px; border-radius: 5px; display: inline-block; margin-top: 20px; text-align: center; width: 100%; }
        .btn-back:hover { background: #555; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .aliments-list { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 5px; background: #f9f9f9; }
        .aliment-checkbox { margin: 5px 0; }
        .aliment-checkbox label { margin-left: 8px; font-weight: normal; display: inline; cursor: pointer; }
        .required:after { content: " *"; color: red; }
        .info-message { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #17a2b8; }
        
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
            <a href="../controller/index.php?controller=recette&action=index&area=front">← Retour aux recettes</a>
        </div>

        <h1>🍳 Proposer une recette</h1>
        <p class="subtitle">Partagez votre recette avec la communauté NutriWise !</p>

        <div class="info-message">
            💡 Votre recette sera soumise à validation par notre équipe avant publication.
        </div>

        <div class="recipe-form">
            <?php if(isset($_SESSION['errors'])): ?>
                <div class="error">
                    <strong>Veuillez corriger les erreurs suivantes :</strong><br>
                    <?php foreach($_SESSION['errors'] as $e): ?>• <?= htmlspecialchars($e) ?><br><?php endforeach; ?>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
            
            <?php if(isset($_GET['success']) && $_GET['success'] == 'created'): ?>
                <div class="success">
                    ✅ Merci ! Votre recette a été soumise avec succès. Elle sera publiée après validation.
                </div>
            <?php endif; ?>
            
            <form method="POST" action="../controller/index.php?controller=recette&action=store&area=front">
                <input type="hidden" name="area" value="front">
                
                <label class="required">Titre de la recette</label>
                <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required maxlength="150" placeholder="Ex: Tarte aux pommes maison">
                
                <label>Description (optionnel)</label>
                <textarea name="description" rows="3" placeholder="Décrivez brièvement votre recette..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                
                <label class="required">Instructions détaillées</label>
                <textarea name="instructions" rows="6" placeholder="1. Préparez les ingrédients&#10;2. ..." required><?= htmlspecialchars($_POST['instructions'] ?? '') ?></textarea>
                
                <label class="required">Durée de préparation (minutes)</label>
                <input type="number" name="duree" value="<?= htmlspecialchars($_POST['duree'] ?? '30') ?>" min="1" max="1440" required>
                
                <label>Difficulté</label>
                <select name="difficulte">
                    <option value="Facile" <?= ($_POST['difficulte'] ?? '') == 'Facile' ? 'selected' : '' ?>>Facile</option>
                    <option value="Moyen" <?= ($_POST['difficulte'] ?? '') == 'Moyen' ? 'selected' : '' ?>>Moyen</option>
                    <option value="Difficile" <?= ($_POST['difficulte'] ?? '') == 'Difficile' ? 'selected' : '' ?>>Difficile</option>
                </select>
                
                <label>Saison recommandée</label>
                <select name="saison">
                    <option value="Printemps" <?= ($_POST['saison'] ?? '') == 'Printemps' ? 'selected' : '' ?>>Printemps</option>
                    <option value="Ete" <?= ($_POST['saison'] ?? '') == 'Ete' ? 'selected' : '' ?>>Ete</option>
                    <option value="Automne" <?= ($_POST['saison'] ?? '') == 'Automne' ? 'selected' : '' ?>>Automne</option>
                    <option value="Hiver" <?= ($_POST['saison'] ?? '') == 'Hiver' ? 'selected' : '' ?>>Hiver</option>
                    <option value="Toute l annee" <?= ($_POST['saison'] ?? '') == 'Toute l annee' ? 'selected' : '' ?>>Toute l'année</option>
                </select>
                
                <label class="required">Ingrédients (sélectionnez les aliments utilisés)</label>
                <div class="aliments-list">
                    <?php if(isset($aliments) && is_array($aliments) && count($aliments) > 0): ?>
                        <?php foreach($aliments as $aliment): ?>
                            <div class="aliment-checkbox">
                                <input type="checkbox" name="aliments[]" value="<?= $aliment['id'] ?>" id="aliment_<?= $aliment['id'] ?>"
                                    <?= (isset($_POST['aliments']) && in_array($aliment['id'], $_POST['aliments'])) ? 'checked' : '' ?>>
                                <label for="aliment_<?= $aliment['id'] ?>"><?= htmlspecialchars($aliment['nom']) ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px;">
                            ⚠️ Aucun aliment n'est encore disponible. 
                            <a href="../controller/index.php?controller=aliment&action=index&area=front">Voir les aliments</a>
                        </p>
                    <?php endif; ?>
                </div>
                <p style="font-size: 12px; color: #666; margin-top: 5px;">💡 Vous pouvez sélectionner plusieurs ingrédients</p>
                
                <button type="submit" <?= (!isset($aliments) || count($aliments) == 0) ? 'disabled' : '' ?>>Soumettre ma recette</button>
            </form>
            
            <a href="../controller/index.php?controller=recette&action=index&area=front" class="btn-back">Annuler</a>
        </div>

        <div class="footer">
            <p>© 2025 NutriWise - Nutrition intelligente et durable</p>
        </div>
    </div>
</body>
</html>