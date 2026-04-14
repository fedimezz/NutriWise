<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Détail du plan alimentaire - NutriWise</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include_once 'partials/navbar.php'; ?>

        <section style="padding: 2rem 0 1rem 0;">
            <a href="index.php?page=plan_alimentaires" style="display:inline-block; margin-bottom:1rem; color:#2e7d32; font-weight:600; text-decoration:none;">← Retour aux plans alimentaires</a>
            <h1 class="hero-title" style="font-size:2.4rem; margin-bottom:0.5rem;">Plan alimentaire - <span class="highlight">Semaine <?= htmlspecialchars($plan['week']) ?></span></h1>
            <p class="hero-subtitle" style="margin-bottom:0;">Utilisateur : <strong><?= htmlspecialchars($plan['user_name']) ?></strong></p>
        </section>

        <section class="features" style="align-items:stretch; justify-content:flex-start;">
            <?php if(empty($planAliments)): ?>
                <div class="feature-card" style="text-align:left; max-width:700px; width:100%;">
                    <div class="feature-icon">📭</div>
                    <h3 class="feature-title">Aucun aliment dans ce plan</h3>
                    <p class="feature-desc">Ce plan a été créé sans aliments pour le moment.</p>
                </div>
            <?php else: ?>
                <?php foreach($planAliments as $aliment): ?>
                    <div class="feature-card" style="text-align:left; max-width:340px;">
                        <div class="feature-icon">🍽️</div>
                        <h3 class="feature-title"><?= htmlspecialchars($aliment['nom']) ?></h3>
                        <p class="feature-desc"><strong>Catégorie :</strong> <?= htmlspecialchars($aliment['categorie']) ?></p>
                        <p class="feature-desc"><strong>Calories :</strong> <?= htmlspecialchars($aliment['calories']) ?> kcal / 100g</p>
                        <p class="feature-desc"><strong>P / G / L :</strong> <?= htmlspecialchars($aliment['proteines']) ?>g / <?= htmlspecialchars($aliment['glucides']) ?>g / <?= htmlspecialchars($aliment['lipides']) ?>g</p>
                        <a href="index.php?page=aliment_details&id=<?= $aliment['id'] ?>" class="btn-primary" style="display:inline-block; text-decoration:none; padding:0.8rem 1.5rem; font-size:0.95rem; margin-top:0.8rem;">Voir l'aliment</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <footer class="footer">
            <div class="footer-content">
                <div class="footer-logo">
                    <span class="logo-icon">🌿</span>
                    <span>NutriWise</span>
                </div>
                <p class="footer-copyright">© 2024 NutriWise - Nutrition intelligente et durable</p>
            </div>
        </footer>
    </div>
</body>
</html>
