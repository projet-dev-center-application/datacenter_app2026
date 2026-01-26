<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réservation | DataCore Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- On inclut le même Header que la page principale -->
    @include('partials.header') 

    <section class="reservation-page">
        <div class="container">
            <div class="reservation-layout">
                <div class="form-container">
    <!-- 1. Message de Succès -->
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #34d399; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-check-circle"></i> 
            <span>{{ session('success') }},veuillez voire plus dans ton dashboard.</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f87171; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-triangle-exclamation"></i> 
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fca5a5;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <i class="fa-solid fa-bug"></i> 
                <strong>Oups ! Veuillez corriger les erreurs suivantes :</strong>
            </div>
            <ul style="margin-left: 30px; list-style-type: disc;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                    <div class="form-header">
                        <h2 style="display: flex; align-items: center;gap:10px">
                        <img src="{{ asset('images/reservation.png') }}" alt="Réserver une Ressource" style="width: 45px"> Réserver une Ressource</h2>
                        <p>Veuillez remplir les détails ci-dessous pour allouer une ressource.</p>
                    </div>

                    <form action="{{ route('reservations.store') }}" method="POST" class="booking-form">
                        @csrf
                        
                        <!-- Choix de la ressource -->
                        <div class="form-group">
    <label for="resource_id">Ressource souhaitée</label>
    <div class="input-wrapper">
        <i class="fa-solid fa-server input-icon"></i>
        
        <select name="resource_id" id="resource_id" class="form-control" required>
            <!-- Option par défaut si aucune ressource n'est pré-sélectionnée -->
            <option value="" disabled {{ is_null($selectedResource) ? 'selected' : '' }}>
                Sélectionner un équipement...
            </option>
            
            @foreach($resources as $resource)
                <option value="{{ $resource->id }}" 
                    {{ (isset($selectedResource) && $selectedResource->id == $resource->id) ? 'selected' : '' }}>
                    
                    {{ $resource->name }} 
                    ({{ $resource->type ?? 'Type inconnu' }} - {{ $resource->location ?? 'Non localisé' }})
                </option>
            @endforeach
        </select>
    </div>

    @if($resources->isEmpty())
        <p style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">
            <i class="fa-solid fa-circle-exclamation"></i> Aucune ressource disponible pour le moment.
        </p>
    @endif
</div>

                        <!-- Grille pour les dates -->
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="start_date">Date de début</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-calendar input-icon"></i>
                                    <input type="datetime-local" name="start_date" id="start_date" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Date de fin</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-calendar-check input-icon"></i>
                                    <input type="datetime-local" name="end_date" id="end_date" required>
                                </div>
                            </div>
                        </div>

                        <!-- Projet & Priorité -->
                        <div class="form-group">
                            <label for="purpose">Nom du Projet / Motif</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-briefcase input-icon"></i>
                                <input type="text" name="purpose" id="purpose" placeholder="Ex: Migration Base de données Prod" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="justification">Notes complémentaires (Optionnel)</label>
                            <textarea name="justification" id="justification" rows="4" placeholder="Besoin d'une configuration réseau spécifique ? Précisez ici."></textarea>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary btn-lg">Confirmer la réservation</button>
                        </div>
                    </form>
                </div>

                <!-- Colonne Droite : Info / Aide -->
                <div class="info-sidebar">
                    <div class="info-card">
                        <h3>ℹ️ Politique de Réservation</h3>
                        <ul>
                            <li><strong>Durée max :</strong> 7 jours consécutifs.</li>
                            <li><strong>Validation :</strong> Les demandes "High Performance" nécessitent l'approbation d'un manager.</li>
                            <li><strong>Annulation :</strong> Possible jusqu'à 2h avant le début.</li>
                        </ul>
                    </div>

                    <div class="info-card status-card">
                        <h3>État du Data Center</h3>
                        <div class="status-item">
                            <span class="dot green"></span>
                            <span>Réseau : <strong>Stable</strong></span>
                        </div>
                        <div class="status-item">
                            <span class="dot orange"></span>
                            <span>Stockage : <strong>Forte demande</strong></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('partials.footer')
@if(session('show_success_modal'))
<div class="modal-overlay" id="successModal">
    <div class="modal-card">
        <!-- Animation de l'icône de succès -->
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>

        <div class="modal-content">
            <h3>Félicitations, {{ Auth::user()->name }} !</h3>
            <p>Votre demande de réservation a été enregistrée avec succès.</p>
            <p class="sub-text">Un administrateur va examiner votre demande sous peu.</p>
            
            <div class="modal-actions">
                <!-- Bouton pour aller voir la liste -->
                <a href="{{ route('reservations.index') }}" class="btn btn-primary btn-modal">
                    Voir mes réservations <i class="fa-solid fa-arrow-right"></i>
                </a>
                
                <!-- Bouton pour fermer et rester ici (Optionnel) -->
                <button onclick="document.getElementById('successModal').style.display='none'" class="btn btn-text">
                    Faire une autre demande
                </button>
            </div>
        </div>
    </div>
</div>
@endif
</body>
</html>