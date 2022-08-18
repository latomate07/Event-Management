<?php

namespace App\Models;

use auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 'event_lists';
    protected $fillable = [
        'event_name',
        'event_content',
        'event_start',
        'event_end'
    ];
    
    /**
     * Ajouter ID utilisateur à celui qui créer un évenement
     */
    protected static function booted() {
        static::creating(function($events) {
            $events->user_id = auth()->id();
        });
    }

    /**
     * Chaque évenement est relié à un utilisateur
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
