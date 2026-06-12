<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KontaktSprava;
use Illuminate\Http\Request;

class KontaktController extends Controller
{
    // POST /api/kontakt — uloží správu z kontaktného formulára
    public function store(Request $request)
    {
        // Validácia vstupov. Pri chybe Laravel sám vráti 422 + zoznam chýb.
        $validated = $request->validate([
            'meno'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'telefon' => 'nullable|string|max:50',
            'tema'    => 'nullable|string|max:255',
            'sprava'  => 'required|string|max:5000',
        ]);

        // Ukladáme iba zvalidované polia (nie celý request) — bezpečnejšie.
        KontaktSprava::create($validated);

        return response()->json(['message' => 'Správa bola odoslaná.'], 201);
    }
}