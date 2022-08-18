<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Repositories\EventRepository;

class EventController extends Controller
{   
    protected $eventRepository;

    public function __construct(EventRepository $event)
    {
        $this->eventRepository = $event;
    }
    /**
     * Function index()
     * Récupère et renvoie les évenements disponible
     */
    public function index() {
        return Inertia::render('Events', [
            "allEvents" => $this->eventRepository->eventList(), // Tout les évenements 
            "todayEvents" => $this->eventRepository->todayEvents(), // Les évenements prévu pour aujourd'hui
            "futurEvents" => $this->eventRepository->futurEvents() // Les évenements à venir
        ]);
    }
    
    /****
     * function AddEvent => Consiste à ajouter un évenement
     * Condition => recevoir titre et contenu de l'évenement -- Saisi par l'utilisateur
     * Ajouter la date de création et celle de la fin
     */
    public function addEvent(AddEventRequest $request) { // Ajouter un évenement
        $this->eventRepository->createEvent($request);

        return redirect()->back()->with('message', 'Événement crée avec succès !');
    }

    /****
     * function updateEvent => Consiste à mettre à jour un évenement
     * Condition => recevoir ID de l'évenement
     */
    public function updateEvent(UpdateEventRequest $request) {
        if ($request->has('id')) {
            $this->eventRepository->updateEvent($request);

            return redirect()->back()->with('message', 'Mise à jour effectuée avec succès.');
        } 
        else {
            return redirect()->back()->withErrors('Une erreur a été produite, veuillez réessayé plus tard.');
        }
    }

    /****
     * function deleteEvent => Consiste à supprimer un évenement
     * Condition => recevoir ID de l'évenement
     */
    public function deleteEvent(Request $request) {
        if($request->has('id')) {
            $this->eventRepository->deleteEvent($request);

            return redirect()->back()->with('message', 'Évenement supprimé avec succès.');
        }
        else {
            return redirect()->back()->withErrors('Une erreur a été produite, veuillez réessayé plus tard.');
        }
    }

    /***
     * DateRangePicker
     * Condition => recevoir le début et la fin des évenements souhaités
     */
    public function filterEvent(Request $request){
        $start = $request->start;
        $end = $request->end;

        return Inertia::render('Events', [
            "resultOfFilter" => $this->eventRepository->scopeFilter($start, $end)
        ]);
    }
}
