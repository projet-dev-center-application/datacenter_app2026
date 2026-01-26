<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations | DataCore Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    @include('partials.header')

    <section class="dashboard-page">
        <div class="container">

            <!-- En-tête de la page -->
            <div class="dashboard-header">
                <div class="header-text">
                    <h2> <img src="../images/server.png" alt="" class="server-icon"> Mes Réservations</h2>
                    <p>Gérez l'historique et le statut de vos demandes de ressources.</p>
                </div>
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Nouvelle Réservation
                </a>
            </div>

            <!-- Messages Flash (Succès / Erreur) -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <!-- CONTENU PRINCIPAL -->
            @if($reservations->isEmpty())
                
                <!-- État Vide (Aucune réservation) -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <h3>Aucune réservation trouvée</h3>
                    <p>Vous n'avez pas encore effectué de demande de ressource.</p>
                    <a href="{{ route('reservations.create') }}" class="btn btn-outline">Commencer maintenant</a>
                </div>

            @else

                <!-- Tableau des Réservations -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Ressource</th>
                                <th>Période</th>
                                <th>Projet / Motif</th>
                                <th>Statut</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <!-- Colonne Ressource -->
                                    <td>
                                        <div class="res-info">
                                            <div class="res-icon-small">
                                                <i class="fa-solid fa-server"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $reservation->resource->name ?? 'Ressource Inconnue' }}</strong>
                                                <span class="res-type">{{ $reservation->resource->type ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Colonne Période -->
                                    <td>
                                        <div class="date-info">
                                            <span><i class="fa-regular fa-calendar"></i> {{ $reservation->start_date?->format('d/m/Y H:i') }}</span>
                                            <span class="date-arrow">➔</span>
                                            <span><i class="fa-regular fa-calendar-check"></i> {{ $reservation->end_date?->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </td>

                                    <!-- Colonne Motif -->
                                    <td>
                                        <span class="purpose-text">{{ Str::limit($reservation->purpose, 30) }}</span>
                                    </td>

                                    <!-- Colonne Statut (Badges) -->
                                    <td>
                                        @php
                                            $statusClass = match($reservation->status) {
                                                'approved' => 'badge-success',
                                                'rejected' => 'badge-danger',
                                                'cancelled' => 'badge-secondary',
                                                default => 'badge-warning',
                                            };

                                            $statusText = match($reservation->status) {
                                                'approved' => 'Validée',
                                                'rejected' => 'Refusée',
                                                'cancelled' => 'Annulée',
                                                'pending' => 'En attente',
                                                default => 'Inconnu',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>

                                    <!-- Colonne Actions -->
                                    <td class="text-right">
                                        <div class="action-buttons">
                                            <!-- Voir -->
                                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn-icon" title="Voir détails">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <!-- Modifier (Seulement si en attente) -->
                                            @if($reservation->status === 'pending')
                                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn-icon info" title="Modifier">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                
                                                <!-- Annuler (Formulaire requis pour POST) -->
                                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon danger" title="Annuler">
                                                        <i class="fa-regular fa-circle-xmark"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $reservations->links() }}
                </div>

            @endif
        </div>
    </section>

    @include('partials.footer')
</body>
</html>