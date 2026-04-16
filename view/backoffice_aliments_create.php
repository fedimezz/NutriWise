<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un aliment - NutriWise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        
        /* ===== DASHBOARD LAYOUT ===== */
        .dashboard { display: flex; min-height: 100vh; }
        
        /* ===== SIDEBAR (GAUCHE) ===== */
        .sidebar { width: 280px; background: #1B4D1B; color: white; position: fixed; height: 100vh; }
        .sidebar .logo { padding: 25px 20px; font-size: 24px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar nav a { display: block; padding: 12px 20px; color: rgba(255,255,255,0.8); text-decoration: none; transition: background 0.3s; }
        .sidebar nav a:hover { background: #2E7D32; }
        .sidebar nav a.active { background: #4CAF50; }
        
        /* ===== MAIN CONTENT ===== */
        .main-content { flex: 1; margin-left: 280px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #1B4D1B; }
        .admin-badge { background: #4CAF50; color: white; padding: 8px 16px; border-radius: 20px; }
        
        /* ===== FORMULAIRE ===== */
        .container { background: white; border-radius: 10px; padding: 30px; max-width: 700px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #333; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; }
        button { background: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; font-size: 16px; }
        .btn-back { background: #666; text-decoration: none; color: white; padding: 12px 20px; border-radius: 5px; display: inline-block; margin-top: 20px; margin-left: 10px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .required:after { content: " *"; color: red; }
        .top-link { margin-bottom: 20px; }
        .top-link a { color: #4CAF50; text-decoration: none; }
        
        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar .logo span:last-child, .sidebar nav a span:last-child { display: none; }
            .main-content { margin-left: 80px; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- SIDEBAR GAUCHE (COMME DANS AJOUT RECETTE) -->
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

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="header">
                <h1>➕ Ajouter un aliment</h1>
                <div class="admin-badge">Admin</div>
            </div>
            
            <div class="container">
                <div class="top-link">
                    <a href="../controller/index.php?controller=aliment&action=index&area=back">← Retour à la liste</a>
                </div>
                
                <?php if(isset($_SESSION['errors'])): ?>
                    <div class="error">
                        <strong>Erreurs :</strong><br>
                        <?php foreach($_SESSION['errors'] as $e): ?>• <?= htmlspecialchars($e) ?><br><?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
                
                <form method="POST" action="../controller/index.php?controller=aliment&action=store&area=back">
                    <label class="required">Nom</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                    
                    <label class="required">Calories (kcal/100g)</label>
                    <input type="number" step="0.01" name="calories" value="<?= htmlspecialchars($_POST['calories'] ?? '') ?>" required>
                    
                    <label>Protéines (g/100g)</label>
                    <input type="number" step="0.01" name="proteins" value="<?= htmlspecialchars($_POST['proteins'] ?? '0') ?>">
                    
                    <label>Glucides (g/100g)</label>
                    <input type="number" step="0.01" name="glucides" value="<?= htmlspecialchars($_POST['glucides'] ?? '0') ?>">
                    
                    <label>Lipides (g/100g)</label>
                    <input type="number" step="0.01" name="lipids" value="<?= htmlspecialchars($_POST['lipids'] ?? '0') ?>">
                    
                    <label>Catégorie</label>
                    <select name="category_id">
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label>Eco-Score</label>
                    <select name="eco_score">
                        <option value="A">A - Très bon</option>
                        <option value="B">B - Bon</option>
                        <option value="C">C - Moyen</option>
                        <option value="D">D - Élevé</option>
                        <option value="E">E - Très élevé</option>
                    </select>
                    
                    <label>Saison</label>
                    <select name="saison">
                        <option>Printemps</option>
                        <option>Été</option>
                        <option>Automne</option>
                        <option>Hiver</option>
                        <option>Toute l'année</option>
                    </select>
                    
                    <label>
                        <input type="checkbox" name="durable" value="1"> Aliment durable ?
                    </label>
                    
                    <button type="submit">Créer l'aliment</button>
                    <a href="../controller/index.php?controller=aliment&action=index&area=back" class="btn-back">Annuler</a>
                </form>
            </div>
        </main>
    </div>
</body>
</html>