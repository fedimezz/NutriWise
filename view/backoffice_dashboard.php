<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - NutriWise Admin</title>
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
        .admin-badge { background: #4CAF50; color: white; padding: 8px 16px; border-radius: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-number { font-size: 28px; font-weight: bold; color: #1B4D1B; }
        .stat-label { color: #666; margin-top: 5px; }
        .section { background: white; border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-header h2 { color: #1B4D1B; }
        .view-link { color: #4CAF50; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #e8f5e9; }
        .back-link { margin-top: 20px; text-align: center; }
        .back-link a { color: #4CAF50; text-decoration: none; }
        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar .logo span:last-child, .sidebar nav a span:last-child { display: none; }
            .main-content { margin-left: 80px; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <nav>
                <a href="../controller/index.php?area=back" class="active">📊 Dashboard</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=back">🥗 Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=back">📖 Recettes</a>
                <a href="#">👥 Utilisateurs</a>
                <a href="#">📅 Plans</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>Tableau de bord</h1>
                <div class="admin-badge">Admin</div>
            </div>

            <div class="stats">
                <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Utilisateurs</div></div>
                <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Aliments</div></div>
                <div class="stat-card"><div class="stat-number">2</div><div class="stat-label">Recettes</div></div>
                <div class="stat-card"><div class="stat-number">0</div><div class="stat-label">Plans actifs</div></div>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2>Derniers aliments</h2>
                    <a href="../controller/index.php?controller=aliment&action=index&area=back" class="view-link">Voir tout →</a>
                </div>
                <table>
                    <thead><tr><th>Nom</th><th>Catégorie</th><th>Calories</th><th>Eco-Score</th></tr></thead>
                    <tbody>
                        <tr><td>🍎 Pomme</td><td>Fruits</td><td>52 kcal</td><td>A</td></tr>
                        <tr><td>🥑 Avocat</td><td>Fruits</td><td>160 kcal</td><td>C</td></tr>
                        <tr><td>🥦 Brocoli</td><td>Légumes</td><td>34 kcal</td><td>A</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2>Dernières recettes</h2>
                    <a href="../controller/index.php?controller=recette&action=index&area=back" class="view-link">Voir tout →</a>
                </div>
                <table>
                    <thead><tr><th>Titre</th><th>Difficulté</th><th>Saison</th><th>Statut</th></tr></thead>
                    <tbody>
                        <tr><td>Salade de quinoa</td><td>Facile</td><td>Printemps</td><td>Publié</td></tr>
                        <tr><td>Soupe de potiron</td><td>Moyen</td><td>Hiver</td><td>Publié</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="back-link">
                <a href="../controller/index.php">← Retour au site public</a>
            </div>
        </main>
    </div>
</body>
</html><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - NutriWise Admin</title>
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
        .admin-badge { background: #4CAF50; color: white; padding: 8px 16px; border-radius: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-number { font-size: 28px; font-weight: bold; color: #1B4D1B; }
        .stat-label { color: #666; margin-top: 5px; }
        .section { background: white; border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-header h2 { color: #1B4D1B; }
        .view-link { color: #4CAF50; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #e8f5e9; }
        .back-link { margin-top: 20px; text-align: center; }
        .back-link a { color: #4CAF50; text-decoration: none; }
        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar .logo span:last-child, .sidebar nav a span:last-child { display: none; }
            .main-content { margin-left: 80px; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo"><span>🌿</span><span>NutriWise</span></div>
            <nav>
                <a href="../controller/index.php?area=back" class="active">📊 Dashboard</a>
                <a href="../controller/index.php?controller=aliment&action=index&area=back">🥗 Aliments</a>
                <a href="../controller/index.php?controller=recette&action=index&area=back">📖 Recettes</a>
                <a href="#">👥 Utilisateurs</a>
                <a href="#">📅 Plans</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>Tableau de bord</h1>
                <div class="admin-badge">Admin</div>
            </div>

            <div class="stats">
                <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Utilisateurs</div></div>
                <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Aliments</div></div>
                <div class="stat-card"><div class="stat-number">2</div><div class="stat-label">Recettes</div></div>
                <div class="stat-card"><div class="stat-number">0</div><div class="stat-label">Plans actifs</div></div>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2>Derniers aliments</h2>
                    <a href="../controller/index.php?controller=aliment&action=index&area=back" class="view-link">Voir tout →</a>
                </div>
                <table>
                    <thead><tr><th>Nom</th><th>Catégorie</th><th>Calories</th><th>Eco-Score</th></tr></thead>
                    <tbody>
                        <tr><td>🍎 Pomme</td><td>Fruits</td><td>52 kcal</td><td>A</td></tr>
                        <tr><td>🥑 Avocat</td><td>Fruits</td><td>160 kcal</td><td>C</td></tr>
                        <tr><td>🥦 Brocoli</td><td>Légumes</td><td>34 kcal</td><td>A</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2>Dernières recettes</h2>
                    <a href="../controller/index.php?controller=recette&action=index&area=back" class="view-link">Voir tout →</a>
                </div>
                <table>
                    <thead><tr><th>Titre</th><th>Difficulté</th><th>Saison</th><th>Statut</th></tr></thead>
                    <tbody>
                        <tr><td>Salade de quinoa</td><td>Facile</td><td>Printemps</td><td>Publié</td></tr>
                        <tr><td>Soupe de potiron</td><td>Moyen</td><td>Hiver</td><td>Publié</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="back-link">
                <a href="../controller/index.php">← Retour au site public</a>
            </div>
        </main>
    </div>
</body>
</html>