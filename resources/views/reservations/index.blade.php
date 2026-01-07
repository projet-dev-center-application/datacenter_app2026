<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - Data Center</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        h1 {
            color: #333;
            font-size: 28px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group select,
        .form-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .reservations-grid {
            display: grid;
            gap: 20px;
        }

        .reservation-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .reservation-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .resource-name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .resource-type {
            font-size: 13px;
            color: #666;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-primary { background: #cce5ff; color: #004085; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }

        .reservation-dates {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .date-info {
            display: flex;
            flex-direction: column;
        }

        .date-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .date-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .reservation-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .created-at {
            font-size: 12px;
            color: #999;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 10px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Mes Réservations</h1>
            <a href="/reservations/create" class="btn btn-primary">+ Nouvelle Réservation</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        <div class="filters">
            <form method="GET" action="/reservations">
                <div class="form-group">
                    <label>Statut</label>
                    <select name="statut">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('statut') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('statut') == 'approved' ? 'selected' : '' }}>Approuvée</option>
                        <option value="rejected" {{ request('statut') == 'rejected' ? 'selected' : '' }}>Refusée</option>
                        <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('statut') == 'completed' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ressource</label>
                    <select name="resource_id">
                        <option value="">Toutes</option>
                        @foreach($resources as $resource)
                            <option value="{{ $resource->id }}" {{ request('resource_id') == $resource->id ? 'selected' : '' }}>
                                {{ $resource->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Date début</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </form>
        </div>

        <div class="reservations-grid">
            @forelse($reservations as $reservation)
                <div class="reservation-card">
                    <div class="reservation-header">
                        <div>
                            <div class="resource-name">{{ $reservation->resource->nom }}</div>
                            <div class="resource-type">{{ $reservation->resource->type }}</div>
                        </div>
                        <span class="badge badge-{{ 
                            $reservation->statut == 'pending' ? 'warning' : 
                            ($reservation->statut == 'approved' ? 'success' : 
                            ($reservation->statut == 'rejected' ? 'danger' : 
                            ($reservation->statut == 'active' ? 'primary' : 'secondary'))) 
                        }}">
                            {{ $reservation->getStatusText() }}
                        </span>
                    </div>

                    <div class="reservation-dates">
                        <div class="date-info">
                            <span class="date-label">Date début</span>
                            <span class="date-value">{{ $reservation->date_debut->format('d/m/Y') }}</span>
                        </div>
                        <div class="date-info">
                            <span class="date-label">Date fin</span>
                            <span class="date-value">{{ $reservation->date_fin->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="reservation-footer">
                        <span class="created-at">Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</span>
                        <div class="actions">
                            <a href="/reservations/{{ $reservation->id }}" class="btn btn-sm btn-secondary">Détails</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <h3>Aucune réservation trouvée</h3>
                    <p>Commencez par créer votre première réservation !</p>
                    <a href="/reservations/create" class="btn btn-primary" style="margin-top: 20px;">Créer une réservation</a>
                </div>
            @endforelse
        </div>

        @if($reservations->hasPages())
            <div class="pagination">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</body>
</html>
