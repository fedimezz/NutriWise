<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des aliments - NutriWise</title>
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
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .search-box { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .search-box button { background: #2E7D32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .eco-A { background: #4CAF50; color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .eco-B { background: #8BC34A; color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .eco-C { background: #FFC107; color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .eco-D { background: #FF9800; color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .eco-E { background: #f44336; color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; display: inline-block; }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <nav>
                <a href="../controller/index.php?area=back">📊 Dashboard</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=back" class="active">🥗 Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=back">📖 Recettes</a>
                <a href="#">👥 Utilisateurs</a>
                <a href="#">📅 Plans</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>🥗 Gestion des aliments</h1>
                <div class="admin-badge">Admin</div>
            </div>
            
            <a href="../controller/index.php?controller=aliment&action=create&area=back" class="btn-add">+ Ajouter un aliment</a>
            
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
                    <a href="../controller/index.php?controller=aliment&action=index&area=back" style="background:#666; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">Annuler</a>
                <?php endif; ?>
            </form>
            
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Calories</th>
                        <th>Protéines</th>
                        <th>Glucides</th>
                        <th>Lipides</th>
                        <th>Eco-Score</th>
                        <th>Saison</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($aliments) > 0): ?>
                        <?php foreach($aliments as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['nom']) ?></td>
                            <td><?= $a['category_name'] ?? '-' ?></td>
                            <td><?= $a['calories'] ?> kcal</td>
                            <td><?= $a['proteins'] ?>g</td>
                            <td><?= $a['glucides'] ?>g</td>
                            <td><?= $a['lipids'] ?>g</td>
                            <td><span class="eco-<?= $a['eco_score'] ?>">🌱 <?= $a['eco_score'] ?></span></td>
                            <td><?= $a['saison'] ?></td>
                            <td>
                                <a href="../controller/index.php?controller=aliment&action=edit&id=<?= $a['id'] ?>&area=back" class="btn-edit">✏️ Modifier</a>
                                <a href="../controller/index.php?controller=aliment&action=delete&id=<?= $a['id'] ?>&area=back" class="btn-delete" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" style="text-align:center;">Aucun aliment trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>