<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Redirection si Admin vers une vue spécifique (si elle existe)
        if ($user->role === 'admin') {
            return view('admin.index'); 
        }

        // 2. Logique pour l'utilisateur normal
        // Suivi des demandes actives
        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->with('resource')
            ->orderBy('start_date', 'asc')
            ->get();

        // 3. Historique avec filtres
        $historyQuery = Reservation::where('user_id', $user->id)
            ->with('resource');

        if ($request->filled('status')) {
            $historyQuery->where('status', $request->status);
        }
        
        if ($request->filled('resource')) {
            $historyQuery->whereHas('resource', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->resource}%");
            });
        }

        $history = $historyQuery->orderBy('created_at', 'desc')->paginate(10);

        // 4. Mini-catalogue ressources disponibles
        $availableResources = Resource::where('status', 'available')->limit(4)->get();

        // 5. Statistiques pour les badges
        $stats = [
            'total' => Reservation::where('user_id', $user->id)->count(),
            'pending' => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Reservation::where('user_id', $user->id)->where('status', 'approved')->count(),
        ];

        // RETOURNE LA VUE DANS LE DOSSIER dashboard FICHIER index.blade.php
        return view('dashboard.index', compact('activeReservations', 'history', 'availableResources', 'stats'));
    }
}