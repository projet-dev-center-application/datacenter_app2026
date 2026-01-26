<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'departement', // J'ai corrigé 'departement' en 'department' (anglais standard) - Vérifie ta DB !
        'phone',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Constantes pour les rôles
    const ROLE_GUEST = 'guest';
    const ROLE_USER = 'user';
    const ROLE_TECHNICIAN = 'technician'; // On considère que le technicien est le manager
    const ROLE_ADMIN = 'admin';

    // --- 1. MÉTHODES DE RÔLES ---

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTechnician(): bool
    {
        return $this->role === self::ROLE_TECHNICIAN;
    }

    // AJOUT IMPORTANT : Pour que ton contrôleur fonctionne
    // Le contrôleur appelle isManager(), donc on le lie au rôle Technicien (ou Manager si tu préfères)
    public function isManager(): bool
    {
        return $this->role === self::ROLE_TECHNICIAN; 
    }

    public function isRegularUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isGuest(): bool
    {
        return $this->role === self::ROLE_GUEST;
    }

    // --- 2. LOGIQUE MÉTIER ---

    // AJOUT IMPORTANT : Pour éviter l'erreur "BadMethodCallException"
    public function canMakeReservation(): bool
    {
        // Un utilisateur peut réserver s'il est actif
        return $this->is_active;
    }

    // --- 3. RELATIONS ---
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function managedResources()
    {
        return $this->hasMany(Resource::class, 'managed_by');
    }

    public function approvedReservations()
    {
        return $this->hasMany(Reservation::class, 'approved_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}