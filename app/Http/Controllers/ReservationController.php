<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Reservation::with(['resource', 'approvedBy'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }

        if ($request->has('resource_id') && $request->resource_id != '') {
            $query->where('resource_id', $request->resource_id);
        }

        if ($request->has('date_debut') && $request->date_debut != '') {
            $query->whereDate('date_debut', '>=', $request->date_debut);
        }

        $reservations = $query->paginate(10);
        $resources = Resource::where('statut', 'Disponible')->get();

        return view('reservations.index', compact('reservations', 'resources'));
    }

    public function create($resourceId = null)
    {
        $user = Auth::user();

       if (!auth()->user()->is_active) {
        return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif.');
    }

        $resources = Resource::where('status', 'available')->get();
        $selectedResource = $resourceId ? Resource::find($resourceId) : null;

        return view('reservations.create', compact('resources', 'selectedResource'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->canMakeReservation()) {
            return redirect()->back()->with('error', 'Vous n\'avez pas la permission de faire une réservation.');
        }

        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'justification' => 'required|string|min:10|max:1000',
            'description' => 'nullable|string|max:2000',
        ], [
            'resource_id.required' => 'Veuillez sélectionner une ressource.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début doit être aujourd\'hui ou dans le futur.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.after_or_equal' => 'La date de fin doit être après la date de début.',
            'justification.required' => 'La justification est obligatoire.',
            'justification.min' => 'La justification doit contenir au moins 10 caractères.',
        ]);

        $resource = Resource::find($validated['resource_id']);
        if ($resource->statut !== 'Disponible') {
            return redirect()->back()
                ->with('error', 'Cette ressource n\'est pas disponible.')
                ->withInput();
        }

        if (Reservation::hasConflict($validated['resource_id'], $validated['date_debut'], $validated['date_fin'])) {
            $conflicts = Reservation::getConflicts($validated['resource_id'], $validated['date_debut'], $validated['date_fin']);
            
            return redirect()->back()
                ->with('error', 'Cette ressource est déjà réservée pour cette période.')
                ->with('conflicts', $conflicts)
                ->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'resource_id' => $validated['resource_id'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'heure_debut' => $validated['heure_debut'],
            'heure_fin' => $validated['heure_fin'],
            'justification' => $validated['justification'],
            'description' => $validated['description'],
            'statut' => 'pending',
        ]);

        Notification::createNotification(
            $user->id,
            'reservation_created',
            'Réservation créée',
            "Votre demande de réservation pour {$resource->nom} a été créée avec succès. Elle est en attente d'approbation.",
            $reservation->id
        );

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Votre demande de réservation a été créée avec succès.');
    }

    public function show($id)
    {
        $reservation = Reservation::with(['resource', 'user', 'approvedBy'])->findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id && !$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::with('resource')->findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres réservations.');
        }

        if (!$reservation->canBeModified()) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être modifiée.');
        }

        $resources = Resource::where('statut', 'Disponible')->get();

        return view('reservations.edit', compact('reservation', 'resources'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403);
        }

        if (!$reservation->canBeModified()) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'justification' => 'required|string|min:10|max:1000',
            'description' => 'nullable|string|max:2000',
        ]);

        if (Reservation::hasConflict($reservation->resource_id, $validated['date_debut'], $validated['date_fin'], $id)) {
            return redirect()->back()
                ->with('error', 'Cette ressource est déjà réservée pour cette période.')
                ->withInput();
        }

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'La réservation a été modifiée avec succès.');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403);
        }

        if (!$reservation->canBeCancelled()) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        $reservation->update(['statut' => 'cancelled']);

        Notification::createNotification(
            $user->id,
            'reservation_cancelled',
            'Réservation annulée',
            "Votre réservation pour {$reservation->resource->nom} a été annulée.",
            $reservation->id
        );

        return redirect()->route('reservations.index')
            ->with('success', 'La réservation a été annulée.');
    }

    public function reportIncident(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'incident_report' => 'required|string|min:10|max:2000',
        ]);

        $reservation->update([
            'incident_report' => $validated['incident_report'],
            'incident_reported_at' => now(),
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'L\'incident a été signalé avec succès.');
    }

    public function manage(Request $request)
    {
        $user = Auth::user();

        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403);
        }

        $query = Reservation::with(['resource', 'user'])
            ->orderBy('created_at', 'desc');

        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }

        $reservations = $query->paginate(15);

        return view('reservations.manage', compact('reservations'));
    }

    public function approve(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'response_message' => 'nullable|string|max:1000',
        ]);

        $reservation->update([
            'statut' => 'approved',
            'approved_by' => $user->id,
            'response_message' => $validated['response_message'],
            'responded_at' => now(),
        ]);

        Notification::createNotification(
            $reservation->user_id,
            'reservation_approved',
            'Réservation approuvée',
            "Votre réservation pour {$reservation->resource->nom} a été approuvée.",
            $reservation->id
        );

        return redirect()->back()->with('success', 'La réservation a été approuvée.');
    }

    public function reject(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'response_message' => 'required|string|min:10|max:1000',
        ], [
            'response_message.required' => 'Veuillez fournir une justification pour le refus.',
        ]);

        $reservation->update([
            'statut' => 'rejected',
            'approved_by' => $user->id,
            'response_message' => $validated['response_message'],
            'responded_at' => now(),
        ]);

        Notification::createNotification(
            $reservation->user_id,
            'reservation_rejected',
            'Réservation refusée',
            "Votre réservation pour {$reservation->resource->nom} a été refusée. Raison: {$validated['response_message']}",
            $reservation->id
        );

        return redirect()->back()->with('success', 'La réservation a été refusée.');
    }
}
