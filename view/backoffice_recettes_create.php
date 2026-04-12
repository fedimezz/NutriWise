<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une recette - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 700px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; }
        h1 { color: #2E7D32; margin-bottom: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; }
        .btn-back { background: #666; text-decoration: none; color: white; padding: 12px 20px; border-radius: 5px; display: inline-block; margin-top: 20px; margin-left: 10px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .top-link { margin-bottom: 20px; }
        .top-link a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-link">
            <a href="../controller/index.php?controller=recette&action=index&area=back">← Retour à la liste</a>
        </div>
        
        <h1>➕ Ajouter une recette</h1>
        
        <?php if(isset($_SESSION['errors'])): ?>
            <div class="error">
                <?php foreach($_SESSION['errors'] as $e): ?>• <?= $e ?><br><?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="../controller/index.php?controller=recette&action=store&area=back">
            <label>Titre *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            
            <label>Description</label>
            <textarea name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            
            <label>Instructions</label>
            <textarea name="instructions" rows="5" placeholder="1. ...&#10;2. ...&#10;3. ..."><?= htmlspecialchars($_POST['instructions'] ?? '') ?></textarea>
            
            <label>Durée (minutes) *</label>
            <input type="text" name="duree" value="<?= htmlspecialchars($_POST['duree'] ?? '30') ?>">
            
            <label>Difficulté</label>
            <select name="difficulte">
                <option>Facile</option><option>Moyen</option><option>Difficile</option>
            </select>
            
            <label>Saison</label>
            <select name="saison">
                <option>Printemps</option><option>Été</option><option>Automne</option><option>Hiver</option><option>Toute l'année</option>
            </select>
            
            <label>Statut</label>
            <select name="statut">
                <option>Brouillon</option><option>Publié</option>
            </select>
            
            <label>Score durabilité (⭐/5)</label>
            <select name="score_durabilite">
                <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
            </select>
            
            <button type="submit">Créer la recette</button>
            <a href="../controller/index.php?controller=recette&action=index&area=back" class="btn-back">Annuler</a>
        </form>
    </div>
</body>
</html>