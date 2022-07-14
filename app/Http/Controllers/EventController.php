<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\EventList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{   
        public function index() {
        $eventList = EventList::with('user')->get();

        return Inertia::render('Events', [
            "allEvents" => $eventList,
        ]);
    }
    
    /****
     * function AddEvent => Consiste à ajouter un évenement
     * Condition recevoir titre de l'évenement -- Saisi par l'utilisateur
     * Ajouter la date de création
     */
    public function addEvent(Request $request) { // Ajouter un évenement
        $validator = Validator::make($request->all(), [
            'event_name' => ['required'],
            'event_container' => ['required'],
            'event_start' => ['required'],
            'event_end' => ['required']
        ])->validate();
  
        EventList::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Événement crée avec succès !.');
    }

    /****
     * function updateEvent => Consiste à modifier un évenement
     * Condition recevoir ID de l'évenement
     */
    public function updateEvent(Request $request) { // Modifier un évenement
        Validator::make($request->all(), [
            'title' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            EventList::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Mis à jour effectuée avec succès.');
        }
    }

    /****
     * function updateEvent => Consiste à modifier un évenement
     * Condition recevoir ID de l'évenement
     */
    public function deleteEvent(Request $request) { // Modifier un évenement
        $request->has('id') ? 
        EventList::find($request->input('id'))->delete() :
        redirect()->back()
            ->with('errors', 'Somethings goes wrong.');

        return redirect()->back()
            ->with('message', 'Article deleted successfully.');
    }

}
