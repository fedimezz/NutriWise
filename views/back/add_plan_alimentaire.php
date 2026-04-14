<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plan alimentaire - NutriWise</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/edit_user.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">🌿 NutriWise</div>
            <nav>
                <a href="index.php?page=admin_dashboard">📊 Tableau de bord</a>
                <a href="index.php?page=admin_users">👥 Utilisateurs</a>
                <a href="index.php?page=admin_aliments">🥗 Aliments</a>
                <a href="index.php?page=admin_plan_alimentaires" class="active">📅 Plans alimentaires</a>
            </nav>
            <a href="index.php?page=logout" class="logout">🚪 Déconnexion</a>
        </aside>

        <main class="main-content">
            <header>
                <h1>Ajouter un plan alimentaire</h1>
            </header>

            <div class="form-container" style="max-width: 950px;">
                <?php if(isset($error)): ?>
                    <p style="color:red; margin-bottom:15px; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form action="index.php?page=admin_add_plan_alimentaire" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Semaine *</label>
                            <input type="number" name="week" min="1" value="<?= isset($_POST['week']) ? intval($_POST['week']) : '' ?>" placeholder="Ex: 18" required>
                        </div>
                        <div class="form-group">
                            <label>Utilisateur *</label>
                            <select name="user_id" required>
                                <option value="">Choisir un utilisateur</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= (isset($_POST['user_id']) && intval($_POST['user_id']) === intval($user['id'])) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Aliments du plan</label>
                        <div style="border:1px solid #C8E6C9; border-radius:8px; padding:15px; max-height:320px; overflow-y:auto; background:#fafdf8; display:grid; grid-template-columns:repeat(2, 1fr); gap:10px;">
                            <?php foreach($aliments as $aliment): ?>
                                <label style="display:flex; align-items:center; gap:10px; font-weight:400; color:#1B4D1B;">
                                    <input type="checkbox" name="aliments[]" value="<?= $aliment['id'] ?>"
                                        <?= (isset($_POST['aliments']) && in_array($aliment['id'], $_POST['aliments'])) ? 'checked' : '' ?>>
                                    <span>
                                        <strong><?= htmlspecialchars($aliment['nom']) ?></strong>
                                        <small style="display:block; color:#666;"><?= htmlspecialchars($aliment['categorie']) ?> - <?= htmlspecialchars($aliment['calories']) ?> kcal</small>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 30px;">
                        <button type="submit" class="btn-save">Enregistrer le plan</button>
                        <a href="index.php?page=admin_plan_alimentaires" class="btn-cancel">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
