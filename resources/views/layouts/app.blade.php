<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DataCore Manager - Gestion professionnelle des ressources de Data Center">
    <title>@yield('title', 'DataCore Manager')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="site-header">
    <div class="container header-container">
        <div class="logo">
           <img src="{{ asset('images/icons8-serveur.gif') }}" alt="datacore_logo" class="logo1">
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

<!-- CHANGEMENT ICI : "Réservations" devient "Mes Réservations" quand connecté -->
<li>
    @auth
        <a href="{{ route('reservations.index') }}"
           class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
            Mes Réservations
        </a>
    @else
        <a href="{{ route('login') }}">
            Réservations
        </a>
    @endauth
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
            <!-- AJOUTEZ CE CODE POUR LE MENU UTILISATEUR -->
            @auth
                <!-- Menu utilisateur connecté -->
                <div class="user-menu">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <div class="user-dropdown">
                        <a href="{{ route('dashboard') }}" class="dropdown-item">👤 Mon Espace</a>
                        <a href="{{ route('reservations.index') }}" class="dropdown-item">📋 Mes Réservations</a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">⚙️ Mon Profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">🚪 Déconnexion</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Boutons pour visiteurs (votre code original) -->
                <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
            @endauth
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <!-- ... votre footer existant ... -->
</footer>

<!-- AJOUTEZ CE SCRIPT POUR LE MENU DÉROULANT -->
<script>
// Menu utilisateur déroulant
document.addEventListener('DOMContentLoaded', function() {
    const userMenu = document.querySelector('.user-menu');
    if (userMenu) {
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.querySelector('.user-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        
        // Fermer le menu en cliquant ailleurs
        document.addEventListener('click', function() {
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        });
    }
    
    // Votre code de carousel existant reste ici
    const indicators = document.querySelectorAll('.indicator');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    
    if (indicators.length > 0) {
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
    }
});
</script>
</body>
</html>