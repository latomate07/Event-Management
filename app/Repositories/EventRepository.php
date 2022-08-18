<?php 
namespace App\Repositories;

use App\Models\EventModel;

class EventRepository 
{
    /***
     * Function createEvent()
     * Condition => Recevoir la $request
     * Créer un évenement 
     */
    public function createEvent($request) {
        EventModel::create($request->all());
    }

    /***
     * Function createEvent()
     * Condition => Recevoir la $request
     * Créer un évenement 
     */
    public function updateEvent($request) {
        EventModel::find($request->id)->update($request->all());
    }

    /***
     * Function createEvent()
     * Condition => Recevoir la $request
     * Créer un évenement 
     */
    public function deleteEvent($request) {
        EventModel::find($request->id)->delete();
    }

    /****
     * Function eventList()
     * Récupère et envoie au controlleur les derniers évenements crée par un utilisateur
     */
    public function eventList() {
        return EventModel::with('user')->latest()->paginate(3);
    }

     /****
     * Function todayEvents()
     * Récupère et envoie au controlleur les évenements du jour crée par un utilisateur
     */
    public function todayEvents() {
        return EventModel::with('user')->where('event_start', date('Y-m-d'))->get();
    }

     /****
     * Function futurEvents()
     * Récupère et envoie au controlleur les évenements à venir crée par un utilisateur
     */
    public function futurEvents() {
        return EventModel::with('user')->where('event_start', '>', date("Y-m-d"))->get();
    }

    /***
     * DateRangePicker
     * Récupère les informations choisi par l'utilisateur
     * Renvoie les résultats correspondants
     */
    public function scopeFilter($event_start, $event_end) {
        // return EventModel::with('user')->where('event_start', $event_start)->where('event_end', $event_end)->get();

        return EventModel::with('user')->whereBetween('event_start', [$event_start, $event_end])
                                  ->whereBetween('event_end', [$event_start, $event_end])
                                  ->get(); 
    }
}