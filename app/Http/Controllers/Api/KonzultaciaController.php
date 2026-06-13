<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tim;
use Illuminate\Http\Request;

class KonzultaciaController extends Controller
{
    // POST /api/timy/{tim}/konzultacie — mentor pridá zápis z konzultácie
    public function store(Request $request, Tim $tim)
    {
        // len priradený mentor tímu
        abort_unless($tim->mentor_id === $request->user()->id, 403);

        $data = $request->validate(['text' => 'required|string|max:2000']);

        $tim->konzultacie()->create([
            'mentor_id' => $request->user()->id,
            'text'      => $data['text'],
        ]);

        return response()->json(['message' => 'Zápis pridaný.'], 201);
    }
}