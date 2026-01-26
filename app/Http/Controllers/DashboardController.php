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

        // 1. Suivi des demandes (Réservations en cours ou futures)
        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->with('resource')
            ->orderBy('start_date', 'asc')
            ->get();

        // 2. Historique des réservations avec filtres
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

        $history = $historyQuery->orderBy('created_at', 'desc')->paginate(5);

        // 3. Ressources disponibles (pour le mini-catalogue)
        $availableResources = Resource::where('status', 'available')->limit(4)->get();

        // 4. Statistiques simples
        $stats = [
            'total' => Reservation::where('user_id', $user->id)->count(),
            'pending' => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Reservation::where('user_id', $user->id)->where('status', 'approved')->count(),
        ];

        return view('dashboard.index', compact('activeReservations', 'history', 'availableResources', 'stats'));
    }
}