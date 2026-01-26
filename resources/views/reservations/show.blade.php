<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Réservation #{{ $reservation->id }} | DataCore</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    @include('partials.header')

    <section class="details-page">
        <div class="container">
            
            <!-- Fil d'ariane et Titre -->
            <div class="details-header">
                <a href="{{ route('reservations.index') }}" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Retour à mes réservations
                </a>
                <div class="header-title">
                    <h2>Réservation <span class="ref-number">#{{ $reservation->id }}</span></h2>
                    <span class="date-creation">Créée le {{ $reservation->created_at?->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <!-- Messages Flash -->
            @if(session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-check"></i> {{ session('success') }}</div>
            @endif

            <div class="details-grid">
                
                <!-- COLONNE GAUCHE : DÉTAILS DU PROJET -->
                <div class="details-main card">
                    <div class="card-header">
                        <h3><i class="fa-solid fa-clipboard-list"></i> Informations Générales</h3>
                    </div>
                    
                    <div class="card-body">
                        <!-- Chronologie Visuelle -->
                        <div class="timeline-box">
                            <div class="time-point start">
                                <span class="time-label">Début</span>
                                <strong class="time-value">{{ $reservation->start_date?->format('d/m/Y') }}</strong>
                                <span class="time-hour">{{ $reservation->start_date?->format('H:i') }}</span>
                            </div>
                            <div class="time-line">
                                <span class="duration-badge">
                                    {{ $reservation->start_date?->diffInDays($reservation->end_date) }} Jours
                                </span>
                                <div class="line-graphic"></div>
                            </div>
                            <div class="time-point end">
                                <span class="time-label">Fin</span>
                                <strong class="time-value">{{ $reservation->end_date?->format('d/m/Y') }}</strong>
                                <span class="time-hour">{{ $reservation->end_date?->format('H:i') }}</span>
                            </div>
                        </div>

                        <hr class="divider">

                        <!-- Infos Projet -->
                        <div class="info-group">
                            <label>Projet / Motif</label>
                            <p class="big-text">{{ $reservation->purpose }}</p>
                        </div>

                        <div class="info-group">
                            <label>Notes & Justification</label>
                            <div class="notes-box">
                                @if($reservation->justification)
                                    "{{ $reservation->justification }}"
                                @else
                                    <span class="text-muted">Aucune note complémentaire fournie.</span>
                                @endif
                            </div>
                        </div>

                        <!-- Si Approuvé/Rejeté : Afficher par qui -->
                        @if($reservation->approvedBy)
                            <div class="admin-feedback {{ $reservation->status }}">
                                <strong><i class="fa-solid fa-user-shield"></i> Traité par :</strong> {{ $reservation->approvedBy->name }}
                                @if($reservation->rejected_reason)
                                    <p class="reason">Motif : {{ $reservation->rejected_reason }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Actions (Uniquement si en attente) -->
                    @if($reservation->status === 'pending')
                    <div class="card-footer">
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-outline">
                            <i class="fa-solid fa-pen"></i> Modifier
                        </a>
                        
                        <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('Annuler définitivement ?');">
                            @csrf
                            <button type="submit" class="btn btn-danger-outline">
                                <i class="fa-solid fa-times"></i> Annuler
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- COLONNE DROITE : RESSOURCE & STATUT -->
                <div class="details-sidebar">
                    
                    <!-- Carte Statut -->
                    <div class="card status-card-box {{ $reservation->status }}">
                        <div class="status-icon">
                            @if($reservation->status == 'approved') <i class="fa-solid fa-check"></i>
                            @elseif($reservation->status == 'rejected') <i class="fa-solid fa-xmark"></i>
                            @elseif($reservation->status == 'cancelled') <i class="fa-solid fa-ban"></i>
                            @else <i class="fa-solid fa-clock"></i>
                            @endif
                        </div>
                        <div class="status-text">
                            <span>Statut actuel</span>
                            <h3>
                                @switch($reservation->status)
                                    @case('approved') Validée @break
                                    @case('rejected') Refusée @break
                                    @case('cancelled') Annulée @break
                                    @default En attente
                                @endswitch
                            </h3>
                        </div>
                    </div>

                    <!-- Carte Ressource -->
                   <div class="card resource-mini-card">
    <div class="res-image-placeholder">
        <i class="fa-solid fa-server"></i>
    </div>
    
    <div class="res-header">
        <h4>{{ $reservation->resource->name }}</h4>
        <span class="res-meta">{{ $reservation->resource->type ?? 'Équipement' }}</span>
        
        <div class="res-loc">
            <i class="fa-solid fa-location-dot"></i> {{ $reservation->resource->location ?? 'Non localisé' }}
        </div>
    </div>

    <hr style="margin-top: 20px; margin-bottom: 20px;">

    <!-- Description -->
    <div class="res-details-block">
        <h5><i class="fa-regular fa-file-lines"></i> Description</h5>
        <p>
            {{ $reservation->resource->description ?? 'Aucune description disponible pour cette ressource.' }}
        </p>
    </div>

    <!-- Spécifications Techniques -->
   @if($reservation->resource->specifications)
    <div class="res-details-block">
        <h5><i class="fa-solid fa-microchip"></i> Spécifications</h5>
        <div class="specs-box" style="background: #f1f5f9; padding: 10px; border-radius: 5px;">
            @if(is_array($reservation->resource->specifications))
                @foreach($reservation->resource->specifications as $key => $value)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <strong style="text-transform: uppercase; font-size: 0.8rem; color: #64748b;">{{ $key }} :</strong>
                        <span style="font-weight: 600; color: #1e293b;">{{ $value }}</span>
                    </div>
                @endforeach
            @else
                {{ $reservation->resource->specifications }}
            @endif
        </div>
    </div>
    @endif
    
    <!-- Bouton Voir Fiche  -->
     <a href="#" class="btn-text-small">Voir la fiche complète</a>
</div>
                    <!-- Contact Support -->
                    <div class="support-box">
                        <p>Un problème avec cette réservation ?</p>
                        <a href="#" class="link-support">Contacter le support IT</a>
                    </div>

                </div>

            </div>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>