<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prihlaska;
use App\Models\Audit;
use Illuminate\Http\Request;

class PrihlaskaController extends Controller
{
    // GET /api/prihlasky — vlastné prihlášky študenta
    public function index(Request $request)
    {
        abort_unless($request->user()->rola === 'student', 403);
        return Prihlaska::where('user_id', $request->user()->id)->orderByDesc('id')->get();
    }

    // POST /api/prihlasky — prihlásenie (max 1x na projekt)
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
            )->exists();

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

    // ---- FIRMA ----
    public function firemne(Request $request)
    {
        abort_unless($request->user()->rola === 'firma', 403);

        return Prihlaska::whereHas('prax', fn ($q) => $q->where('user_id', $request->user()->id))
            ->with('user')->orderByDesc('id')->get()
            ->map(fn ($p) => $this->tvarSDokumentmi($p));
    }

    public function rozhodnut(Request $request, Prihlaska $prihlaska)
    {
        abort_unless($request->user()->rola === 'firma', 403);
        abort_unless($prihlaska->prax && $prihlaska->prax->user_id === $request->user()->id, 403);

        $data = $request->validate(['stav' => 'required|in:Schválená,Zamietnutá']);
        $prihlaska->update(['stav' => $data['stav']]);
        Audit::zapis($request->user()->id, "Firma: {$data['stav']} prihlášku", $prihlaska->nazov);

        return response()->json(['stav' => $prihlaska->stav]);
    }

    // ---- ADMIN ----
    public function adminVsetky(Request $request)
    {
        abort_unless($request->user()->rola === 'admin', 403);
        return Prihlaska::with('user')->orderByDesc('id')->get()
            ->map(fn ($p) => [
                'id' => $p->id, 'nazov' => $p->nazov, 'program' => $p->program,
                'stav' => $p->stav, 'student' => optional($p->user)->cele_meno,
            ]);
    }

    public function adminStav(Request $request, Prihlaska $prihlaska)
    {
        abort_unless($request->user()->rola === 'admin', 403);
        $data = $request->validate(['stav' => 'required|in:Podaná,Schválená,Zamietnutá,Onboarding,Ukončená']);
        $prihlaska->update(['stav' => $data['stav']]);
        Audit::zapis($request->user()->id, "Admin: zmena stavu na {$data['stav']}", $prihlaska->nazov);
        return response()->json(['stav' => $prihlaska->stav]);
    }

    // ---- KOMISIA (Program A) ----
    public function komisiaPrihlasky(Request $request)
    {
        abort_unless($request->user()->rola === 'komisia', 403);
        return Prihlaska::where('program', 'A')->with('user')->orderByDesc('id')->get()
            ->map(fn ($p) => [
                'id' => $p->id, 'nazov' => $p->nazov, 'stav' => $p->stav,
                'skore' => $p->skore, 'komentar' => $p->komentar,
                'student' => optional($p->user)->cele_meno,
            ]);
    }

    public function komisiaHodnotit(Request $request, Prihlaska $prihlaska)
    {
        abort_unless($request->user()->rola === 'komisia', 403);
        abort_unless($prihlaska->program === 'A', 422, 'Komisia hodnotí len Program A.');

        $data = $request->validate([
            'stav'     => 'required|in:Schválená,Zamietnutá',
            'skore'    => 'nullable|integer|min:0|max:100',
            'komentar' => 'nullable|string|max:1000',
        ]);
        $prihlaska->update($data);
        Audit::zapis($request->user()->id, "Komisia: {$data['stav']} (skóre {$prihlaska->skore})", $prihlaska->nazov);

        return response()->json($prihlaska);
    }

    // pomocný tvar s kontaktom + dokumentmi (pre firmu)
    private function tvarSDokumentmi(Prihlaska $p): array
    {
        $u = $p->user;
        return [
            'id' => $p->id, 'nazov' => $p->nazov, 'program' => $p->program, 'stav' => $p->stav,
            'student' => optional($u)->cele_meno, 'email' => optional($u)->email, 'telefon' => optional($u)->telefon,
            'dokumenty' => $u ? \App\Models\Dokument::where('user_id', $u->id)->get(['id', 'nazov']) : [],
        ];
    }
}