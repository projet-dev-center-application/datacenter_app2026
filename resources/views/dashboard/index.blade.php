<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Personnel | DataCore Manager</title>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS Principal -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    @include('partials.header')

    <div class="container" style="padding: 40px 0; min-height: 80vh; font-family: 'Inter', sans-serif;">
        
        <!-- HEADER DU DASHBOARD -->
        <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="color: #0f172a; font-size: 1.8rem;">Bienvenue, {{ Auth::user()->name }} 👋</h1>
                <p style="color: #64748b;">Gérez vos ressources et suivez vos demandes en temps réel.</p>
            </div>
            <div class="actions">
                <a href="{{ route('resources.index') }}" class="btn btn-primary" style="padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; background: #3b82f6; color: white;">
                    <i class="fa-solid fa-plus"></i> Nouvelle Réservation
                </a>
            </div>
        </div>

        <!-- GRILLE DES STATISTIQUES -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: white; padding: 25px; border-radius: 15px; border-left: 5px solid #3b82f6; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Réservations</span>
                <h2 style="margin: 10px 0 0; font-size: 2rem; color: #0f172a;">{{ $stats['total'] }}</h2>
            </div>
            <div style="background: white; padding: 25px; border-radius: 15px; border-left: 5px solid #f59e0b; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">En Attente</span>
                <h2 style="margin: 10px 0 0; font-size: 2rem; color: #0f172a;">{{ $stats['pending'] }}</h2>
            </div>
            <div style="background: white; padding: 25px; border-radius: 15px; border-left: 5px solid #10b981; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <span style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Approuvées</span>
                <h2 style="margin: 10px 0 0; font-size: 2rem; color: #0f172a;">{{ $stats['approved'] }}</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            
            <!-- COLONNE GAUCHE : RÉSERVATIONS ACTIVES -->
            <div class="main-dash">
                <section style="margin-bottom: 40px;">
                    <h3 style="margin-bottom: 20px; color: #0f172a;"><i class="fa-solid fa-list-check" style="color: #3b82f6;"></i> Vos demandes actives</h3>
                    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <th style="padding: 18px; color: #64748b; font-size: 0.85rem;">RESSOURCE</th>
                                    <th style="padding: 18px; color: #64748b; font-size: 0.85rem;">STATUT</th>
                                    <th style="padding: 18px; text-align: center; color: #64748b; font-size: 0.85rem;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeReservations as $res)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 18px;">
                                        <div style="font-weight: 700; color: #0f172a;">{{ $res->resource->name }}</div>
                                        <small style="color: #94a3b8;">{{ $res->resource->type }}</small>
                                    </td>
                                    <td style="padding: 18px;">
                                        <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; 
                                            @if($res->status == 'approved') background: #d1fae5; color: #065f46;
                                            @elseif($res->status == 'pending') background: #fef3c7; color: #92400e;
                                            @else background: #fee2e2; color: #991b1b; @endif">
                                            {{ $res->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 18px; text-align: center;">
                                        <a href="{{ route('reservations.show', $res->id) }}" style="color: #3b82f6; font-size: 1.1rem;"><i class="fa-solid fa-circle-info"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" style="padding: 40px; text-align: center; color: #94a3b8;">Aucune réservation active.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- COLONNE DROITE : NOTIFICATIONS & DISPONIBILITÉS -->
            <div class="sidebar-dash">
                
                <!-- BLOC NOTIFICATIONS RÉELLES -->
                <div class="card" style="background: white; padding: 25px; border-radius: 15px; margin-bottom: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <h4 style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; color: #0f172a;">
                        <span><i class="fa-solid fa-bell" style="color: #f59e0b;"></i> Dernières alertes</span>
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <a href="{{ route('notifications.markRead') }}" style="font-size: 0.7rem; color: #3b82f6; text-decoration: none; font-weight: 600;">Tout lire</a>
                        @endif
                    </h4>

                    <div class="notif-scroll" style="max-height: 300px; overflow-y: auto;">
                        @forelse(\App\Models\Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(8)->get() as $notif)
                            <div style="padding: 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 8px; border-radius: 8px; 
                                {{ $notif->is_read ? 'opacity: 0.6;' : 'background: #f0f7ff; border-left: 4px solid #3b82f6;' }}">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <strong style="font-size: 0.85rem; color: #0f172a;">{{ $notif->title }}</strong>
                                    <small style="font-size: 0.65rem; color: #94a3b8;">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</small>
                                </div>
                                <p style="font-size: 0.8rem; color: #475569; margin-top: 5px; line-height: 1.4;">
                                    {{ $notif->message }}
                                </p>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 20px; color: #94a3b8;">
                                <p style="font-size: 0.8rem;">Aucune nouvelle notification.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- BLOC DISPONIBILITÉS -->
                <div style="background: #0f172a; color: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <h4 style="margin-bottom: 20px; color: #3b82f6;"><i class="fa-solid fa-bolt"></i> Dispo. immédiate</h4>
                    @foreach($availableResources as $avail)
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 10px;">
                            <span style="font-size: 0.85rem; font-weight: 500;">{{ $avail->name }}</span>
                            <a href="{{ route('reservations.create', $avail->id) }}" style="color: #3b82f6; text-decoration: none; font-size: 0.75rem; font-weight: 700; border: 1px solid #3b82f6; padding: 4px 8px; border-radius: 5px;">RÉSERVER</a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    @include('partials.footer')
</body>
</html>