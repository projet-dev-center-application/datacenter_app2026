<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue | DataCore Manager</title>
    
    <!-- ON GARDE TON CSS PRINCIPAL -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-container">
            <div class="logo">
                <img src="{{ asset('images/icons8-serveur.gif') }}" alt="logo" class="logo1" style="width:30px;">
                <span>DataCore Manager</span>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('resources.index') }}" class="active">Ressources</a></li>
                    <li><a href="{{ route('reservations.index') }}">Réservations</a></li>
                    <li><a href="#contact">Contact</a></li>
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
             <img src="../images/user.png" alt="user" class="user-icon">
            <a href="{{ route('dashboard') }}" class="btn-sm">
                Mon Espace
            </a>
             </div>
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

    <!-- =========================
         2. BANNIÈRE TITRE
         ========================= -->
    <section class="page-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: white; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1>Catalogue des Ressources</h1>
            <p style="color: #cbd5e1; margin-top: 10px;">Explorez et réservez les équipements disponibles en temps réel.</p>
        </div>
    </section>

    <!-- =========================
         3. BARRE DE RECHERCHE
         ========================= -->
    <div class="container" style="margin-top: -30px; position: relative; z-index: 10; margin-bottom: 50px;">
        <form action="{{ route('resources.index') }}" method="GET" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; gap: 10px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher (ex: Serveur Oracle, Switch...)" style="flex: 1; padding: 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 1rem;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Filtrer</button>
        </form>
    </div>

    <!-- =========================
         4. GRILLE DES RESSOURCES
         ========================= -->
    <main class="main-content" style="padding-bottom: 80px;">
        <div class="container">
            
            @if($resources->isEmpty())
                <div style="text-align: center; padding: 50px; color: #64748b;">
                    <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 10px;"></i>
                    <h3>Aucune ressource trouvée.</h3>
                </div>
            @else
                
                <div class="resource-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                    
                    @foreach($resources as $resource)
                    <article class="resource-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; transition: transform 0.3s;">
                        
                        <!-- IMAGE & BADGE -->
                        <div class="card-image-wrapper" style="position: relative; height: 200px; overflow: hidden;">
                            @php
                                // Logique Image par défaut si vide en BDD
                                $img = $resource->image_url;
                                if(empty($img)) {
                                    $img = match($resource->type) {
                                        'Serveur' => 'https://images.unsplash.com/photo-1558494949-ef526b0042a0?w=800&q=80',
                                        'Stockage' => 'https://images.unsplash.com/photo-1531749668029-2db88e4276c7?w=800&q=80',
                                        'Réseau' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&q=80',
                                        default => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&q=80'
                                    };
                                }
                            @endphp
                            
                            <img src="{{ $img }}" alt="{{ $resource->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            
                            <!-- Badge Statut -->
                            <span class="status-badge" style="position: absolute; top: 15px; right: 15px; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; background: rgba(255,255,255,0.9); backdrop-filter: blur(4px);">
                                @if($resource->status === 'available')
                                    <span style="color: #10b981;">🟢 Disponible</span>
                                @elseif($resource->status === 'maintenance')
                                    <span style="color: #ef4444;">🔴 Maintenance</span>
                                @else
                                    <span style="color: #f59e0b;">🟠 Occupé</span>
                                @endif
                            </span>
                        </div>

                        <!-- CONTENU CARTE -->
                        <div class="card-body" style="padding: 20px;padding-top:103px">
                            <div class="card-top" style="margin-bottom: 10px;">
                                <span style="color: #0ea5e9; font-size: 0.8rem; text-transform: uppercase; font-weight: 700;">{{ $resource->type }}</span>
                                <h3 style="margin: 5px 0; font-size: 1.2rem; color: #0f172a;">{{ $resource->name }}</h3>
                            </div>
                            
                            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px; min-height: 40px;">
                                {{ Str::limit($resource->description, 80) }}
                            </p>
                            
                            <div class="meta-info" style="background: #f8fafc; padding: 10px; border-radius: 6px; font-size: 0.85rem; color: #475569; display: flex; justify-content: space-between; margin-bottom: 20px;">
                                <span><i class="fa-solid fa-location-dot"></i> {{ $resource->location ?? 'N/A' }}</span>
                                <span><i class="fa-solid fa-hashtag"></i> ID: {{ $resource->id }}</span>
                            </div>
                            
                            <div class="card-actions" style="display: flex; gap: 10px;">
                                <!-- Bouton Détails -->
                                <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-outline" style="flex: 1; padding: 8px; font-size: 0.9rem;">Détails</a>
                                
                                <!-- Bouton Réserver (Actif seulement si dispo) -->
                                @if($resource->status === 'available')
                                    <a href="{{ route('reservations.create', $resource->id) }}" class="btn btn-primary" style="flex: 1; padding: 8px; font-size: 0.9rem;">Réserver</a>
                                @else
                                    <button disabled class="btn" style="flex: 1; background: #e2e8f0; color: #94a3b8; cursor: not-allowed; border: 1px solid #cbd5e1; padding: 8px; font-size: 0.9rem;">Indisponible</button>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach

                </div>
            @endif
        </div>
    </main>

    <!-- =========================
         5. FOOTER (Identique Accueil)
         ========================= -->
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
                        <a href="{{ route('home') }}">Accueil</a>
                        <a href="{{ route('resources.index') }}">Catalogue</a>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </div>
                    <div class="link-col">
                        <h6>Légal</h6>
                        <a href="#">Mentions légales</a>
                        <a href="#">Politique de confidentialité</a>
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