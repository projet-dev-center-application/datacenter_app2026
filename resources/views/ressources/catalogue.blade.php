<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Ressources | DataCenter IT</title>
    <!-- Lien vers le fichier CSS (à placer dans public/css/catalog.css) -->
    <link rel="stylesheet" href="{{ asset('css/catalogue.css') }}">
    <!-- Police professionnelle (Inter ou Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
    <div class="container header-container">
        <div class="logo">
           <img src="../images/icons8-serveur.gif" alt="datacore_logo" class="logo1">
            <span>DataCore Manager</span>
        </div>

        <nav class="main-nav">
           <ul>
           <li>
    <a href="{{ route('home') }}"
       class="{{ request()->routeIs('home') ? 'active' : '' }}">
        Accueil
    </a>
</li>

<li>
    <a href="{{ route('resources.index') }}"
       class="{{ request()->routeIs('resources.*') ? 'active' : '' }}">
        Ressources
    </a>
</li>

<li>
    <a href="{{ route('reservations.index') }}"
       class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
        Réservations
    </a>
</li>

<li>
    <a href="#contact"
       class="{{ request()->is('contact') ? 'active' : '' }}">
        Contact
    </a>
</li>
    </ul>
        </nav>

        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
        </div>
    </div>
</header>
    <!-- HEADER DE PAGE -->
    <header class="page-header">
        <div class="container">
            <div class="header-content">
                <h1>Catalogue des Ressources Infrastructure</h1>
                <p>Consultez l'état en temps réel du parc informatique, des clusters HPC aux baies de stockage, et effectuez vos demandes d'allocation pour vos projets IT.</p>
            </div>
        </div>
    </header>

    <!-- SECTION PRINCIPALE : GRILLE DES RESSOURCES -->
    <main class="main-content">
        <div class="container">
            
            <!-- Grid Container -->
            <div class="resource-grid">

                <!-- CARTE 1 : Serveur Physique (Oracle) -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Serveurs en rack -->
                        <img src="../images/OracleXData.jpg" alt="Serveur Oracle Exadata" class="card-img">
                        <span class="status-badge status-reserved">🟠 Réservé</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Serveur Physique</span>
                            <h3>Oracle Exadata X8M</h3>
                        </div>
                        <p class="description">Serveur de base de données haute performance optimisé pour les charges de travail critiques et l'analytique.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Salle A - Rack 04</div>
                            <div class="meta-item">📦 Qté: 2 Unités</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Détails</a>
                            <button class="btn btn-disabled" disabled>Indisponible</button>
                        </div>
                    </div>
                </article>

                <!-- CARTE 2 : Cluster HPC -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Supercalculateur / HPC -->
                        <img src="https://images.unsplash.com/photo-1597852074816-d933c7d2b988?auto=format&fit=crop&w=800&q=80" alt="Cluster HPC Compute" class="card-img">
                        <span class="status-badge status-busy">🔴 En utilisation</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Cluster HPC</span>
                            <h3>Compute Grid Alpha</h3>
                        </div>
                        <p class="description">Nœuds de calcul intensif (GPU A100) pour simulations scientifiques et entraînements IA.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Zone HPC - Allée 2</div>
                            <div class="meta-item">📦 128 Nœuds</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Monitorer</a>
                            <a href="#" class="btn btn-primary">File d'attente</a>
                        </div>
                    </div>
                </article>

                <!-- CARTE 3 : Cloud / Kubernetes -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Ambiance Cloud / DevOps -->
                        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80" alt="Cluster Kubernetes" class="card-img">
                        <span class="status-badge status-available">🟢 Disponible</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Container Platform</span>
                            <h3>Cluster OpenShift / K8s</h3>
                        </div>
                        <p class="description">Environnement d'orchestration de conteneurs pour le déploiement d'applications micro-services.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Virtuel (Cluster V)</div>
                            <div class="meta-item">📦 500 vCPU</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Config</a>
                            <a href="#" class="btn btn-primary">Déployer</a>
                        </div>
                    </div>
                </article>

                <!-- CARTE 4 : Stockage SAN -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Disques Durs / Baie de stockage -->
                        <img src="../images/FlashStorageavif.avif" alt="Baie de Stockage SAN" class="card-img">
                        <span class="status-badge status-available">🟢 Disponible</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Stockage SAN</span>
                            <h3>NetApp All-Flash Array</h3>
                        </div>
                        <p class="description">Stockage bloc ultra-rapide NVMe pour bases de données et environnements virtualisés critiques.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Salle B - Rack 12</div>
                            <div class="meta-item">📦 200 TB Libres</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Volume</a>
                            <a href="#" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </article>

                <!-- CARTE 5 : Réseau (Switch) -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Câblage réseau / Switch -->
                        <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80" alt="Switch Core Arista" class="card-img">
                        <span class="status-badge status-available">🟢 Disponible</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Réseau Core</span>
                            <h3>Arista 7000 Series</h3>
                        </div>
                        <p class="description">Switching haute densité 100GbE pour l'interconnexion Spine-Leaf du Data Center.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Net Room 01</div>
                            <div class="meta-item">📦 48 Ports/U</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Topology</a>
                            <a href="#" class="btn btn-primary">Configurer</a>
                        </div>
                    </div>
                </article>

                <!-- CARTE 6 : Sécurité (Firewall) -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Serveur Sécurisé / LED Rouges -->
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80" alt="Firewall Palo Alto" class="card-img">
                        <span class="status-badge status-busy">🔴 Maintenance</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Sécurité</span>
                            <h3>Palo Alto NGFW</h3>
                        </div>
                        <p class="description">Pare-feu de nouvelle génération avec inspection DPI et prévention des menaces en temps réel.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Salle Sec - Rack 01</div>
                            <div class="meta-item">📦 Cluster HA</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Logs</a>
                            <button class="btn btn-disabled" disabled>Maintenance</button>
                        </div>
                    </div>
                </article>

                 <!-- CARTE 7 : Refroidissement -->
                 <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Tuyaux industriels / Cooling -->
                        <img src="https://images.unsplash.com/photo-1562408590-e32931084e23?auto=format&fit=crop&w=800&q=80" alt="Système de refroidissement" class="card-img">
                        <span class="status-badge status-available">🟢 Optimisé</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">Infrastructure</span>
                            <h3>Liquid Cooling System</h3>
                        </div>
                        <p class="description">Gestion thermique avancée pour les zones haute densité. Surveillance des fuites et températures.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 Zone Technique</div>
                            <div class="meta-item">📦 PUE 1.2</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Métriques</a>
                            <a href="#" class="btn btn-primary">Ajuster</a>
                        </div>
                    </div>
                </article>

                <!-- CARTE 8 : DevOps Farm -->
                <article class="resource-card">
                    <div class="card-image-wrapper">
                        <!-- Image réelle : Bureau technique / Code -->
                        <img src="https://images.unsplash.com/photo-1555099962-4199c345e5dd?auto=format&fit=crop&w=800&q=80" alt="DevOps CI/CD" class="card-img">
                        <span class="status-badge status-available">🟢 Disponible</span>
                    </div>
                    <div class="card-body">
                        <div class="card-top">
                            <span class="resource-type">DevOps</span>
                            <h3>Jenkins Build Farm</h3>
                        </div>
                        <p class="description">Pool de runners dédiés pour l'intégration et le déploiement continu (CI/CD) des projets web.</p>
                        <div class="meta-info">
                            <div class="meta-item">📍 VM Zone</div>
                            <div class="meta-item">📦 24 Runners</div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="btn btn-secondary">Pipelines</a>
                            <a href="#" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </main> <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <h5>DataCore Manager</h5>
                    <p>Solution professionnelle de gestion de Data Center.</p>
                </div>
                <div class="footer-links">
                    <div class="link-col">
                        <h6>Navigation</h6>
                        <a href="/">Accueil</a>
                        <a href="#">Catalogue</a>
                        <a href="#">Dashboard</a>
                    </div>
                    <div class="link-col">
                        <h6>Support</h6>
                        <a href="#">Documentation IT</a>
                        <a href="#">Ouvrir un ticket</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 DataCore Manager. Tous droits réservés.</p>
                <p class="academic-note">Projet DataCenter – Laravel & MySQL</p>
            </div>
        </div>
    </footer>
</body>
</html>