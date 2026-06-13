<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // POST /api/auth/register
    public function register(Request $request)
    {
        // Validácia vstupov; pri chybe Laravel vráti 422
        $data = $request->validate([
            'meno'       => 'required|string|max:255',
            'priezvisko' => 'nullable|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => ['required', 'confirmed', Password::min(8)], // očakáva password_confirmation
            'rola'       => 'required|in:student,vedouci,firma,mentor',  // len povolené roly
            // voliteľné profilové polia
            'telefon'    => 'nullable|string|max:50',
            'ico'        => 'nullable|string|max:20',
            'sektor'     => 'nullable|string|max:255',
            'popis'      => 'nullable|string|max:2000',
        ]);

        $user = User::create([
            'meno'       => $data['meno'],
            'priezvisko' => $data['priezvisko'] ?? '',
            'email'      => $data['email'],
            'password'   => $data['password'], // zahashuje sa cez cast
            'rola'       => $data['rola'],
            'telefon'    => $data['telefon'] ?? '',
            'ico'        => $data['ico'] ?? '',
            'sektor'     => $data['sektor'] ?? '',
            'popis'      => $data['popis'] ?? null,
        ]);

        // Sanctum token pre okamžité prihlásenie
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json(['user' => $this->verejnyUser($user), 'token' => $token], 201);
    }

    // POST /api/auth/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        // jednotná hláška — nezrádzame, či existuje email alebo heslo
        if (! $user || ! \Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Nesprávny e-mail alebo heslo.'], 401);
        }

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json(['user' => $this->verejnyUser($user), 'token' => $token]);
    }

    // GET /api/auth/me — vráti prihláseného používateľa
    public function me(Request $request)
    {
        return response()->json($this->verejnyUser($request->user()));
    }

    // POST /api/auth/logout — zruší aktuálny token
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Odhlásené.']);
    }

    // pomocná funkcia: tvar používateľa pre frontend
    private function verejnyUser(User $u): array
    {
        return [
            'id'         => $u->id,
            'meno'       => $u->cele_meno,
            'email'      => $u->email,
            'rola'       => $u->rola,
            'telefon'    => $u->telefon,
            'adresa'     => $u->adresa,
            'ico'        => $u->ico,
            'sektor'     => $u->sektor,
            'web'        => $u->web,
            'popis'      => $u->popis,
        ];
    }
}