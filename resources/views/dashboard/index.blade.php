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
    @include('partials.header')

    <div class="container" style="padding: 40px 0; min-height: 80vh;">
        <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1>Bienvenue, {{ Auth::user()->name }} 👋</h1>
                <p style="color: #64748b;">Gérez vos ressources et suivez vos demandes en temps réel.</p>
            </div>
            <div class="actions" style="display: flex; gap: 10px;">
                <a href="{{ route('resources.index') }}" class="btn btn-primary">Nouvelle Réservation</a>
            </div>
        </div>

        <!-- STATS -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #3b82f6;">
                <span style="color: #64748b;">Total Réservations</span>
                <h2>{{ $stats['total'] }}</h2>
            </div>
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #f59e0b;">
                <span style="color: #64748b;">En Attente</span>
                <h2>{{ $stats['pending'] }}</h2>
            </div>
            <div style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #10b981;">
                <span style="color: #64748b;">Approuvées</span>
                <h2>{{ $stats['approved'] }}</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <div class="main-dash">
                <section style="margin-bottom: 40px;">
                    <h3>Vos demandes actives</h3>
                    <table style="width: 100%; background: white; border-radius: 12px; margin-top: 15px;">
                        @forelse($activeReservations as $res)
                        <tr>
                            <td style="padding: 15px;">{{ $res->resource->name }}</td>
                            <td>{{ $res->status }}</td>
                            <td><a href="{{ route('reservations.show', $res->id) }}">Voir</a></td>
                        </tr>
                        @empty
                        <tr><td style="padding: 20px;">Aucune réservation.</td></tr>
                        @endforelse
                    </table>
                </section>
            </div>

            <div class="sidebar-dash">
                <div style="background: #1e293b; color: white; padding: 20px; border-radius: 12px;">
                    <h4>🚀 Dispo. immédiate</h4>
                    @foreach($availableResources as $avail)
                        <p>{{ $avail->name }} - <a href="{{ route('reservations.create', $avail->id) }}">Réserver</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>