<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\EventModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{   
    protected $event;

    public function __construct()
    {
        $this->event = new EventModel(); // Instancier le model EventModel pour utiliser ses fonctions
    }

    /**
     * Function index()
     * Récupère et renvoie les évenements disponible
     */
    public function index() {
        return Inertia::render('Events', [
            "allEvents" => $this->event->eventList(), // Tout les évenements 
            "todayEvents" => $this->event->todayEvents(), // Les évenements prévu pour aujourd'hui
            "futurEvents" => $this->event->futurEvents() // Les évenements à venir
        ]);
    }
    
    /****
     * function AddEvent => Consiste à ajouter un évenement
     * Condition => recevoir titre et contenu de l'évenement -- Saisi par l'utilisateur
     * Ajouter la date de création et celle de la fin
     */
    public function addEvent(AddEventRequest $request) { // Ajouter un évenement
        $this->event::create($request->all());
  
        return redirect()->back()->with('message', 'Événement crée avec succès !');
    }

    /****
     * function updateEvent => Envoie requête pour mettre à jour dans la BDD
     */
    public function updateEvent(UpdateEventRequest $request) {
        if ($request->has('id')) {
            $this->event::find($request->id)->update($request->all());
            return redirect()->back()->with('message', 'Mise à jour effectuée avec succès.');
        }
    }

    /****
     * function deleteEvent => Consiste à supprimer un évenement
     * Condition => recevoir ID de l'évenement
     */
    public function deleteEvent(Request $request) {
        $request->has('id') ? $this->event::find($request->id)->delete() : redirect()->back()->with('errors', 'Une erreur a été produite.');

        return redirect()->back()->with('message', 'Évenement supprimé avec succès.');
    }

    /***
     * DateRangePicker
     * Condition => recevoir le début et la fin des évenements souhaités
     */
    public function filterEvent(Request $request){
        $start = $request->start;
        $end = $request->end;

        return Inertia::render('Events', [
            "resultOfFilter" => $this->event->scopeFilter($start, $end)
        ]);
    }
}
