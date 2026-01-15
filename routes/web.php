<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/loading', function () {
    return view('loading');
})->name('loading');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


    // ========================
    // Ressources (Personne 2)
    // ========================
    Route::get('/catalogue', [ResourceController::class, 'index'])->name('resources.index');
    Route::post('/resources/store', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/edit/{id}', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::post('/resources/update/{id}', [ResourceController::class, 'update'])->name('resources.update');
    Route::get('/resources/delete/{id}', [ResourceController::class, 'destroy'])->name('resources.delete');
    Route::get('/resources/show/{id}', [ResourceController::class, 'show'])->name('resources.show');

    // ========================
    // Réservations (Personne 3)
    // ========================
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{resource_id?}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::post('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/reservations/{id}/report-incident', [ReservationController::class, 'reportIncident'])->name('reservations.report-incident');

    // ========================
    // Managers & Admins
    // ========================
    Route::middleware(['role:manager,admin'])->group(function () {
        Route::get('/reservations/manage/all', [ReservationController::class, 'manage'])->name('reservations.manage');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    });
    // Routes protégées par authentification ET activation
Route::middleware(['auth', 'user.active'])->group(function () {
    
    Route::get('/dashboard', function () {
        // Vérifier le rôle de l'utilisateur
        if (auth()->user()->role === 'admin') {
            return view('admin.dashboard'); // Tableau de bord admin
        } else {
            return view('dashboard'); // Tableau de bord utilisateur normal
        }
    })->name('dashboard');
    
    // ... toutes vos autres routes protégées (ressources, réservations, etc.)
});
    // ========================
    // Admin
    // ========================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.index');
        })->name('admin.index');
    });
