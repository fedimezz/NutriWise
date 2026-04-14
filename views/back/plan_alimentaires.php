<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans alimentaires - NutriWise</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/users.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">🌿 NutriWise</div>
            <nav>
                <a href="index.php?page=admin_dashboard">📊 Tableau de bord</a>
                <a href="index.php?page=admin_users">👥 Utilisateurs</a>
                <a href="index.php?page=admin_aliments">🥗 Aliments</a>
                <a href="#">📖 Recettes</a>
                <a href="index.php?page=admin_plan_alimentaires" class="active">📅 Plans alimentaires</a>
            </nav>
            <a href="index.php?page=logout" class="logout">🚪 Déconnexion</a>
        </aside>

        <main class="main-content">
            <header>
                <h1>Gestion des plans alimentaires</h1>
                <button class="btn-add" onclick="location.href='index.php?page=admin_add_plan_alimentaire'">+ Ajouter un plan</button>
            </header>

            <?php if(isset($_GET['success'])): ?>
                <p class="alert-message" style="color:green; margin-top:10px; font-weight:bold; background:#e8f5e9; padding:10px; border-radius:5px;">
                    <?= htmlspecialchars($_GET['success']) ?>
                </p>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <p class="alert-message" style="color:red; margin-top:10px; font-weight:bold; background:#ffebee; padding:10px; border-radius:5px;">
                    <?= htmlspecialchars($_GET['error']) ?>
                </p>
            <?php endif; ?>

            <div class="users-table-container" style="margin-top: 20px;">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Semaine</th>
                            <th>Utilisateur</th>
                            <th>Nb aliments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($plansList)): ?>
                            <tr><td colspan="5" style="text-align:center; padding:20px;">Aucun plan alimentaire trouvé.</td></tr>
                        <?php else: ?>
                            <?php foreach($plansList as $plan): ?>
                            <tr>
                                <td>#<?= $plan['id'] ?></td>
                                <td><span class="badge active">Semaine <?= htmlspecialchars($plan['week']) ?></span></td>
                                <td style="font-weight:600;"><?= htmlspecialchars($plan['user_name'] ?: 'Utilisateur inconnu') ?></td>
                                <td><?= intval($plan['aliments_count']) ?></td>
                                <td class="action-buttons">
                                    <a href="index.php?page=plan_alimentaire_details&id=<?= $plan['id'] ?>" style="text-decoration:none; display:inline-flex; align-items:center; gap:5px; background:#4caf50; color:white; padding:6px 12px; border-radius:6px; font-size:13px;">
                                        👁️ Voir
                                    </a>
                                    <a href="index.php?page=admin_edit_plan_alimentaire&id=<?= $plan['id'] ?>" style="text-decoration:none; display:inline-flex; align-items:center; gap:5px; background:#2196f3; color:white; padding:6px 12px; border-radius:6px; font-size:13px; margin-left:8px;">
                                        ✏️ Modifier
                                    </a>
                                    <a href="index.php?page=admin_delete_plan_alimentaire&id=<?= $plan['id'] ?>" style="text-decoration:none; display:inline-flex; align-items:center; gap:5px; background:#f44336; color:white; padding:6px 12px; border-radius:6px; font-size:13px; margin-left:8px;" onclick="return confirm('Sûr de vouloir supprimer ce plan alimentaire ?');">
                                        🗑️ Supprimer
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
