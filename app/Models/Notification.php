<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public static function createNotification($userId, $type, $title, $message, $reservationId = null)
    {
        return self::create([
            'user_id' => $userId,
            'reservation_id' => $reservationId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function getIconClass()
    {
        return [
            'reservation_approved' => 'icon-check-circle',
            'reservation_rejected' => 'icon-x-circle',
            'reservation_expiring' => 'icon-clock',
            'reservation_expired' => 'icon-alert-circle',
            'maintenance_scheduled' => 'icon-tool',
            'conflict_detected' => 'icon-alert-triangle',
        ][$this->type] ?? 'icon-bell';
    }

    public function getColorClass()
    {
        return [
            'reservation_approved' => 'text-success',
            'reservation_rejected' => 'text-danger',
            'reservation_expiring' => 'text-warning',
            'reservation_expired' => 'text-secondary',
            'maintenance_scheduled' => 'text-info',
            'conflict_detected' => 'text-warning',
        ][$this->type] ?? 'text-primary';
    }
}
