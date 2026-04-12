<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des aliments - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; }
        h1 { color: #2E7D32; margin-bottom: 20px; }
        .top-links { margin-bottom: 20px; display: flex; gap: 20px; flex-wrap: wrap; }
        .top-links a { color: #4CAF50; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #2E7D32; color: white; }
        .btn-add { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
        .btn-edit { background: #2196F3; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .btn-delete { background: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .search-box { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .search-box button { background: #2E7D32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back-link { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-links">
            <a href="index.php?area=back">← Dashboard</a> | 
            <a href="index.php">Voir le site public</a>
        </div>
        
        <h1>🥗 Gestion des aliments</h1>
        <a href="index.php?controller=aliment&action=create&area=back" class="btn-add">+ Ajouter un aliment</a>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="success">Opération réussie !</div>
        <?php endif; ?>
        
        <form method="GET" class="search-box">
            <input type="hidden" name="controller" value="aliment">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="area" value="back">
            <input type="text" name="search" placeholder="Rechercher un aliment..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">🔍 Rechercher</button>
            <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                <a href="index.php?controller=aliment&action=index&area=back" style="background:#666; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">Annuler</a>
            <?php endif; ?>
        </form>
        
        <table>
            <thead><tr><th>ID</th><th>Nom</th><th>Catégorie</th><th>Calories</th><th>Eco-Score</th><th>Saison</th><th>Actions</th></tr></thead>
            <tbody>
                <?php if(count($aliments) > 0): ?>
                    <?php foreach($aliments as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['nom']) ?></td>
                        <td><?= $a['category_name'] ?? '-' ?></td>
                        <td><?= $a['calories'] ?> kcal</td>
                        <td><?= $a['eco_score'] ?></td>
                        <td><?= $a['saison'] ?></td>
                        <td>
                            <a href="index.php?controller=aliment&action=edit&id=<?= $a['id'] ?>&area=back" class="btn-edit">✏️ Modifier</a>
                            <a href="index.php?controller=aliment&action=delete&id=<?= $a['id'] ?>&area=back" class="btn-delete" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Aucun aliment trouvé</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="back-link">
            <a href="index.php?area=back">← Retour au Dashboard</a>
        </div>
    </div>
</body>
</html>