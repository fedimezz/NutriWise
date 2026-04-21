<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plannings - NutriWise</title>
    <link rel="stylesheet" href="views/assets/css/users.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">🌿 NutriWise</div>
            <nav>
                <a href="index.php?page=admin_dashboard">📊 Tableau de bord</a>
                <a href="index.php?page=admin_users">👥 Utilisateurs</a>
                <a href="index.php?page=admin_aliments">🥗 Aliments</a>
                <a href="index.php?page=admin_menus">📋 Menus</a>
                <a href="index.php?page=admin_plannings" class="active">🗓️ Plannings</a>
            </nav>
            <a href="index.php?page=logout" class="logout">🚪 Déconnexion</a>
        </aside>

        <main class="main-content">
            <header>
                <h1>Gestion des plannings</h1>
                <button class="btn-add" onclick="location.href='index.php?page=admin_add_planning'">+ Ajouter un planning</button>
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
                            <th>Nom</th>
                            <th>Utilisateur</th>
                            <th>Période</th>
                            <th>Menus</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($plannings)): ?>
                            <tr><td colspan="7" style="text-align:center; padding:20px;">Aucun planning trouvé.</td></tr>
                        <?php else: ?>
                            <?php foreach($plannings as $planning): ?>
                                <tr>
                                    <td>#<?= $planning['id'] ?></td>
                                    <td style="font-weight:600;"><?= htmlspecialchars($planning['name']) ?></td>
                                    <td><?= htmlspecialchars($planning['user_name'] ?: 'Non affecté') ?></td>
                                    <td><?= htmlspecialchars($planning['start_date']) ?> → <?= htmlspecialchars($planning['end_date']) ?></td>
                                    <td><?= intval($planning['menu_count']) ?></td>
                                    <td><?= htmlspecialchars($planning['status']) ?></td>
                                    <td class="action-buttons">
                                        <a href="index.php?page=admin_edit_planning&id=<?= $planning['id'] ?>" class="btn-icon">✏️</a>
                                        <a href="index.php?page=admin_delete_planning&id=<?= $planning['id'] ?>" class="btn-icon" onclick="return confirm('Voulez-vous vraiment supprimer ce planning ?');">🗑️</a>
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
