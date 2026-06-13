<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prihlaska;
use Illuminate\Http\Request;

class PrihlaskaController extends Controller
{
    // GET /api/prihlasky — vlastné prihlášky
    public function index(Request $request)
    {
        abort_unless(in_array($request->user()->rola, ['student', 'vedouci']), 403);
        return Prihlaska::where('user_id', $request->user()->id)->orderByDesc('id')->get();
    }

    // POST /api/prihlasky — prihlásenie na vybraný projekt
    public function store(Request $request)
    {
        abort_unless(in_array($request->user()->rola, ['student', 'vedouci']), 403);

        $data = $request->validate([
            'program' => 'required|in:A,B',
            'nazov'   => 'required|string|max:255',   // názov vybraného projektu z ponuky
        ]);

        $prihlaska = Prihlaska::create([
            'user_id' => $request->user()->id,
            'program' => $data['program'],
            'nazov'   => $data['nazov'],
            'stav'    => 'Podaná',
        ]);

        return response()->json($prihlaska, 201);
    }
}