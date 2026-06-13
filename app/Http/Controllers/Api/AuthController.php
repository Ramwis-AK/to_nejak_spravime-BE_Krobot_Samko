<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // POST /api/auth/register
    public function register(Request $request)
    {
        $data = $request->validate([
            'meno'       => 'required|string|max:255',
            'priezvisko' => 'nullable|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => ['required', 'confirmed', Password::min(8)],
            'rola'       => 'required|in:student,vedouci,firma,mentor',
            'telefon'    => 'nullable|string|max:50',
            'ico'        => 'nullable|string|max:20',
            'sektor'     => 'nullable|string|max:255',
            'popis'      => 'nullable|string|max:2000',
        ]);

        // jednorazový token na overenie e-mailu
        $verifikacnyToken = Str::random(64);

        $user = User::create([
            'meno'       => $data['meno'],
            'priezvisko' => $data['priezvisko'] ?? '',
            'email'      => $data['email'],
            'password'   => $data['password'],
            'rola'       => $data['rola'],
            'telefon'    => $data['telefon'] ?? '',
            'ico'        => $data['ico'] ?? '',
            'sektor'     => $data['sektor'] ?? '',
            'popis'      => $data['popis'] ?? null,
            'verifikacny_token'  => $verifikacnyToken,
            'email_verified_at'  => null, // zatiaľ neoverený
        ]);

        // "odoslanie" e-mailu — zapíše sa do storage/logs/laravel.log
        Log::info("Overovací odkaz pre {$user->email}: /overit/{$verifikacnyToken}");

        // NEvraciame auth token — používateľ sa musí najprv overiť.
        // verify_token vraciame len pre pohodlie počas vývoja (v produkcii odstrániť).
        return response()->json([
            'message' => 'Registrácia úspešná. Over si e-mail.',
            'verify_token' => $verifikacnyToken,
        ], 201);
    }

    // GET /api/auth/verify/{token} — overenie e-mailu
    public function verify(string $token)
    {
        $user = User::where('verifikacny_token', $token)->first();
        if (! $user) {
            return response()->json(['message' => 'Neplatný alebo už použitý odkaz.'], 404);
        }

        $user->update([
            'email_verified_at' => now(),
            'verifikacny_token' => null, // token je jednorazový
        ]);

        return response()->json(['message' => 'E-mail bol overený. Teraz sa môžeš prihlásiť.']);
    }

    // POST /api/auth/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Nesprávny e-mail alebo heslo.'], 401);
        }

        // blokuj prihlásenie, kým nie je e-mail overený
        if (! $user->email_verified_at) {
            return response()->json(['message' => 'Najprv si over e-mail.'], 403);
        }

        $token = $user->createToken('auth')->plainTextToken;
        return response()->json(['user' => $this->verejnyUser($user), 'token' => $token]);
    }

    // GET /api/auth/me
    public function me(Request $request)
    {
        return response()->json($this->verejnyUser($request->user()));
    }

    // POST /api/auth/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Odhlásené.']);
    }

    private function verejnyUser(User $u): array
    {
        return [
            'id' => $u->id, 'meno' => $u->cele_meno, 'email' => $u->email, 'rola' => $u->rola,
            'telefon' => $u->telefon, 'adresa' => $u->adresa, 'ico' => $u->ico,
            'sektor' => $u->sektor, 'web' => $u->web, 'popis' => $u->popis,
        ];
    }
}