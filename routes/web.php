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