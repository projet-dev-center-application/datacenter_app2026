<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   
    public $timestamps = false; 

    protected $fillable = [
        'user_id', 'type', 'title', 'message', 
        'related_type', 'related_id', 'is_read', 
        'read_at', 'created_at'
    ];

    // Relation avec l'utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }
}