<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NutriWise | Nutrition intelligente et durable</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
        .welcome-banner {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            padding: 1rem 2rem;
            border-radius: 60px;
            text-align: center;
            margin-bottom: 2rem;
        }
        .welcome-banner h3 {
            color: #2e7d32;
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation dynamique -->
        <?php include_once 'partials/navbar.php'; ?>

        <!-- Message de succès après connexion -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Bannière de bienvenue pour les utilisateurs connectés -->
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="welcome-banner">
                <h3>🎉 Bonjour <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?> !</h3>
                <p>Bienvenue sur NutriWise. Prêt à explorer une alimentation plus saine et durable ?</p>
            </div>
        <?php endif; ?>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenue sur <span class="highlight">NutriWise</span></h1>
                <p class="hero-subtitle">Nutrition intelligente et durable</p>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=aliments" class="btn-primary">Explorer les aliments</a>
                <?php else: ?>
                    <a href="index.php?page=register" class="btn-primary">Commencer l'aventure</a>
                <?php endif; ?>
            </div>
            <div class="hero-image">
                <div class="floating-card card-1">🥗</div>
                <div class="floating-card card-2">🍎</div>
                <div class="floating-card card-3">🥑</div>
                <div class="hero-illustration">
                    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="90" fill="#E8F5E5" stroke="#4CAF50" stroke-width="3"/>
                        <path d="M100 50 L115 85 L155 85 L123 108 L135 145 L100 122 L65 145 L77 108 L45 85 L85 85 Z" fill="#FFD54F" stroke="#F9A825" stroke-width="2"/>
                        <circle cx="70" cy="80" r="5" fill="#4CAF50"/>
                        <circle cx="130" cy="80" r="5" fill="#4CAF50"/>
                        <path d="M85 110 Q100 120 115 110" stroke="#4CAF50" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="feature-card">
                <div class="feature-icon">🥗</div>
                <h3 class="feature-title">Explorez les aliments sains</h3>
                <p class="feature-desc">Découvrez une base de données complète d'aliments nutritifs et leurs bienfaits.</p>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <small style="color:#6c757d; margin-top:0.5rem; display:block;">🔒 Disponible après connexion</small>
                <?php endif; ?>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📖</div>
                <h3 class="feature-title">Découvrez des recettes adaptées</h3>
                <p class="feature-desc">Des recettes personnalisées selon vos objectifs, vos goûts et la saison.</p>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <small style="color:#6c757d; margin-top:0.5rem; display:block;">🔒 Disponible après connexion</small>
                <?php endif; ?>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Suivez votre alimentation</h3>
                <p class="feature-desc">Analysez vos repas, obtenez des conseils et restez motivé au quotidien.</p>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <small style="color:#6c757d; margin-top:0.5rem; display:block;">🔒 Disponible après connexion</small>
                <?php endif; ?>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="cta-section">
            <div class="cta-content">
                <h2>Prêt à transformer votre alimentation ?</h2>
                <p>Rejoignez NutriWise et adoptez une nutrition intelligente et durable dès aujourd'hui.</p>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=profile" class="btn-cta">Compléter mon profil</a>
                <?php else: ?>
                    <a href="index.php?page=register" class="btn-cta">Créer mon compte gratuitement</a>
                <?php endif; ?>
            </div>
        </section>

        <!-- Footer -->
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

    <style>
        .feature-card small {
            font-size: 0.7rem;
        }
    </style>
</body>
</html>