<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Fiche Détail - {{ $resource->name }}</title>
</head>
<body class="container mt-5">
    @php
        // هاد السطر هو الساروت: كيفكك الـ JSON باش نجبدو المعلومات
        $specs = json_decode($resource->specifications, true);
    @endphp

    <div class="card shadow border-info">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0">🔍 Fiche détaillée : {{ $resource->name }}</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h5 class="text-primary">Informations Générales</h5>
                    <p><strong>Type :</strong> {{ $resource->type }}</p>
                    <p><strong>Status :</strong> 
                        <span class="badge {{ str_contains(strtolower($resource->status), 'disp') ? 'bg-success' : 'bg-warning' }}">
                            {{ $resource->status }}
                        </span>
                    </p>
                    <p><strong>Location :</strong> {{ $resource->location }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-primary">Spécifications Techniques</h5>
                    <p><strong>CPU :</strong> {{ $specs['cpu'] ?? 'Non défini' }}</p>
                    <p><strong>RAM :</strong> {{ $specs['ram'] ?? 'Non défini' }}</p>
                    <p><strong>OS :</strong> {{ $resource->os ?? 'Linux Ubuntu 22.04' }}</p>
                </div>
            </div>
            <hr>
            <h5 class="text-secondary">Historique des réservations</h5>
            <div class="alert alert-light border">
                📅 {{ date('d/m/Y', strtotime($resource->created_at ?? now())) }} : Installation initiale du système par l'équipe infrastructure.
            </div>
            <a href="/catalogue" class="btn btn-outline-primary mt-3">Retour au catalogue</a>
        </div>
    </div>
</body>
</html>
