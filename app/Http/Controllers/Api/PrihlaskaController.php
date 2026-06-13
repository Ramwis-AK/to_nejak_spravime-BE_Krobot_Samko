<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prihlaska;
use Illuminate\Http\Request;

class PrihlaskaController extends Controller
{
    // GET /api/prihlasky — vlastné prihlášky (student / vedúci)
    public function index(Request $request)
    {
        abort_unless(in_array($request->user()->rola, ['student', 'vedouci']), 403);
        return Prihlaska::where('user_id', $request->user()->id)->orderByDesc('id')->get();
    }

    // POST /api/prihlasky — podanie prihlášky
    public function store(Request $request)
    {
        abort_unless(in_array($request->user()->rola, ['student', 'vedouci']), 403);

        $data = $request->validate([
            'program'   => 'required|in:A,B',
            'nazov'     => 'required|string|max:255',
            'popis'     => 'nullable|string|max:2000',
            'oblast'    => 'nullable|string|max:255',
            'motivacia' => 'nullable|string|max:2000',
        ]);

        $prihlaska = Prihlaska::create([
            'user_id'   => $request->user()->id,
            'program'   => $data['program'],
            'nazov'     => $data['nazov'],
            'popis'     => $data['popis'] ?? null,
            'oblast'    => $data['oblast'] ?? '',
            'motivacia' => $data['motivacia'] ?? null,
            'stav'      => 'Podaná',
        ]);

        return response()->json($prihlaska, 201);
    }
}