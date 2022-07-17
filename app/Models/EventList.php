<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;

class EventList extends Model
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
        static::creating(function($course) {
            $course->user_id = auth()->id();
        });
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
