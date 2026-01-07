<?php
use Illuminate\Support\Facades\Route;

// Page d'accueil (landing page) - TOI
Route::get('/', function () {
    return view('welcome'); // Affiche welcome.blade.php
});

// Page connexion - PERSONNE 1
Route::get('/login', function () {
    return view('auth.login');
});

// Page inscription - PERSONNE 1  
Route::get('/register', function () {
    return view('auth.register');
});

// Page ressources - PERSONNE 2
Route::get('/resources', function () {
    return '<h1>Liste des ressources (à faire par Personne 2)</h1>';
});

// Page réservations - PERSONNE 3
Route::get('/reservations', function () {
    return '<h1>Mes réservations (à faire par Personne 3)</h1>';
});

// Page admin - PERSONNE 4
Route::get('/admin', function () {
    return '<h1>Administration (à faire par Personne 4)</h1>';
});
Route::get('/catalogue', [App\Http\Controllers\ResourceController::class, 'index']);
Route::post('/resources/store', [App\Http\Controllers\ResourceController::class, 'store']);
Route::get('/resources/edit/{id}', [App\Http\Controllers\ResourceController::class, 'edit']);
Route::post('/resources/update/{id}', [App\Http\Controllers\ResourceController::class, 'update']);
Route::get('/resources/delete/{id}', [App\Http\Controllers\ResourceController::class, 'destroy']);
Route::get('/resources/show/{id}', [App\Http\Controllers\ResourceController::class, 'show']);
// ============================================
// ROUTES POUR LE MODULE RÉSERVATIONS
// ============================================

use App\Http\Controllers\ReservationController;

Route::middleware(['auth'])->group(function () {
    
    // Liste des réservations de l'utilisateur
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    
    // Créer une nouvelle réservation
    Route::get('/reservations/create/{resource_id?}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    
    // Voir les détails d'une réservation
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    
    // Modifier une réservation
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::post('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');
    
    // Annuler une réservation
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    // Signaler un incident
    Route::post('/reservations/{id}/report-incident', [ReservationController::class, 'reportIncident'])->name('reservations.report-incident');
    
    // Routes pour les managers et admins
    Route::middleware(['role:manager,admin'])->group(function () {
        Route::get('/reservations/manage/all', [ReservationController::class, 'manage'])->name('reservations.manage');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    });
});
