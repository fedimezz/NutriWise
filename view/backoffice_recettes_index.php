<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des recettes - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: #1B4D1B; color: white; position: fixed; height: 100vh; }
        .sidebar .logo { padding: 25px 20px; font-size: 24px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar nav a { display: block; padding: 12px 20px; color: rgba(255,255,255,0.8); text-decoration: none; transition: background 0.3s; }
        .sidebar nav a:hover { background: #2E7D32; }
        .sidebar nav a.active { background: #4CAF50; }
        .main-content { flex: 1; margin-left: 280px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #1B4D1B; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
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
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <nav>
                <a href="../controller/index.php?area=back">📊 Dashboard</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=back">🥗 Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=back" class="active">📖 Recettes</a>
                <a href="#">👥 Utilisateurs</a>
                <a href="#">📅 Plans</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>📖 Gestion des recettes</h1>
                <div class="admin-badge">Admin</div>
            </div>
            
            <a href="../controller/index.php?controller=recette&action=create&area=back" class="btn-add">+ Ajouter une recette</a>
            
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
                    <a href="../controller/index.php?controller=recette&action=index&area=back" style="background:#666; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">Annuler</a>
                <?php endif; ?>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Ingrédients</th>
                        <th>Difficulté</th>
                        <th>Saison</th>
                        <th>Durée</th>
                        <th>Statut</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($recettes) > 0): ?>
                        <?php foreach($recettes as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['title']) ?></td>
                            <td><?= htmlspecialchars($r['aliments_list'] ?? '-') ?></td>
                            <td><?= $r['difficulte'] ?></td>
                            <td><?= $r['saison'] ?></td>
                            <td><?= $r['duree'] ?> min</td>
                            <td><span class="<?= $r['statut'] == 'Publié' ? 'badge-published' : 'badge-draft' ?>"><?= $r['statut'] ?></span></td>
                            <td>⭐ <?= $r['score_durabilite'] ?></td>
                            <td>
                                <a href="../controller/index.php?controller=recette&action=edit&id=<?= $r['id'] ?>&area=back" class="btn-edit">✏️ Modifier</a>
                                <a href="../controller/index.php?controller=recette&action=delete&id=<?= $r['id'] ?>&area=back" class="btn-delete" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;">Aucune recette trouvée</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>