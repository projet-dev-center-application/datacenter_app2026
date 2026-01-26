@extends('layouts.app') <!-- Ou incluez votre header/footer habituel -->

@section('content')
<div class="container" style="padding: 40px 0;">
    
    <!-- HEADER DASHBOARD -->
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1>Bienvenue, {{ Auth::user()->name }} 👋</h1>
            <p style="color: #64748b;">Gérez vos ressources et suivez vos demandes en temps réel.</p>
        </div>
        <div class="actions">
            <a href="{{ route('resources.index') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Nouvelle Réservation
            </a>
            <button class="btn btn-danger-outline" title="Signaler un incident">
                <i class="fa-solid fa-circle-exclamation"></i>
            </button>
        </div>
    </div>

    <!-- GRILLE STATISTIQUES -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div class="card-stat" style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #3b82f6; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.9rem;">Total Réservations</span>
            <h2 style="margin: 5px 0;">{{ $stats['total'] }}</h2>
        </div>
        <div class="card-stat" style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #f59e0b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.9rem;">En Attente</span>
            <h2 style="margin: 5px 0;">{{ $stats['pending'] }}</h2>
        </div>
        <div class="card-stat" style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.9rem;">Approuvées</span>
            <h2 style="margin: 5px 0;">{{ $stats['approved'] }}</h2>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <!-- COLONNE GAUCHE : SUIVI & HISTORIQUE -->
        <div class="main-dash">
            
            <!-- 1. Demandes Actives -->
            <section style="margin-bottom: 40px;">
                <h3 style="margin-bottom: 15px;"><i class="fa-solid fa-clock-rotate-left"></i> Demandes en cours</h3>
                <div class="card" style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8fafc; text-align: left;">
                            <tr>
                                <th style="padding: 15px;">Ressource</th>
                                <th style="padding: 15px;">Période</th>
                                <th style="padding: 15px;">Statut</th>
                                <th style="padding: 15px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeReservations as $res)
                            <tr style="border-top: 1px solid #e2e8f0;">
                                <td style="padding: 15px;"><strong>{{ $res->resource->name }}</strong></td>
                                <td style="padding: 15px; font-size: 0.85rem;">Du {{ $res->start_date->format('d/m') }} au {{ $res->end_date->format('d/m') }}</td>
                                <td style="padding: 15px;">
                                    <span class="badge-status {{ $res->status }}" style="padding: 5px 10px; border-radius: 20px; font-size: 0.75rem;">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td style="padding: 15px;">
                                    <a href="{{ route('reservations.show', $res->id) }}" class="btn-text" style="color: #3b82f6;"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">Aucune demande active.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 2. Historique avec Filtres -->
            <section>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3><i class="fa-solid fa-history"></i> Historique Complet</h3>
                    <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 10px;">
                        <select name="status" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                            <option value="">Tous les statuts</option>
                            <option value="finished">Terminée</option>
                            <option value="rejected">Refusée</option>
                        </select>
                        <button type="submit" class="btn btn-outline" style="padding: 5px 10px;">Filtrer</button>
                    </form>
                </div>
                <!-- Liste historique ici... (similaire au tableau ci-dessus) -->
            </section>
        </div>

        <!-- COLONNE DROITE : NOTIFICATIONS & RESSOURCES -->
        <div class="sidebar-dash">
            
            <!-- Notifications -->
            <div class="card" style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-bell" style="color: #f59e0b;"></i> Notifications</h4>
                <div class="notif-list">
                    <!-- Exemple statique, à boucler si vous avez une table notifications -->
                    <div style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem;">
                        <p style="margin: 0;"><strong>Approbation :</strong> Votre demande pour le Serveur Oracle a été validée.</p>
                        <small style="color: #94a3b8;">Il y a 2 heures</small>
                    </div>
                </div>
            </div>

            <!-- Ressources Disponibles (Mini Filtre) -->
            <div class="card" style="background: #0f172a; color: white; padding: 20px; border-radius: 12px;">
                <h4 style="margin-bottom: 15px;">🚀 Dispo. immédiate</h4>
                @foreach($availableResources as $avail)
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 8px;">
                    <span style="font-size: 0.85rem;">{{ $avail->name }}</span>
                    <a href="{{ route('reservations.create', $avail->id) }}" style="color: #3b82f6; font-size: 0.8rem;">Réserver</a>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<style>
    .badge-status.pending { background: #fef3c7; color: #92400e; }
    .badge-status.approved { background: #d1fae5; color: #065f46; }
    .badge-status.rejected { background: #fee2e2; color: #991b1b; }
    .badge-status.finished { background: #f1f5f9; color: #475569; }
</style>
@endsection