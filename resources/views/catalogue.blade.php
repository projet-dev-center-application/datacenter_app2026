<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Catalogue Datacenter</title>
    <style>
        .catalogue{
            width: 40%;
            header:40%
        }
    </style>
</head>
<body class="container mt-5">
    <h1 class="mb-4 text-primary"><img src="../images/data-center.png" alt="" class="catalogue"> Catalogue des Ressources Datacenter</h1>

    <form action="/catalogue" method="GET" class="mb-4 d-flex bg-light p-3 border rounded shadow-sm">
        <input type="text" name="search" class="form-control me-2" placeholder="Rechercher un serveur ou un type..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <a href="/catalogue" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
    </form>

    <table class="table table-striped table-hover shadow">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Statut</th>
                <th>CPU / RAM</th>
                <th>Emplacement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
                @php
                    $specs = json_decode($resource->specifications, true);
                    $status = strtolower($resource->status);
                @endphp
                <tr>
                    <td class="fw-bold">{{ $resource->name }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $resource->type ?? 'Non défini' }}
                        </span>
                    </td>
                    <td>
                        @php
                            $status = mb_strtolower($resource->status); 
                            $badgeClass = 'bg-secondary'; 

                            if (str_contains($status, 'disponible') || str_contains($status, 'available')) {
                                $badgeClass = 'bg-success';
                            } elseif (str_contains($status, 'maintenance')) {
                                $badgeClass = 'bg-danger';
                            } elseif (str_contains($status, 'réservé') || str_contains($status, 'reserved')) {
                                $badgeClass = 'bg-warning text-dark';
                            }
                        @endphp
                        
                        <span class="badge {{ $badgeClass }}">
                            {{ $resource->status }}
                        </span>
                    </td>
                    <td>{{ $specs['cpu'] ?? 'N/A' }} / {{ $specs['ram'] ?? 'N/A' }}</td>
                    <td>{{ $resource->location }}</td>
                    <td>
                        <a href="{{ url('/resources/show/' . $resource->id) }}" class="btn btn-sm btn-info text-white">Voir</a>
                        <a href="{{ url('/resources/edit/' . $resource->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="{{ url('/resources/delete/' . $resource->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette ressource ?')">Supprimer</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-5">

    <h3 class="mb-4">Ajouter une nouvelle ressource</h3>
    <form action="/resources/store" method="POST" class="row g-3 p-4 bg-light border rounded shadow-sm">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" placeholder="ex: SRV-02" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="server">Serveur Physique</option>
                <option value="vm">Machine Virtuelle</option>
                <option value="storage">Stockage</option>
                <option value="network">Équipement Réseau</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select">
                <option value="available">Disponible</option>
                <option value="maintenance">Maintenance</option>
                <option value="reserved">Réservé</option>
                <option value="in_use">En usage</option>
                <option value="out_of_service">Hors service</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">CPU</label>
            <input type="text" name="cpu" class="form-control" placeholder="ex: 8 Cores">
        </div>
        <div class="col-md-3">
            <label class="form-label">RAM</label>
            <input type="text" name="ram" class="form-control" placeholder="ex: 16GB">
        </div>
        <div class="col-md-6">
            <label class="form-label">Emplacement</label>
            <input type="text" name="location" class="form-control" placeholder="ex: Rack A-01" required>
        </div>
        
        <!-- Champs cachés pour les autres spécifications -->
        <input type="hidden" name="specifications_json" id="specifications_json">
        
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-success w-100 py-2">Enregistrer la ressource</button>
        </div>
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const cpu = document.querySelector('input[name="cpu"]').value;
            const ram = document.querySelector('input[name="ram"]').value;
            
            const specs = {
                cpu: cpu || 'N/A',
                ram: ram || 'N/A'
            };
            
            document.getElementById('specifications_json').value = JSON.stringify(specs);
        });
    </script>
</body>
</html>