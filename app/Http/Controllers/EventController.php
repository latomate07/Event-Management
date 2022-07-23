<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\EventList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{   
    /**
     * Function index()
     * Récupère et renvoie les évenements disponible
     */
    public function index() {
        $eventList = EventList::with('user')->latest()->paginate(3);
        $todayEvents = EventList::with('user')->where('event_start', '=', date('Y-m-d'))->get(); // Récupérer les évenements d'aujourd'hui
        $futurEvents = EventList::with('user')->where('event_start', '>', date('Y-m-d'))->get(); // Récupérer les évenements à venir

        return Inertia::render('Events', [
            "allEvents" => $eventList,
            "todayEvents" => $todayEvents,
            "futurEvents" => $futurEvents
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
  
        EventList::create($request->all());
  
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
            EventList::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('message', 'Mis à jour effectuée avec succès.');
        }
    }

    /****
     * function deleteEvent => Consiste à supprimer un évenement
     * Condition recevoir ID de l'évenement
     */
    public function deleteEvent(Request $request) {
        $request->has('id') ? 
        EventList::find($request->input('id'))->delete() :
        redirect()->back()->with('errors', 'Une erreur a été produite.');

        return redirect()->back()->with('message', 'Évenement supprimé avec succès.');
    }
}
