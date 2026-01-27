<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DataCore | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <img src="{{ asset('images/icons8-serveur.gif') }}" alt="Logo" style="width: 39px; height: 39px;">
                <span>DataCore Manager</span>
            </div>
           
        </div>
        <nav>
            <a href="{{ route('admin.index') }}" class="nav-item active">Tableau de bord</a>
            <a href="#" class="nav-item">Gestion Utilisateurs</a>
            <a href="{{ route('resources.index') }}" class="nav-item">Catalogue Ressources</a>
            <a href="#" class="nav-item">Maintenances</a>
            <a href="#" class="nav-item">Statistiques Globales</a>
        </nav>
        
        <div style="margin-top: auto;">
             <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer;">
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="header">
            <div class="welcome-text">
                <h1>Console Administrateur</h1>
                <p style="color:var(--text-muted)">Visualisation en temps réel de votre infrastructure.</p>
            </div>
            <div style="display:flex; align-items:center; gap:15px;">
                <div style="text-align:right;">
                    <div style="font-weight:700;">Admin</div>
                    <small style="color:var(--text-muted)">Super Administrateur</small>
                </div>
                <div style="width:45px; height:45px; background:var(--deep-navy); border-radius:12px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
                    AD
                </div>
            </div>
        </header>

        <div class="stats-grid">
            <div class="card">
                <div class="card-label">Utilisateurs</div>
                <div class="card-value">{{ $totalUsers }}</div>
            </div>
            <div class="card">
                <div class="card-label">Ressources IT</div>
                <div class="card-value">{{ $totalResources }}</div>
            </div>
            <div class="card">
                <div class="card-label">Taux d'Occupation</div>
                <div class="card-value" style="color:var(--primary-blue)">{{ $occupationRate }}%</div>
            </div>
            <div class="card">
                <div class="card-label">Uptime Global</div>
                <div class="card-value" style="color:var(--success)">99.9%</div>
            </div>
        </div>

        <div class="dashboard-row">
            <div class="section-box">
                <h3 style="margin-bottom: 20px;">Volume des Réservations (7j)</h3>
                <div class="chart-container">
                    @foreach($chartData as $data)
                    <div class="bar-group">
                        <div class="bar" style="height: {{ $data['value'] }}%;"></div>
                        <span class="bar-label">{{ $data['day'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="section-box">
                <h3>Répartition Ressources</h3>
                <div style="margin-top:20px;">
                    @foreach($resourceStats as $stat)
                    <div style="margin-bottom:18px;">
                        <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:6px;">
                            <span style="font-weight:500;">{{ $stat->type }}</span>
                            <strong>{{ $stat->total }}</strong>
                        </div>
                        <div style="height:8px; background:#f1f5f9; border-radius:10px;">
                            <div style="width:{{ ($stat->total / $totalResources) * 100 }}%; height:100%; background:var(--deep-navy); border-radius:10px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="section-box">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3>Utilisateurs Récemment Inscrits</h3>
                <button class="btn">Exporter la liste</button>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>NOM COMPLET</th>
                        <th>EMAIL PROFESSIONNEL</th>
                        <th>DÉPARTEMENT</th>
                        <th>RÔLE</th>
                        <th>STATUT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td style="font-weight:600;">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->department ?? 'Infrastructure' }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td><span class="badge badge-success">Compte Actif</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>