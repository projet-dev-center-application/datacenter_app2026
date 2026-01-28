<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // 1. Liste des colonnes modifiables (Mass Assignment)
    protected $fillable = [
        'user_id',
        'resource_id',
        'start_date',
        'end_date',
        'purpose',      // Nom du projet
        'justification', // Justification
        'status',        // 'pending', 'approved', 'rejected'
        'approved_by',
        'rejected_reason',
        'admin_notes'
    ];

    // 2. Gestion automatique des dates (Important pour les comparaisons)
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relation avec le User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relation avec la Ressource
    public function resource() {
        return $this->belongsTo(Resource::class);
    }
     public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
     public function getStatusText()
    {
        switch ($this->status) {
            case 'pending':
                return 'En attente';
            case 'approved':
                return 'Validée';
            case 'rejected':
                return 'Refusée';
            case 'cancelled':
                return 'Annulée';
            default:
                return 'Inconnu';
        }
    }

    // --- 2. Couleur du badge (Bonus pour le design) ---
    public function getStatusClass()
    {
        switch ($this->status) {
            case 'pending':
                return 'warning'; // Jaune/Orange
            case 'approved':
                return 'success'; // Vert
            case 'rejected':
                return 'danger';  // Rouge
            case 'cancelled':
                return 'secondary'; // Gris
            default:
                return 'light';
        }
    }
    public function approve($id) {
    // 1. On valide la réservation
    DB::table('reservations')->where('id', $id)->update(['status' => 'approved']);
    $res = DB::table('reservations')->where('id', $id)->first();

    // 2. ON CRÉE LA NOTIFICATION RÉELLE
    \App\Models\Notification::create([
        'user_id' => $res->user_id,
        'type' => 'reservation',
        'title' => 'Demande Approuvée ✅',
        'message' => 'Votre demande pour l\'équipement a été validée.',
        'is_read' => false,
        'created_at' => now()
    ]);

    return back();
}
}
?>