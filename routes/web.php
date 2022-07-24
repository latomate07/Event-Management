<?php

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        // 'users' => User::all(), // Récupérer tout les utilisateurs
        'users' => ["barry", "mohamed"]
    ]);
});

Route::get('/events', [EventController::class, "index"]); // Afficher
Route::post('/events/add', [EventController::class, 'addEvent']); // Ajouter
Route::patch('/events/edit/{id}', [EventController::class, 'updateEvent']); // Mettre à jour
Route::delete('/events/delete/{id}', [EventController::class, 'deleteEvent']); // Supprimer
Route::get('/events/filter', [EventController::class, 'filterEvent']); // Filtrer

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

