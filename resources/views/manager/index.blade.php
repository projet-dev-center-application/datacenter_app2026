<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console Responsable | DataCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <img src="{{ asset('images/icons8-serveur.gif') }}" alt="Logo" style="width: 39px; height: 39px;">
                <span> DataCore Manager</span>
            </div>
           
        </div>
        <nav>
            <a href="#" class="nav-item active">Validation Demandes</a>
            <a href="#" class="nav-item">Mes Ressources</a>
            <a href="#" class="nav-item">Alertes & Incidents</a>
            <a href="#" class="nav-item">Planning Maintenance</a>
        </nav>
        <div style="margin-top:auto">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="nav-item" style="background:none; border:none; color:white; cursor:pointer;">Déconnexion</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="header">
            <div class="welcome-text">
                <h1>Espace Responsable Technique</h1>
                <p style="color:var(--text-muted)">Gestion des approbations et supervision du parc.</p>
            </div>
            <div class="header-user" style="display:flex; align-items:center; gap:10px;">
                <div style="text-align:right">
                    <div style="font-weight:700;">{{ Auth::user()->name }}</div>
                </div>
                <div style="width:45px; height:45px; background:#10b981; border-radius:12px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">RT</div>
            </div>
        </header>

        <div class="stats-grid">
            <div class="card">
                <div class="card-label">À Valider</div>
                <div class="card-value" style="color:var(--primary-blue)">{{ $managerStats['to_review'] }}</div>
            </div>
            <div class="card">
                <div class="card-label">Ressources Supervisées</div>
                <div class="card-value">{{ $managerStats['total_managed'] }}</div>
            </div>
            <div class="card">
                <div class="card-label">Sessions Actives</div>
                <div class="card-value" style="color:var(--success)">{{ $managerStats['active_now'] }}</div>
            </div>
        </div>

        <div class="section-box">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3>Demandes de réservation en attente</h3>
                <span style="font-size:0.8rem; color:var(--text-muted)">Action requise</span>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>UTILISATEUR</th>
                        <th>RESSOURCE</th>
                        <th>PÉRIODE</th>
                        <th>MOTIF</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingDemands as $demand)
                    <tr>
                        <td><strong>{{ $demand->user->name }}</strong></td>
                        <td>{{ $demand->resource->name }}</td>
                        <td>{{ $demand->start_date->format('d/m H:i') }}</td>
                        <td>{{ Str::limit($demand->purpose, 30) }}</td>
                        <td style="display:flex; gap:10px;">
                            <form action="{{ route('reservations.approve', $demand->id) }}" method="POST">
                                @csrf
                                <button class="btn" style="background:var(--success); padding:5px 10px;">Approuver</button>
                            </form>
                            <form action="{{ route('reservations.reject', $demand->id) }}" method="POST">
                                @csrf
                                <button class="btn" style="background:var(--danger); padding:5px 10px;">Refuser</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center; padding:30px; color:var(--text-muted)">Aucune demande en attente de validation.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

       
        <div class="section-box" style="margin-top:25px;">
            <h3>Supervision de l'état des ressources</h3>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-top:15px;">
                <div style="padding:15px; border:1px solid #f1f5f9; border-radius:10px;">
                    <div style="font-weight:600; margin-bottom:5px;">Maintenance</div>
                    <p style="font-size:0.8rem; color:var(--text-muted)">Passer une ressource en mode maintenance planifiée.</p>
                    <button class="btn" style="margin-top:10px; width:100%; background:var(--deep-navy)">Gérer le parc</button>
                </div>
                <div style="padding:15px; border:1px solid #f1f5f9; border-radius:10px;">
                    <div style="font-weight:600; margin-bottom:5px;">Modération</div>
                    <p style="font-size:0.8rem; color:var(--text-muted)">Consulter les alertes et les signalements d'incidents.</p>
                    <button class="btn" style="margin-top:10px; width:100%; background:var(--primary-blue)">Voir les tickets</button>
                </div>
            </div>
        </div>
    </main>

</body>
</html>