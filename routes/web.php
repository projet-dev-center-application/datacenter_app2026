<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| 1. Routes Publiques 
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/catalogue', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/show/{id}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. Routes Protégées (Utilisateurs connectés et actifs)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'user.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{resource_id?}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/notifications/mark-read', [DashboardController::class, 'markNotificationsRead'])->name('notifications.markRead');
    
    Route::post('/reservations/{id}/report-incident', [ReservationController::class, 'reportIncident'])->name('reservations.report-incident');

    /*
    |--------------------------------------------------------------------------
    | 3. Routes Techniciens & Admins (Correction : technician au lieu de manager)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:manager,admin'])->group(function () {
        Route::post('/resources/store', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('/resources/edit/{id}', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::post('/resources/update/{id}', [ResourceController::class, 'update'])->name('resources.update');
        Route::get('/resources/delete/{id}', [ResourceController::class, 'destroy'])->name('resources.delete');

        Route::get('/reservations/manage/all', [ReservationController::class, 'manage'])->name('reservations.manage');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin-panel', [DashboardController::class, 'index'])->name('admin.index');
    });

});