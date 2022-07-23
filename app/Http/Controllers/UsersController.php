<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\User;


class UsersController extends Controller {
    
    public function index()
    {
        return Inertia::render('Welcome', [
            'users' => User::all()
        ]);
    }
}