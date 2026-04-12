<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un aliment - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 600px; margin: 50px auto; padding: 30px; background: white; border-radius: 10px; }
        h1 { color: #2E7D32; margin-bottom: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; }
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
            <a href="index.php?controller=aliment&action=index&area=back">← Retour à la liste</a>
        </div>
        
        <h1>✏️ Modifier l'aliment</h1>
        
        <?php if(isset($_SESSION['errors'])): ?>
            <div class="error">
                <?php foreach($_SESSION['errors'] as $e): ?>• <?= $e ?><br><?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="index.php?controller=aliment&action=update&id=<?= $aliment['id'] ?>&area=back">
            <label>Nom *</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($aliment['nom']) ?>">
            
            <label>Calories (kcal/100g) *</label>
            <input type="text" name="calories" value="<?= $aliment['calories'] ?>">
            
            <label>Protéines (g/100g)</label>
            <input type="text" name="proteins" value="<?= $aliment['proteins'] ?>">
            
            <label>Glucides (g/100g)</label>
            <input type="text" name="glucides" value="<?= $aliment['glucides'] ?>">
            
            <label>Lipides (g/100g)</label>
            <input type="text" name="lipids" value="<?= $aliment['lipids'] ?>">
            
            <label>Catégorie</label>
            <select name="category_id">
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($c['id'] == $aliment['category_id']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
            
            <label>Eco-Score</label>
            <select name="eco_score">
                <option value="A" <?= $aliment['eco_score'] == 'A' ? 'selected' : '' ?>>A - Très bon</option>
                <option value="B" <?= $aliment['eco_score'] == 'B' ? 'selected' : '' ?>>B - Bon</option>
                <option value="C" <?= $aliment['eco_score'] == 'C' ? 'selected' : '' ?>>C - Moyen</option>
                <option value="D" <?= $aliment['eco_score'] == 'D' ? 'selected' : '' ?>>D - Élevé</option>
                <option value="E" <?= $aliment['eco_score'] == 'E' ? 'selected' : '' ?>>E - Très élevé</option>
            </select>
            
            <label>Saison</label>
            <select name="saison">
                <option <?= $aliment['saison'] == 'Printemps' ? 'selected' : '' ?>>Printemps</option>
                <option <?= $aliment['saison'] == 'Été' ? 'selected' : '' ?>>Été</option>
                <option <?= $aliment['saison'] == 'Automne' ? 'selected' : '' ?>>Automne</option>
                <option <?= $aliment['saison'] == 'Hiver' ? 'selected' : '' ?>>Hiver</option>
                <option <?= $aliment['saison'] == 'Toute l\'année' ? 'selected' : '' ?>>Toute l'année</option>
            </select>
            
            <label><input type="checkbox" name="durable" value="1" <?= $aliment['durable'] ? 'checked' : '' ?>> Aliment durable ?</label>
            
            <button type="submit">Enregistrer</button>
            <a href="index.php?controller=aliment&action=index&area=back" class="btn-back">Annuler</a>
        </form>
    </div>
</body>
</html>