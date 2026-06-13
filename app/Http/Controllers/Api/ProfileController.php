<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // PUT /api/profil — úprava vlastného profilu (každá rola)
    public function update(Request $request)
    {
        $data = $request->validate([
            'meno'    => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:50',
            'adresa'  => 'nullable|string|max:255',
            'ico'     => 'nullable|string|max:20',
            'sektor'  => 'nullable|string|max:255',
            'web'     => 'nullable|url|max:255',
            'popis'   => 'nullable|string|max:2000',
        ]);

        $user = $request->user();
        // aktualizujeme len odoslané polia (nie celý objekt)
        $user->fill($data)->save();

        return response()->json(['message' => 'Profil uložený.', 'user' => [
            'meno' => $user->cele_meno, 'email' => $user->email, 'rola' => $user->rola,
            'telefon' => $user->telefon, 'adresa' => $user->adresa,
            'ico' => $user->ico, 'sektor' => $user->sektor, 'web' => $user->web, 'popis' => $user->popis,
        ]]);
    }
}