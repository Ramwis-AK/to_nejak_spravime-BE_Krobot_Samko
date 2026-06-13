<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prihlaska;
use Illuminate\Http\Request;

class PrihlaskaController extends Controller
{
    // GET /api/prihlasky — vlastné prihlášky študenta
    public function index(Request $request)
    {
        abort_unless($request->user()->rola === 'student', 403);
        return Prihlaska::where('user_id', $request->user()->id)->orderByDesc('id')->get();
    }

    // POST /api/prihlasky — prihlásenie na projekt (max 1x na projekt)
    public function store(Request $request)
    {
        abort_unless($request->user()->rola === 'student', 403);

        $data = $request->validate([
            'program' => 'required|in:A,B',
            'nazov'   => 'required|string|max:255',
            'prax_id' => 'nullable|exists:praxe,id',
        ]);

        $uzExistuje = Prihlaska::where('user_id', $request->user()->id)
            ->when($data['prax_id'] ?? null,
                fn ($q) => $q->where('prax_id', $data['prax_id']),
                fn ($q) => $q->where('program', $data['program'])->where('nazov', $data['nazov'])
            )
            ->exists();

        if ($uzExistuje) {
            return response()->json(['message' => 'Na tento projekt už máš podanú prihlášku.'], 409);
        }

        $prihlaska = Prihlaska::create([
            'user_id' => $request->user()->id,
            'prax_id' => $data['prax_id'] ?? null,
            'program' => $data['program'],
            'nazov'   => $data['nazov'],
            'stav'    => 'Podaná',
        ]);

        return response()->json($prihlaska, 201);
    }

    public function firemne(Request $request)
    {
        abort_unless($request->user()->rola === 'firma', 403);

        return Prihlaska::whereHas('prax', fn ($q) => $q->where('user_id', $request->user()->id))
            ->with('user')
            ->orderByDesc('id')
            ->get()
            ->map(function ($p) {
                $u = $p->user;
                return [
                    'id'        => $p->id,
                    'nazov'     => $p->nazov,
                    'program'   => $p->program,
                    'stav'      => $p->stav,
                    'student'   => optional($u)->cele_meno,
                    'email'     => optional($u)->email,
                    'telefon'   => optional($u)->telefon,
                    'dokumenty' => $u ? \App\Models\Dokument::where('user_id', $u->id)->get(['id', 'nazov']) : [],
                ];
            });
    }

    // PATCH /api/prihlasky/{prihlaska}/stav — firma schváli/zamietne
    public function rozhodnut(Request $request, Prihlaska $prihlaska)
    {
        abort_unless($request->user()->rola === 'firma', 403);
        abort_unless($prihlaska->prax && $prihlaska->prax->user_id === $request->user()->id, 403);

        $data = $request->validate(['stav' => 'required|in:Schválená,Zamietnutá']);
        $prihlaska->update(['stav' => $data['stav']]);

        return response()->json(['stav' => $prihlaska->stav]);
    }
}