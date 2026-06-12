<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;

class StartupController extends Controller
{
    // GET /api/startups
    public function index()
    {
        return Startup::orderBy('nazov')->get();
    }

    // GET /api/startups/{startup}
    // Laravel automaticky nájde záznam podľa ID, alebo vráti 404
    public function show(Startup $startup)
    {
        return $startup;
    }
}