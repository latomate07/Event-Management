<?php
namespace App\Http\Controllers;

class EventController extends Controller
{
    public function index() { // Récupère et Envoie tout les évenements à la vue
        $event = ["title", "content", "created_at"];
        
        return view("home", [
            "title" => "hello",
            "content" => "Aller au marché pour manger des PIZZA haha",
            "created_at" => date("d/m/Y")
        ]);
    }

    /****
     * function AddEvent => Consiste à ajouter un évenement
     * Condition recevoir titre de l'évenement -- Saisi par l'utilisateur
     * Ajouter la date de création
     */
    public function addEvent() { // Ajouter un évenement
        return view("test", ["hello" => "haha"]);
    }

    /****
     * function updateEvent => Consiste à modifier un évenement
     * Condition recevoir ID de l'évenement
     */
    public function updateEvent($id) { // Modifier un évenement
    }
}
