<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Personnel | DataCore Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- On utilise vos partials comme dans vos autres pages -->
    @include('partials.header')

    <div class="container" style="padding: 40px 0; min-height: 80vh;">
        
        <!-- HEADER DASHBOARD -->
        <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1>Bienvenue, {{ Auth::user()->name }} 👋</h1>
                <p style="color: #64748b;">Gérez vos ressources et suivez vos demandes en temps réel.</p>
            </div>
            <div class="actions" style="display: flex; gap: 10px;">
                <a href="{{ route('resources.index') }}" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none; border-radius: 6px;">
                    <i class="fa-solid fa-plus"></i> Nouvelle Réservation
                </a>
                <button class="btn btn-outline" style="padding: 10px; border: 1px solid #ef4444; color: #ef4444; border-radius: 6px; cursor: pointer;" title="Signaler un incident">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </button>
            </div>
        </div>

        <!-- GRILLE STATISTIQUES -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #3b82f6; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.9rem;">Total Réservations</span>
                <h2 style="margin: 5px 0;">{{ $stats['total'] }}</h2>
            </div>
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #f59e0b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.9rem;">En Attente</span>
                <h2 style="margin: 5px 0;">{{ $stats['pending'] }}</h2>
            </div>
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.9rem;">Approuvées</span>
                <h2 style="margin: 5px 0;">{{ $stats['approved'] }}</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            
            <!-- COLONNE GAUCHE : SUIVI & HISTORIQUE -->
            <div class="main-dash">
                <!-- 1. Demandes Actives -->
                <section style="margin-bottom: 40px;">
                    <h3 style="margin-bottom: 15px;"><i class="fa-solid fa-clock-rotate-left"></i> Vos demandes actives</h3>
                    <div style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f8fafc; text-align: left;">
                                <tr>
                                    <th style="padding: 15px; border-bottom: 1px solid #e2e8f0;">Ressource</th>
                                    <th style="padding: 15px; border-bottom: 1px solid #e2e8f0;">Période</th>
                                    <th style="padding: 15px; border-bottom: 1px solid #e2e8f0;">Statut</th>
                                    <th style="padding: 15px; border-bottom: 1px solid #e2e8f0;">Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeReservations as $res)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 15px;"><strong>{{ $res->resource->name }}</strong></td>
                                    <td style="padding: 15px; font-size: 0.85rem;">{{ $res->start_date->format('d/m/y') }} → {{ $res->end_date->format('d/m/y') }}</td>
                                    <td style="padding: 15px;">
                                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; background: #fef3c7; color: #92400e;">
                                            {{ $res->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px;">
                                        <a href="{{ route('reservations.show', $res->id) }}" style="color: #3b82f6;"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">Aucune réservation active.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- 2. Historique complet -->
                <section>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3><i class="fa-solid fa-history"></i> Historique Complet</h3>
                    </div>
                    
                    <div style="background: white; border-radius: 12px; padding: 15px; border: 1px solid #e2e8f0;">
                        @foreach($history as $h)
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <div style="font-weight: 600;">{{ $h->resource->name }}</div>
                                    <small style="color: #64748b;">{{ $h->created_at->format('d M Y') }} - {{ $h->purpose }}</small>
                                </div>
                                <div>
                                    <span style="font-size: 0.8rem; color: #64748b;">{{ $h->status }}</span>
                                </div>
                            </div>
                        @endforeach
                        <div style="margin-top: 15px;">
                            {{ $history->links() }}
                        </div>
                    </div>
                </section>
            </div>

            <!-- COLONNE DROITE : SIDEBAR -->
            <div class="sidebar-dash">
                <!-- Notifications Simmulées -->
                <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
                    <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-bell" style="color: #f59e0b;"></i> Dernières alertes</h4>
                    <div style="font-size: 0.85rem; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        Votre demande pour le serveur HP a été créée.
                    </div>
                    <div style="font-size: 0.85rem; padding: 10px 0;">
                        Bienvenue sur votre nouvel espace DataCore !
                    </div>
                </div>

                <!-- Ressources Dispos -->
                <div style="background: #1e293b; color: white; padding: 20px; border-radius: 12px;">
                    <h4 style="margin-bottom: 15px;">🚀 Dispo. immédiate</h4>
                    @foreach($availableResources as $avail)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.85rem; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 6px;">
                            <span>{{ $avail->name }}</span>
                            <a href="{{ route('reservations.create', $avail->id) }}" style="color: #3b82f6; text-decoration: none;">Réserver</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>