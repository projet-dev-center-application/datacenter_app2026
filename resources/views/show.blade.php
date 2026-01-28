<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails {{ $resource->name }} | DataCore Manager</title>
    
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .details-page { padding: 60px 0; background: #f8fafc; min-height: 90vh; }
        
        /* Bouton Retour */
        .back-nav { margin-bottom: 30px; }
        .btn-back { text-decoration: none; color: #64748b; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { color: #3b82f6; transform: translateX(-5px); }

        /* Conteneur Principal */
        .resource-detail-card {
            background: white; border-radius: 24px; overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;
            display: grid; grid-template-columns: 1fr 1.5fr;
        }

        /* Colonne Gauche : Image & Status */
        .resource-visual { background: #0f172a; padding: 40px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; position: relative; }
        .resource-icon-lg { font-size: 5rem; color: #3b82f6; margin-bottom: 20px; filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.4)); }
        
        .status-indicator {
            position: absolute; top: 20px; left: 20px; padding: 8px 16px;
            border-radius: 12px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
            background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
        }

        /* Colonne Droite : Infos */
        .resource-info-content { padding: 50px; }
        .res-type { color: #3b82f6; text-transform: uppercase; font-weight: 700; font-size: 0.8rem; letter-spacing: 1px; }
        .res-title { font-size: 2.2rem; color: #0f172a; margin: 10px 0 20px; font-weight: 800; }
        .res-description { color: #64748b; line-height: 1.7; margin-bottom: 30px; }

        /* Grille des Spécifications */
        .specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .spec-item { background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #f1f5f9; }
        .spec-label { display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 5px; }
        .spec-value { font-weight: 600; color: #1e293b; font-size: 1rem; }

        /* Actions */
        .action-bar { display: flex; gap: 15px; align-items: center; padding-top: 30px; border-top: 1px solid #f1f5f9; }
        .btn-reserve { background: #3b82f6; color: white; text-decoration: none; padding: 15px 35px; border-radius: 12px; font-weight: 700; transition: 0.3s; flex: 1; text-align: center; }
        .btn-reserve:hover { background: #1e40af; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2); }
        .btn-reserve.disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; transform: none; box-shadow: none; }

        /* Timeline Historique */
        .history-section { margin-top: 50px; }
        .history-item { border-left: 2px solid #e2e8f0; padding-left: 20px; position: relative; padding-bottom: 20px; }
        .history-item::before { content: ''; position: absolute; left: -7px; top: 0; width: 12px; height: 12px; background: #3b82f6; border-radius: 50%; }
        .history-date { font-size: 0.8rem; color: #94a3b8; }
    </style>
</head>
<body>

    @include('partials.header')

    <main class="details-page">
        <div class="container">
            
            <div class="back-nav">
                <a href="{{ route('resources.index') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
                </a>
            </div>

            <div class="resource-detail-card">
                <!-- Visuel -->
                <div class="resource-visual">
                    <div class="status-indicator">
                        @if($resource->status === 'available')
                            <span style="color: #10b981;">● Disponible</span>
                        @elseif($resource->status === 'maintenance')
                            <span style="color: #ef4444;">● Maintenance</span>
                        @else
                            <span style="color: #f59e0b;">● Occupé</span>
                        @endif
                    </div>
                    
                    <div class="resource-icon-lg">
                        <i class="fa-solid {{ $resource->type === 'Serveur' ? 'fa-server' : ($resource->type === 'Réseau' ? 'fa-network-wired' : 'fa-database') }}"></i>
                    </div>
                    <p style="opacity: 0.6; font-size: 0.9rem;">ID: #DC-{{ $resource->id }}</p>
                </div>

                <!-- Informations -->
                <div class="resource-info-content">
                    <span class="res-type">{{ $resource->type }}</span>
                    <h1 class="res-title">{{ $resource->name }}</h1>
                    
                    <p class="res-description">
                        {{ $resource->description ?? "Équipement haute performance situé dans le Data Center principal. Configuration optimisée pour les charges de travail critiques et la haute disponibilité." }}
                    </p>

                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Localisation</span>
                            <span class="spec-value"><i class="fa-solid fa-location-dot" style="color: #3b82f6;"></i> {{ $resource->location }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Processeur (CPU)</span>
                            <span class="spec-value">{{ $resource->specifications['cpu'] ?? 'N/A' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Mémoire vive (RAM)</span>
                            <span class="spec-value">{{ $resource->specifications['ram'] ?? 'N/A' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Système d'exploitation</span>
                            <span class="spec-value">{{ $resource->specifications['os'] ?? 'Standard DataCore OS' }}</span>
                        </div>
                    </div>

                    <div class="action-bar">
                        @if($resource->status === 'available')
                            <a href="{{ route('reservations.create', $resource->id) }}" class="btn-reserve">
                                <i class="fa-solid fa-calendar-plus"></i> Réserver cet équipement
                            </a>
                        @else
                            <a href="#" class="btn-reserve disabled">
                                <i class="fa-solid fa-ban"></i> Actuellement indisponible
                            </a>
                        @endif
                        <button onclick="window.print()" style="background: none; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; cursor: pointer; color: #64748b;">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>

                    <div class="history-section">
                        <h4 style="font-size: 1rem; margin-bottom: 20px; color: #0f172a;">Historique & Maintenance</h4>
                        <div class="history-item">
                            <span class="history-date">Installé le {{ $resource->created_at->format('d/m/Y') }}</span>
                            <p style="font-size: 0.85rem; margin: 5px 0;">Mise en service initiale et tests de connectivité réussis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

</body>
</html>