<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vyzva;

class VyzvaController extends Controller
{
    // GET /api/vyzvy — najbližšie termíny prvé
    public function index()
    {
        return Vyzva::orderBy('deadline')->get();
    }
}