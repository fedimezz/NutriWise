<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des recettes - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; }
        h1 { color: #2E7D32; margin-bottom: 20px; }
        .top-links { margin-bottom: 20px; display: flex; gap: 20px; }
        .top-links a { color: #4CAF50; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #2E7D32; color: white; }
        .btn-add { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
        .btn-edit { background: #2196F3; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .btn-delete { background: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .badge-published { background: #4CAF50; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px; }
        .badge-draft { background: #ff9800; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .search-box { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .search-box button { background: #2E7D32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-links">
            <a href="index.php?area=back">← Dashboard</a> | 
            <a href="index.php">Voir le site public</a>
        </div>
        
        <h1>📖 Gestion des recettes</h1>
        <a href="index.php?controller=recette&action=create&area=back" class="btn-add">+ Ajouter une recette</a>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="success">Opération réussie !</div>
        <?php endif; ?>
        
        <form method="GET" class="search-box">
            <input type="hidden" name="controller" value="recette">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="area" value="back">
            <input type="text" name="search" placeholder="Rechercher une recette..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">🔍 Rechercher</button>
            <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                <a href="index.php?controller=recette&action=index&area=back" style="background:#666; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">Annuler</a>
            <?php endif; ?>
        </form>
        
        <table>
            <thead><tr><th>ID</th><th>Titre</th><th>Difficulté</th><th>Saison</th><th>Durée</th><th>Statut</th><th>Score</th><th>Actions</th></tr></thead>
            <tbody>
                <?php if(count($recettes) > 0): ?>
                    <?php foreach($recettes as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['title']) ?></td>
                        <td><?= $r['difficulte'] ?></td>
                        <td><?= $r['saison'] ?></td>
                        <td><?= $r['duree'] ?> min</td>
                        <td><span class="<?= $r['statut'] == 'Publié' ? 'badge-published' : 'badge-draft' ?>"><?= $r['statut'] == 'Publié' ? 'Publié' : 'Brouillon' ?></span></td>
                        <td>⭐ <?= $r['score_durabilite'] ?></td>
                        <td>
                            <a href="index.php?controller=recette&action=edit&id=<?= $r['id'] ?>&area=back" class="btn-edit">✏️ Modifier</a>
                            <a href="index.php?controller=recette&action=delete&id=<?= $r['id'] ?>&area=back" class="btn-delete" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center;">Aucune recette trouvée</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>