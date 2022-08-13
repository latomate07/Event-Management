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

    /****
     * Function eventList()
     * Récupère et envoie au controlleur les derniers évenements crée par un utilisateur
     */
    public function eventList() {
        return $this->with('user')->latest()->paginate(3);
    }

     /****
     * Function todayEvents()
     * Récupère et envoie au controlleur les évenements du jour crée par un utilisateur
     */
    public function todayEvents() {
        return $this->with('user')->where('event_start', date('Y-m-d'))->get();
    }

     /****
     * Function futurEvents()
     * Récupère et envoie au controlleur les évenements à venir crée par un utilisateur
     */
    public function futurEvents() {
        return $this->with('user')->where('event_start', '>', date("Y-m-d"))->get();
    }

    /***
     * DateRangePicker
     * Récupère les informations choisi par l'utilisateur
     * Renvoie les résultats correspondants
     */
    public function scopeFilter($event_start, $event_end) {
        // return $this->with('user')->where('event_start', $event_start)->where('event_end', $event_end)->get();

        return $this->with('user')->whereBetween('event_start', [$event_start, $event_end])
                                  ->whereBetween('event_end', [$event_start, $event_end])
                                  ->get(); 
    }
}
