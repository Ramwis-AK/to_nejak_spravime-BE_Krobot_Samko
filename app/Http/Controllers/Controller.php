<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Novinka;

class NovinkaController extends Controller
{
    // GET /api/novinky  — verejný zoznam, najnovšie prvé
    public function index()
    {
        return Novinka::orderBy('datum', 'desc')->get();
    }

    // GET /api/novinky/{novinka} — detail
    public function show(Novinka $novinka)
    {
        return $novinka;
    }
}