<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'specifications',
        'location',
        'description',
        'image_url',
    ];

    protected $casts = [
        'specifications' => 'array',
    ];
}