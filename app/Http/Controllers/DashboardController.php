<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ==========================================
        // 1. LOGIQUE POUR L'ADMINISTRATEUR
        // ==========================================
        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalResources = Resource::count();
            $activeReservationsCount = Reservation::where('status', 'approved')->count();
            $occupationRate = ($totalResources > 0) ? round(($activeReservationsCount / $totalResources) * 100) : 0;
            $recentUsers = User::latest()->take(5)->get();
            $resourceStats = Resource::select('type', DB::raw('count(*) as total'))->groupBy('type')->get();

            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $count = Reservation::whereDate('created_at', $date)->count();
                $chartData[] = [
                    'day' => now()->subDays($i)->translatedFormat('D'),
                    'value' => ($totalResources > 0) ? ($count / $totalResources) * 100 : 0
                ];
            }

            return view('admin.index', compact('totalUsers', 'totalResources', 'occupationRate', 'recentUsers', 'resourceStats', 'chartData'));
        }

        // ==========================================
        // 2. LOGIQUE POUR LE MANAGER
        // ==========================================
        if ($user->role === 'manager') {
            $managedResources = Resource::count(); 
            $pendingDemands = Reservation::where('status', 'pending')->with(['user', 'resource'])->get();
            
            $managerStats = [
                'to_review' => $pendingDemands->count(),
                'total_managed' => Resource::count(),
                'active_now' => Reservation::where('status', 'approved')->count()
            ];

            return view('manager.index', compact('managedResources', 'pendingDemands', 'managerStats'));
        }

        // ==========================================
        // 3. LOGIQUE POUR L'UTILISATEUR NORMAL (Par défaut)
        // ==========================================
        
        // Suivi des demandes actives
        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->with('resource')
            ->orderBy('start_date', 'asc')
            ->get();

        // Historique avec filtres
        $historyQuery = Reservation::where('user_id', $user->id)->with('resource');

        if ($request->filled('status')) {
            $historyQuery->where('status', $request->status);
        }
        
        if ($request->filled('resource')) {
            $historyQuery->whereHas('resource', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->resource}%");
            });
        }

        $history = $historyQuery->orderBy('created_at', 'desc')->paginate(10);

        // Ressources disponibles pour le catalogue
        $availableResources = Resource::where('status', 'available')->limit(4)->get();

        // Stats pour les badges
        $stats = [
            'total' => Reservation::where('user_id', $user->id)->count(),
            'pending' => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Reservation::where('user_id', $user->id)->where('status', 'approved')->count(),
        ];

        return view('dashboard.index', compact('activeReservations', 'history', 'availableResources', 'stats'));
    }
    public function markNotificationsRead() {
    \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true, 'read_at' => now()]);
        
    return back()->with('success', 'Notifications marquées comme lues.');
}
}