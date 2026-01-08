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
        'departement',
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
    const ROLE_TECHNICIAN = 'technician';
    const ROLE_ADMIN = 'admin';

    // Méthodes de vérification de rôle
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTechnician(): bool
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

    // Relations
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