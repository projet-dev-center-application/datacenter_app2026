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
    // --- 1. LISTER LES RÉSERVATIONS ---
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Reservation::with(['resource', 'approvedBy'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Correction : 'status' au lieu de 'statut'
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('resource_id') && $request->resource_id != '') {
            $query->where('resource_id', $request->resource_id);
        }

        // Correction : 'start_date' au lieu de 'date_debut'
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        $reservations = $query->paginate(10);
        
        // Correction : 'status' et 'available'
        $resources = Resource::where('status', 'available')->get();

        return view('reservations.index', compact('reservations', 'resources'));
    }

    // --- 2. FORMULAIRE DE CRÉATION ---
    public function create($resourceId = null)
    {
        // Vérification compte actif
        if (!auth()->user()->is_active) {
            return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif.');
        }

        $resources = Resource::where('status', 'available')->get();
        $selectedResource = $resourceId ? Resource::find($resourceId) : null;

        return view('reservations.create', compact('resources', 'selectedResource'));
    }

    // --- 3. ENREGISTRER (STORE) ---
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'resource_id'  => 'required|exists:resources,id',
            'start_date'   => 'required|date|after_or_equal:now',
            'end_date'     => 'required|date|after:start_date',
            'purpose' => 'required|string|max:255', 
            'justification'        => 'nullable|string|max:1000', 
        ]);

        // Vérification conflits
        $exists = Reservation::where('resource_id', $request->resource_id)
            ->where('status', '!=', 'rejected') 
            ->where('status', '!=', 'cancelled') 
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_date', '<', $request->start_date)
                            ->where('end_date', '>', $request->end_date);
                      });
            })
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', '❌ Cette ressource est déjà réservée sur ce créneau.');
        }

        // Création avec Mapping correct
        Reservation::create([
            'user_id'       => Auth::id(),
            'resource_id'   => $validated['resource_id'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'purpose'       => $validated['purpose'], 
            'justification' => $validated['justification'], 
            'status'        => 'pending', 
        ]);

        return back()->with('show_success_modal', true);
    }

    // --- 4. AFFICHER DÉTAILS ---
    public function show($id)
    {
        $reservation = Reservation::with(['resource', 'user', 'approvedBy'])->findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id && !$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('reservations.show', compact('reservation'));
    }

    // --- 5. MODIFIER (EDIT) ---
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres réservations.');
        }

        if (method_exists($reservation, 'canBeModified') && !$reservation->canBeModified()) {
            return redirect()->back()->with('error', 'Cette réservation ne peut plus être modifiée.');
        }

        $resources = Resource::where('status', 'available')->get();

        return view('reservations.edit', compact('reservation', 'resources'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->user_id !== Auth::id()) { abort(403); }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today', 
            'end_date'   => 'required|date|after:start_date',
            'purpose'       => 'required|string|max:255',
            'justification' => 'nullable|string|max:1000',
        ]);
        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'La réservation a été modifiée avec succès.');
    }

    // --- 7. ANNULER ---
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->user_id !== Auth::id()) { abort(403); }

       
        $reservation->update(['status' => 'cancelled']);


        return redirect()->route('reservations.index')
            ->with('success', 'La réservation a été annulée.');
    }

    // --- 8. SIGNALER INCIDENT ---
    public function reportIncident(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        if ($reservation->user_id !== Auth::id()) { abort(403); }

        $validated = $request->validate([
            'incident_report' => 'required|string|min:10|max:2000',
        ]);

        // Assure-toi que la colonne 'incident_reported_at' existe dans ta DB
        $reservation->update([
            'incident_report' => $validated['incident_report'],
            // 'incident_reported_at' => now(), // Décommente si la colonne existe
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'L\'incident a été signalé avec succès.');
    }

    // --- 9. GESTION MANAGER/ADMIN ---
    public function manage(Request $request)
    {
        $user = Auth::user();
        if (!$user->isManager() && !$user->isAdmin()) { abort(403); }

        $query = Reservation::with(['resource', 'user'])->orderBy('created_at', 'desc');

        // Correction : 'status'
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(15);
        return view('reservations.manage', compact('reservations'));
    }

    // --- 10. APPROUVER ---
    public function approve(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();
        
        if (!$user->isManager() && !$user->isAdmin()) { abort(403); }

        // Correction : 'status'
        $reservation->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            // 'responded_at' => now(), // Si la colonne existe
        ]);

        return redirect()->back()->with('success', 'La réservation a été approuvée.');
    }

    // --- 11. REJETER ---
    public function reject(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if (!$user->isManager() && !$user->isAdmin()) { abort(403); }

        $validated = $request->validate([
            'rejected_reason' => 'required|string|min:5|max:1000', // Correspond à ta DB
        ]);

       
        $reservation->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'rejected_reason' => $validated['rejected_reason'],
        ]);

        return redirect()->back()->with('success', 'La réservation a été refusée.');
    }
}