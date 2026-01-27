<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="DataCore Manager - Gestion professionnelle des ressources de Data Center">
<title>DataCore Manager | Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    <a href="{{ route('reservations.create') }}"
       class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
        Réservations
    </a>
</li>

<li>
    <a href="{{ route('contact') }}"
       class="{{ request()->routeIs('contact') ? 'active' : '' }}">
        Contact
    </a>
</li>

            </ul>
        </nav>

       <div class="auth-buttons">
    @guest
        <!-- CAS 1 : VISITEUR (Non connecté) -->
        <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
    @else
        <!-- CAS 2 : UTILISATEUR CONNECTÉ -->
        <div class="user-controls">
             <div class="user-container">
                <img src="{{ asset('images/user.png') }}" alt="user" class="user-icon">
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="btn-sm">
                        Mon Espace

                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-sm">
                        Mon Espace
                    </a>
                @endif
             </div>
             
            <form method="POST" action="{{ route('logout') }}" class="logout-form" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-primary btn-logout" title="Se déconnecter">
                   Deconnexion
                </button>
            </form>
        </div>
    @endguest
</div>
</header>

<!--  HERO SECTION -->
<section class="hero-section" style="padding:0">
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="data-stream"></div>
    <div class="data-stream"></div>
    <div class="data-stream"></div>
    <div class="data-stream"></div>
    
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="glow-text">Réservation en un clic | Optimisation en temps réel</h1>
            <p>Automatisez la gestion de vos infrastructures, optimisez les ressources et prenez des décisions éclairées grâce à une vue centralisée et sécurisée.</p>
            <div class="hero-actions">
    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Gérer l'Infrastructure</a>
        @else
            <a href="{{ route('resources.index') }}" class="btn btn-primary btn-lg">Réserver une Ressource</a>
        @endif
    @else
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Commencer dès Maintenant</a>
    @endauth
</div>
        </div>
    </div>
</section>
<!--  SECTION À PROPOS DE NOUS -->
<section class="about-section">
    <div class="container">
        <div class="section-header center-text">
            <h2>À Propos de DataCore Manager</h2>
            <p>Notre mission est de révolutionner la gestion des infrastructures IT</p>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <h3>Qui sommes-nous ?</h3>
                <p>
                    DataCore Manager est né d'une vision simple : simplifier la complexité de la gestion 
                    des Data Centers. Fondé par une équipe d'experts en infrastructure IT et développement 
                    logiciel, nous avons créé une plateforme qui transforme la gestion des ressources 
                    informatiques en un processus fluide et efficace.
                </p>
                
                <h3>Notre Vision</h3>
                <p>
                    Nous croyons que chaque organisation mérite une gestion d'infrastructure transparente, 
                    sécurisée et optimisée. Notre objectif est d'éliminer les silos opérationnels et de 
                    fournir une vue unifiée de toutes vos ressources IT.
                </p>
            </div>
            
            <div class="about-stats">
                <div class="stat-card">
                    <div class="stat-number">3+</div>
                    <div class="stat-desc">Années d'expertise</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-desc">Clients satisfaits</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-desc">Ressources managées</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">99.7%</div>
                    <div class="stat-desc">Satisfaction client</div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!--  FONCTIONNALITÉS (Cards) -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2>Pourquoi choisir DataCore ?</h2>
            <p>Une suite complète pour les administrateurs systèmes et DSI.</p>
        </div>
        
        <div class="grid-3">
            <article class="card feature-card">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                </div>
                <h3>Gestion Centralisée</h3>
                <p>Inventaire complet des serveurs physiques, VM et équipements réseau en un seul coup d'œil.</p>
            </article>

            <article class="card feature-card">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3>Réservation Intelligente</h3>
                <p>Système de booking avec détection automatique de conflits et files d'attente prioritaires.</p>
            </article>

            <article class="card feature-card">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Sécurité & Traçabilité</h3>
                <p>Logs détaillés des accès, rôles utilisateurs granulaires et monitoring des incidents.</p>
            </article>
        </div>
    </div>
</section>
<!--  SECTION TÉMOIGNAGES -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header center-text">
            <h2>Ce que disent nos clients</h2>
            <p>Découvrez les expériences de nos utilisateurs satisfaits</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="client-avatar avatar-1"></div>
                    <div class="client-info">
                        <h4>Marc Leclerc</h4>
                        <p class="client-role">DSI - TechSolutions SA</p>
                    </div>
                    <div class="quote-icon">❝</div>
                </div>
                <div class="testimonial-content">
                    <p>
                        "DataCore Manager a transformé notre gestion d'infrastructure. 
                        Nous avons réduit de 40% notre temps d'allocation des ressources 
                        et amélioré la visibilité sur notre parc serveur."
                    </p>
                </div>
                <div class="testimonial-rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="client-avatar avatar-2"></div>
                    <div class="client-info">
                        <h4>Sarah Benoit</h4>
                        <p class="client-role">Responsable IT - Université ParisTech</p>
                    </div>
                    <div class="quote-icon">❝</div>
                </div>
                <div class="testimonial-content">
                    <p>
                        "La plateforme est parfaite pour notre environnement académique. 
                        Les chercheurs peuvent réserver facilement des ressources pour leurs 
                        projets, et notre équipe a une vue centralisée sur l'utilisation."
                    </p>
                </div>
                <div class="testimonial-rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="client-avatar avatar-3"></div>
                    <div class="client-info">
                        <h4>Pierre Moreau</h4>
                        <p class="client-role">Admin Système - CloudHost Pro</p>
                    </div>
                    <div class="quote-icon">❝</div>
                </div>
                <div class="testimonial-content">
                    <p>
                        "Le système de réservation intelligent a éliminé les conflits 
                        de planning. Les notifications automatiques et le suivi en temps 
                        réel ont grandement amélioré notre productivité."
                    </p>
                </div>
                <div class="testimonial-rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
            </div>
        </div>
        
        <div class="testimonial-indicators">
            <button class="indicator active" data-slide="0"></button>
            <button class="indicator" data-slide="1"></button>
            <button class="indicator" data-slide="2"></button>
        </div>
        
        <div class="companies-section">
            <h4>Ils nous font confiance</h4>
            <div class="companies-logos">
                <div class="company-logo">TechUniversity</div>
                <div class="company-logo">DataCenterPro</div>
                <div class="company-logo">CloudSolutions</div>
                <div class="company-logo">ResearchLab</div>
                <div class="company-logo">InnovateIT</div>
            </div>
        </div>
    </div>
</section>
<section id="stats" class="stats-section">
    <div class="container">
        <div class="section-header center-text">
            <h2>Métriques en Temps Réel</h2>
        </div>
        
        <div class="stats-grid">
            <div class="stat-box">
                <h4>Occupation CPU</h4>
                <div class="bar-chart">
                    <div class="bar-container">
                        <div class="bar-fill" style="height: 45%;"><span>45%</span></div>
                        <span class="bar-label">Cluster A</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill danger" style="height: 85%;"><span>85%</span></div>
                        <span class="bar-label">Cluster B</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill warning" style="height: 60%;"><span>60%</span></div>
                        <span class="bar-label">Cluster C</span>
                    </div>
                </div>
            </div>

            <div class="stat-box">
                <h4>Disponibilité Stockage</h4>
                <div class="pie-wrapper">
                    <div class="pie-chart" style="--p:75; --c:#3b82f6;">
                        <span class="pie-value">75%</span>
                    </div>
                    <p class="pie-caption">Espace utilisé</p>
                </div>
            </div>

            <div class="stat-kpi-group">
                <div class="kpi-card">
                    <span class="kpi-num">142</span>
                    <span class="kpi-label">Réservations Actives</span>
                </div>
                <div class="kpi-card">
                    <span class="kpi-num">99.9%</span>
                    <span class="kpi-label">Uptime Service</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand">
                <h5>DataCore Manager</h5>
                <p>Solution professionnelle de gestion de Data Center.</p>
            </div>
            <div class="footer-links">
                <div class="link-col">
                    <h6>Navigation</h6>
                    <a href="#">Accueil</a>
                    <a href="#resources">Ressources</a>
                    <a href="#stats">Dashboard</a>
                </div>
                <div class="link-col">
                    <h6>Légal</h6>
                    <a href="#">Mentions légales</a>
                    <a href="#">Politique de confidentialité</a>
                </div>
                <div class="link-col">
                    <h6>Support</h6>
                    <a href="#">Documentation</a>
                    <a href="#">Contact IT</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 DataCore Manager. Tous droits réservés.</p>
            <p class="academic-note">Projet DataCenter – Laravel & MySQL</p>
        </div>
    </div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const indicators = document.querySelectorAll('.indicator');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    
    indicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            indicators.forEach(ind => ind.classList.remove('active'));
            this.classList.add('active');
            

            const slideIndex = parseInt(this.getAttribute('data-slide'));
            
            testimonialCards.forEach(card => {
                card.style.display = 'none';
                card.classList.remove('active');
            });
            
            if (testimonialCards[slideIndex]) {
                testimonialCards[slideIndex].style.display = 'block';
                testimonialCards[slideIndex].classList.add('active');
            }
        });
    });
    
    let currentSlide = 0;
    setInterval(() => {
        indicators[currentSlide].classList.remove('active');
        testimonialCards.forEach(card => {
            card.style.display = 'none';
            card.classList.remove('active');
        });
        
        currentSlide = (currentSlide + 1) % indicators.length;
        
        indicators[currentSlide].classList.add('active');
        testimonialCards[currentSlide].style.display = 'block';
        testimonialCards[currentSlide].classList.add('active');
    }, 5000);
});
</script>
 @if(session('registration_success'))
    <div id="registrationSuccessModal" class="reg-modal-overlay">
        <div class="reg-modal-card">
            <div class="reg-modal-icon">
                <svg viewBox="0 0 24 24" width="40" height="40" stroke="currentColor" stroke-width="3" fill="none"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h2>Bienvenue, {{ Auth::user()->name }} !</h2>
            <p>Votre compte <strong>DataCore Manager</strong> a été créé. Vous pouvez maintenant gérer vos ressources.</p>
            <button class="reg-modal-btn" onclick="closeRegModal()">Accéder à la plateforme</button>
        </div>
    </div>

    <style>
        .reg-modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.95); /* Très sombre pour bien voir le modal */
            backdrop-filter: blur(8px);
            display: flex; justify-content: center; align-items: center;
            z-index: 999999; /* Z-index extrêmement élevé */
            animation: fadeInModal 0.4s ease;
        }
        .reg-modal-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            text-align: center;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            animation: slideUpModal 0.5s ease;
        }
        .reg-modal-icon {
            width: 70px; height: 70px; background: #dcfce7; color: #10b981;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        .reg-modal-card h2 { color: #0f172a; margin-bottom: 15px; font-size: 1.8rem; }
        .reg-modal-card p { color: #64748b; margin-bottom: 25px; line-height: 1.6; }
        .reg-modal-btn {
            background: #3b82f6; color: white; border: none; padding: 15px 30px;
            border-radius: 12px; font-weight: 700; cursor: pointer; width: 100%;
            font-size: 1rem; transition: 0.3s;
        }
        .reg-modal-btn:hover { background: #2563eb; transform: scale(1.02); }

        @keyframes fadeInModal { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUpModal { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
        function closeRegModal() {
            document.getElementById('registrationSuccessModal').style.display = 'none';
        }
        // Fermer aussi si on clique à côté du card
        document.getElementById('registrationSuccessModal').addEventListener('click', function(e) {
            if(e.target === this) closeRegModal();
        });
    </script>
    @endif
</body>
</html>