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
    @guest
        <!-- 🔴 CAS 1 : VISITEUR (Non connecté) -->
        <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
    @else
        <!-- 🟢 CAS 2 : UTILISATEUR CONNECTÉ -->
        <div class="user-controls">
            <!-- Salutation (Optionnel, peut être masqué sur mobile via CSS) -->
            <!-- <span class="user-greeting">
                Bonjour, {{ Auth::user()->name }}
            </span> -->

            <!-- Bouton Mon Espace (Dashboard) -->
             <div class="user-container">
             <img src="{{ asset('images/user.png') }}" alt="user" class="user-icon">
            <a href="{{ route('dashboard') }}" class="btn-sm">
                Mon Espace
            </a>
             </div>
             @auth
    <div class="notification-bell" style="position: relative; margin-right: 20px; display: inline-block;">
        <a href="{{ route('dashboard') }}" style="color: #64748b; font-size: 1.2rem;">
            <i class="fa-solid fa-bell"></i>
            @if(Auth::user()->notifications()->where('is_read', false)->count() > 0)
                <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 0.6rem; padding: 2px 5px; border-radius: 50%; border: 2px solid white;">
                    {{ Auth::user()->notifications()->where('is_read', false)->count() }}
                </span>
            @endif
        </a>
    </div>
@endauth
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-primary btn-logout" title="Se déconnecter">
                   Deconnexion
                </button>
            </form>
        </div>
    @endguest
</div>
    </div>
</header>
