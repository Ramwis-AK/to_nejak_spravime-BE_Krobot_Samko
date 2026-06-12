<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vyzva;

class VyzvaController extends Controller
{
    // GET /api/vyzvy — zoznam (najbližší termín prvý)
    public function index()
    {
        return Vyzva::orderBy('deadline')->get();
    }

    // GET /api/vyzvy/{vyzva} — detail; 404 ak neexistuje
    public function show(Vyzva $vyzva)
    {
        return $vyzva;
    }
}