<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Réservation #{{ $reservation->id }} | DataCore Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    @include('partials.header') 

    <section class="reservation-page">
        <div class="container">
            <div class="reservation-layout">
                
                <div class="form-container">
                    
                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div style="background-color: #fef2f2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fca5a5;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- HEADER DU FORMULAIRE -->
                    <div class="form-header" style="margin-bottom: 25px;">
                        <h2 style="display: flex; align-items: center; gap:15px">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 1.5rem; color: #3b82f6;"></i> 
                            Modifier la Réservation 
                        </h2>
                        <p>Vous modifiez actuellement votre demande pour l'équipement <strong>{{ $reservation->resource->name }}</strong>.</p>
                    </div>

                    <!-- FORMULAIRE (Notez le method PUT) -->
                    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="booking-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Choix de la ressource -->
                        <div class="form-group">
                            <label for="resource_id">Ressource souhaitée</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-server input-icon"></i>
                                <select name="resource_id" id="resource_id" class="form-control" required>
                                    @foreach($resources as $resource)
                                        <option value="{{ $resource->id }}" 
                                            {{ old('resource_id', $reservation->resource_id) == $resource->id ? 'selected' : '' }}>
                                            {{ $resource->name }} ({{ $resource->type }} - {{ $resource->location }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Grille pour les dates -->
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="start_date">Date de début</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-calendar input-icon"></i>
                                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" 
                                        value="{{ old('start_date', $reservation->start_date ? $reservation->start_date->format('Y-m-d\TH:i') : '') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Date de fin</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-calendar-check input-icon"></i>
                                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" 
                                        value="{{ old('end_date', $reservation->end_date ? $reservation->end_date->format('Y-m-d\TH:i') : '') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Projet & Motif -->
                        <div class="form-group">
                            <label for="purpose">Nom du Projet / Motif</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-briefcase input-icon"></i>
                                <input type="text" name="purpose" id="purpose" class="form-control" 
                                    value="{{ old('purpose', $reservation->purpose) }}" required>
                            </div>
                        </div>

                        <!-- Justification -->
                        <div class="form-group">
                            <label for="justification">Notes complémentaires (Optionnel)</label>
                            <textarea name="justification" id="justification" class="form-control" rows="4">{{ old('justification', $reservation->justification) }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>

                <!-- Colonne Droite (Sidebar) -->
                <div class="info-sidebar">
                    <div class="info-card" style="background: #fffbeb; padding: 20px; border-radius: 12px; border: 1px solid #fcd34d;">
                        <h3 style="color: #92400e;"><i class="fa-solid fa-triangle-exclamation"></i> Attention</h3>
                        <p style="font-size: 0.9rem; color: #92400e;">
                            Modifier une réservation peut entraîner une nouvelle demande de validation auprès de l'administrateur si le statut était déjà "Approuvé".
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>