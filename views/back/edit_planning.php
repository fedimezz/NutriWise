<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un planning - NutriWise</title>
    <link rel="stylesheet" href="views/assets/css/edit_user.css">
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
                <h1>Modifier le planning #<?= $planning['id'] ?></h1>
            </header>

            <div class="form-container" style="max-width: 980px;">
                <?php if(isset($error)): ?>
                    <p style="color:red; margin-bottom:15px; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form action="index.php?page=admin_edit_planning&id=<?= $planning['id'] ?>" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom du planning *</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $planning['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Utilisateur *</label>
                            <select name="user_id" required>
                                <option value="">Choisir un utilisateur</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= ((isset($_POST['user_id']) && intval($_POST['user_id']) === intval($user['id'])) || (!isset($_POST['user_id']) && intval($planning['user_id']) === intval($user['id']))) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Date de début *</label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? $planning['start_date']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Date de fin *</label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($_POST['end_date'] ?? $planning['end_date']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? $planning['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Menus du planning</label>
                        <div style="border:1px solid #C8E6C9; border-radius:8px; padding:15px; background:#fafdf8; display:grid; grid-template-columns:repeat(2, 1fr); gap:10px; max-height:320px; overflow-y:auto;">
                            <?php foreach($menus as $menu): ?>
                                <label style="display:flex; align-items:center; gap:10px; font-weight:400; color:#1B4D1B;">
                                    <?php $checked = (isset($_POST['menus']) && in_array($menu['id'], $_POST['menus'])) || (!isset($_POST['menus']) && in_array($menu['id'], $selectedMenus)); ?>
                                    <input type="checkbox" name="menus[]" value="<?= $menu['id'] ?>" <?= $checked ? 'checked' : '' ?>>
                                    <span><?= htmlspecialchars($menu['title']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Statut</label>
                        <?php $status = $_POST['status'] ?? $planning['status']; ?>
                        <select name="status">
                            <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Actif</option>
                            <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Terminé</option>
                        </select>
                    </div>

                    <div class="form-actions" style="margin-top: 30px;">
                        <button type="submit" class="btn-save">Mettre à jour</button>
                        <a href="index.php?page=admin_plannings" class="btn-cancel">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="views/assets/js/validation_planning.js"></script>
</body>
</html>
