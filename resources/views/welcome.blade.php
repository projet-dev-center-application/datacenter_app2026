<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Center Manager - Gestion des ressources</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Tu peux mettre ton CSS ici aussi */
        .hero {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 60px 20px;
        }
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav style="background: #2c3e50; padding: 20px;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="color: white; margin: 0;">🏢 DataCenter Manager</h1>
            <div>
                <a href="/login" style="color: white; margin: 0 15px; text-decoration: none;">Connexion</a>
                <a href="/register" style="background: #3498db; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Inscription</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div style="max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 3rem; margin-bottom: 20px;">Gérez vos ressources informatiques efficacement</h1>
            <p style="font-size: 1.2rem; margin-bottom: 30px;">Réservation, allocation et suivi des serveurs, machines virtuelles et équipements réseau</p>
            <a href="/register" style="background: #27ae60; color: white; padding: 15px 30px; border-radius: 5px; text-decoration: none; font-size: 1.1rem;">Commencer gratuitement</a>
        </div>
    </section>

    <!-- Features -->
    <section style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <h2 style="text-align: center; margin-bottom: 50px; color: #2c3e50;">Fonctionnalités principales</h2>
        
        <div class="features">
            <div class="feature-card">
                <h3>🔧 Gestion des ressources</h3>
                <p>Serveurs, machines virtuelles, stockage, équipements réseau avec caractéristiques détaillées</p>
            </div>
            
            <div class="feature-card">
                <h3>📅 Système de réservation</h3>
                <p>Réservez vos ressources en temps réel avec vérification automatique des disponibilités</p>
            </div>
            
            <div class="feature-card">
                <h3>👥 Multi-rôles</h3>
                <p>4 profils utilisateurs : Invité, Utilisateur, Technicien, Administrateur avec droits différenciés</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #34495e; color: white; padding: 40px 20px; text-align: center;">
        <p>© 2025 Data Center Manager - Projet académique</p>
        <p>Laravel • MySQL • HTML/CSS/JS</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>