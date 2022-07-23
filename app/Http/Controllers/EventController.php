<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EventModel;

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
    public function addEvent(Request $request) { // Ajouter un évenement
        $validator = Validator::make($request->all(), [
            'event_name' => ['required'],
            'event_content' => ['required'],
            'event_start' => ['required'],
            'event_end' => ['required']
        ])->validate();
  
        $this->event::create($request->all());
  
        return redirect()->back()->with('message', 'Événement crée avec succès !');
    }

    /****
     * function updateEvent => Envoie requête pour mettre à jour dans la BDD
     */
    public function updateEvent(Request $request) {
        Validator::make($request->all(), [
            'event_name' => ['required'],
            'event_content' => ['required'],
            'event_start' => ['required'],
            'event_end' => ['required']
        ])->validate();
  
        if ($request->has('id')) {
            $this->event::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Mise à jour effectuée avec succès.');
        }
    }

    /****
     * function deleteEvent => Consiste à supprimer un évenement
     * Condition recevoir ID de l'évenement
     */
    public function deleteEvent(Request $request) {
        $request->has('id') ? 
        $this->event::find($request->input('id'))->delete() :
        redirect()->back()->with('errors', 'Une erreur a été produite.');

        return redirect()->back()->with('message', 'Évenement supprimé avec succès.');
    }
}
