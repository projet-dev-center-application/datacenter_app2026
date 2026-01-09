
</html><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modifier - {{ $resource->name }}</title>
</head>
<body class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h2 class="mb-0">Modifier la ressource : {{ $resource->name }}</h2>
        </div>
        <div class="card-body">
            <form action="/resources/update/{{ $resource->id }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nom de la ressource</label>
                    <input type="text" name="name" value="{{ $resource->name }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="Serveur Physique" {{ $resource->type == 'Serveur Physique' ? 'selected' : '' }}>Serveur Physique</option>
                        <option value="Machine Virtuelle" {{ $resource->type == 'Machine Virtuelle' ? 'selected' : '' }}>Machine Virtuelle</option>
                        <option value="Stockage" {{ $resource->type == 'Stockage' ? 'selected' : '' }}>Stockage</option>
                        <option value="Réseau" {{ $resource->type == 'Réseau' ? 'selected' : '' }}>Réseau</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="Disponible" {{ $resource->status == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Maintenance" {{ $resource->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Réservé" {{ $resource->status == 'Réservé' ? 'selected' : '' }}>Réservé</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location (Emplacement)</label>
                    <input type="text" name="location" value="{{ $resource->location }}" class="form-control" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning fw-bold">Enregistrer les modifications</button>
                    <a href="/catalogue" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
