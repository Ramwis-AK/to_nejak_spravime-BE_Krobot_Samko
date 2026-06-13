<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    // GET /api/timy/moj — tím prihláseného vedúceho (alebo null)
    public function moj(Request $request)
    {
        abort_unless($request->user()->rola === 'vedouci', 403);
        $tim = Tim::with(['clenovia', 'milniky', 'mentor'])
            ->where('user_id', $request->user()->id)->first();
        return response()->json($tim ? $this->tvar($tim) : null);
    }

    // POST /api/timy — vedúci vytvorí tím
    public function store(Request $request)
    {
        abort_unless($request->user()->rola === 'vedouci', 403);

        // jeden vedúci = jeden tím
        if (Tim::where('user_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Už máš vytvorený tím.'], 409);
        }

        $data = $request->validate([
            'nazov'   => 'required|string|max:255',
            'projekt' => 'nullable|string|max:255',
            'program' => 'nullable|in:Program A,Program B',
        ]);

        $kod = 'TIM-' . str_pad(Tim::count() + 1, 4, '0', STR_PAD_LEFT);

        $tim = Tim::create([
            'kod'     => $kod,
            'user_id' => $request->user()->id,
            'nazov'   => $data['nazov'],
            'projekt' => $data['projekt'] ?? '',
            'program' => $data['program'] ?? 'Program A',
        ]);

        // vedúci je automaticky prvý člen
        $tim->clenovia()->create(['meno' => $request->user()->cele_meno, 'telefon' => $request->user()->telefon]);

        return response()->json($this->tvar($tim->load(['clenovia', 'milniky', 'mentor'])), 201);
    }

    // POST /api/timy/{tim}/clenovia — pridanie člena (len vlastník tímu)
    public function addClen(Request $request, Tim $tim)
    {
        abort_unless($tim->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'meno'    => 'required|string|max:255',
            'telefon' => 'nullable|string|max:50',
        ]);

        $tim->clenovia()->create(['meno' => $data['meno'], 'telefon' => $data['telefon'] ?? '']);
        return response()->json($this->tvar($tim->fresh(['clenovia', 'milniky', 'mentor'])), 201);
    }

    // GET /api/timy/mentor — tímy, ku ktorým je prihlásený mentor priradený
    public function mentorTimy(Request $request)
    {
        abort_unless($request->user()->rola === 'mentor', 403);
        $timy = Tim::with(['clenovia', 'milniky', 'mentor'])
            ->where('mentor_id', $request->user()->id)->get();
        return response()->json($timy->map(fn ($t) => $this->tvar($t)));
    }

    // POST /api/timy/{tim}/mentor — mentor sa pripojí kódom tímu
    public function joinMentor(Request $request, Tim $tim)
    {
        abort_unless($request->user()->rola === 'mentor', 403);

        if ($tim->mentor_id) {
            return response()->json(['message' => 'Tento tím už má mentora.'], 409);
        }

        $tim->update(['mentor_id' => $request->user()->id]);
        return response()->json(['message' => 'Pripojený k tímu.', 'tim' => $this->tvar($tim->fresh(['clenovia', 'milniky', 'mentor']))]);
    }

    // POST /api/timy/{tim}/milniky — mentor pridá míľnik
    public function addMilnik(Request $request, Tim $tim)
    {
        abort_unless($tim->mentor_id === $request->user()->id, 403);

        $data = $request->validate(['nazov' => 'required|string|max:255']);
        $tim->milniky()->create(['nazov' => $data['nazov'], 'splneny' => false]);

        return response()->json($this->tvar($tim->fresh(['clenovia', 'milniky', 'mentor'])), 201);
    }

    // PATCH /api/timy/{tim}/milniky/{milnik} — mentor schváli míľnik
    public function approveMilnik(Request $request, Tim $tim, \App\Models\Milnik $milnik)
    {
        abort_unless($tim->mentor_id === $request->user()->id, 403);
        // míľnik musí patriť danému tímu
        abort_unless($milnik->tim_id === $tim->id, 404);

        $milnik->update(['splneny' => true]);
        return response()->json($this->tvar($tim->fresh(['clenovia', 'milniky', 'mentor'])));
    }

    // jednotný tvar tímu pre frontend
    private function tvar(Tim $t): array
    {
        return [
            'kod'      => $t->kod,
            'nazov'    => $t->nazov,
            'projekt'  => $t->projekt,
            'program'  => $t->program,
            'vedouci'  => $t->relationLoaded('clenovia') ? optional($t->clenovia->first())->meno : null,
            'mentor'   => $t->mentor?->cele_meno,
            'clenovia' => $t->clenovia->map(fn ($c) => ['meno' => $c->meno, 'telefon' => $c->telefon]),
            'milniky'  => $t->milniky->map(fn ($m) => ['id' => $m->id, 'nazov' => $m->nazov, 'splneny' => (bool) $m->splneny]),
            // NOVÉ: zápisy z konzultácií
            'konzultacie' => $t->konzultacie->map(fn ($k) => ['text' => $k->text, 'datum' => $k->created_at?->format('d.m.Y H:i')]),
        ];
    }
}