<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prax;

class PraxController extends Controller
{
    // GET /api/praxe
    public function index()
    {
        return Prax::orderBy('firma')->get();
    }

    // GET /api/praxe/{prax}
    public function show(Prax $prax)
    {
        return $prax;
    }
}